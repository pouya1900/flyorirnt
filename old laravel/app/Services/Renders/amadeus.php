<?php


namespace App\Services\Renders;


use App\Models\Book;
use App\Models\Cost;
use App\Models\Flight;
use App\Models\FlightAirline;
use App\Models\Leg;
use App\Models\Search;
use App\Models\Session;
use App\Services\MyHelperFunction;
use App\Services\SetPriceFunction;
use Carbon\Carbon;

class amadeus implements render_interface {

	private $session;
	public $base = "https://api.amadeus.com";

	const PUBLISHED = 1;
	const NEGOTIATED = 2;
	const CORPORATE = 3;

	public function __construct($code=0) {


		$service_url = $this->base . '/v1/security/oauth2/token';

//		main
		$client_id     = "w48Wev40cHrKAjLyjlsEWUl1Ktdyfqdm";
		$client_secret = "uxqtJhHM5G2eDyZQ";

//			demo
//		$client_id     = "PqN5BRRCtVCOHD2wxiPoG1V1IOnBzU6w";
//		$client_secret = "NYxOgweTW1NJQ6te";


		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $service_url );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 120 );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_USERPWD, $client_id . ":" . $client_secret );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials" );

		$result   = curl_exec( $ch );
		$response = json_decode( $result, true );
		curl_close( $ch );


		$session = $response["access_token"];

		if ( $session == "" ) {
			dd( "amadeus doesn't work at this time , error handling" );
		}

		$this->session = $session;

	}

	public function redirect_lowfaresearch( $flight_id ) {

		$flight = Flight::with( [ 'costs' ] )->where( 'id', '=', $flight_id )->get();
		$flight = json_decode( json_encode( $flight ), true );
		$flight = $flight[0];


	}


	public function lowfaresearch( $origin, $destination, $depart, $return, $class, $adl, $chl, $inf, $none_stop , $search_id ) {

		switch ( $class ) {
			case "Economy":
				$class = 'ECONOMY';
				break;
			case "Premium":
				$class = 'PREMIUM_ECONOMY';
				break;
			case "Business":
				$class = 'BUSINESS';
				break;
			case "First":
				$class = 'FIRST';
				break;
			default:
				$class = 'ECONOMY';
		}

		$depart = date( 'Y-m-d', strtotime( $depart ) );
		if ( $return != "-" ) {
			$return = date( 'Y-m-d', strtotime( $return ) );
		} else {
			$return = null;
		}

		$adl = intval( $adl );
		$chl = intval( $chl );
		$inf = intval( $inf );


		$service_url = $this->base . '/v2/shopping/flight-offers';


		$array = [

			"currencyCode"       => "EUR",
			"originDestinations" => [
				[
					"id"                      => "1",
					"originLocationCode"      => $origin,
					"destinationLocationCode" => $destination,
					"departureDateTimeRange"  => [
						"date" => $depart
					]
				],
			],
			"travelers"          => [
			],
			"sources"            => [
				"GDS"
			],
			"searchCriteria"     => [
				"maxFlightOffers" => 50,
				"flightFilters"   => [
					"cabinRestrictions" => [
						[
							"cabin"                => $class,
							"coverage"             => "MOST_SEGMENTS",
							"originDestinationIds" => [
								"1"
							]
						]
					]

				]
			]

		];


		if ( $return != null ) {

			$array["originDestinations"][] = [
				"id"                      => "2",
				"originLocationCode"      => $destination,
				"destinationLocationCode" => $origin,
				"departureDateTimeRange"  => [
					"date" => $return
				]
			];

		}
		if ( isset( $none_stop ) and $none_stop == 1 ) {
			$array["searchCriteria"]["flightFilters"]["connectionRestriction"]["maxNumberOfConnections"] = 0;
		}

		$passenger_counter = 1;
		for ( $i = 1; $i <= $adl; $i ++ ) {
			$array["travelers"][] = [
				"id"           => $passenger_counter,
				"travelerType" => "ADULT"
			];
			$passenger_counter ++;
		}
		for ( $i = 1; $i <= $chl; $i ++ ) {
			$array["travelers"][] = [
				"id"           => $passenger_counter,
				"travelerType" => "CHILD"
			];
			$passenger_counter ++;
		}
		for ( $i = 1; $i <= $inf; $i ++ ) {
			$array["travelers"][] = [
				"id"           => $passenger_counter,
				"travelerType" => "SEATED_INFANT"
			];
			$passenger_counter ++;
		}


		$ch1 = curl_init();

		curl_setopt( $ch1, CURLOPT_URL, $service_url );
		curl_setopt( $ch1, CURLOPT_VERBOSE, 1 );
		curl_setopt( $ch1, CURLOPT_HEADER, 0 );
		curl_setopt( $ch1, CURLOPT_CONNECTTIMEOUT, 120 );
		curl_setopt( $ch1, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt( $ch1, CURLOPT_HTTPHEADER, array(
			"Content-Type: application/json",
			"Authorization: Bearer $this->session"
		) );
		curl_setopt( $ch1, CURLOPT_POST, 1 );
		curl_setopt( $ch1, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch1, CURLOPT_POSTFIELDS, json_encode( $array ) );

		$result = curl_exec( $ch1 );
		curl_close( $ch1 );

		$response = json_decode( $result, true );


		if ( ! isset( $response["data"] ) || empty( $response["data"] ) ) {
			return 0;
		}


		$cost_insert          = array();
		$leg_insert           = array();
		$airline_insert       = array();
		$final_airline_insert = array();
		$final_leg_insert     = array();
		$i                    = 0;


		$search_id = Search::new_search();

		$query = "INSERT INTO flights(search_id,render,FareSourceCode,IsPassportMandatory,IsPassportIssueDateMandatory,DirectionInd,RefundMethod,ValidatingAirlineCode,flight_number,depart_time,depart_time_range,depart_airport,arrival_time,arrival_airport,stops,total_time,total_waiting,bar,bar_exist,class,return_flight_number,return_depart_time,return_depart_time_range,return_depart_airport,return_arrival_time,return_arrival_airport,return_stops,return_total_time,return_total_waiting,return_bar,return_bar_exist,return_class,depart_return_time,flight_offers_json) VALUES ($search_id";
		foreach ( $response["data"] as $item ) {

			$flight_offers_json = [
				"type"                   => $item["type"],
				"id"                     => $item["id"],
				"source"                 => $item["source"],
				"validatingAirlineCodes" => $item["validatingAirlineCodes"],
				"travelerPricings"       => $item["travelerPricings"],
				"itineraries"            => $item["itineraries"],
			];
			$flight_offers_json = json_encode( $flight_offers_json );

			if ( $i != 0 ) {
				$query .= ",($search_id";
			}

			$depart_time     = date( "H", strtotime( $item["itineraries"][0]["segments"][0]["departure"]["at"] ) );
			$depart_time_min = date( "i", strtotime( $item["itineraries"][0]["segments"][0]["departure"]["at"] ) );
			$depart_time     += $depart_time_min / 60;
			if ( $depart_time > 0 && $depart_time < 8 ) {
				$depart_range = 0;
			} else if ( $depart_time >= 8 && $depart_time < 12 ) {
				$depart_range = 1;
			} else if ( $depart_time >= 12 && $depart_time <= 18 ) {
				$depart_range = 2;
			} else if ( $depart_time > 18 && $depart_time <= 24 ) {
				$depart_range = 3;
			}

			$j                               = 0;
			$total_fly_time_segments_per_min = 0;
			foreach ( $item["itineraries"][0]["segments"] as $key => $segment ) {

				$connection_time_per_min = 0;
				if ( $key != sizeof( $item["itineraries"][0]["segments"] ) - 1 ) {
					$helper_date             = new Carbon( $item["itineraries"][0]["segments"][ $key + 1 ]["departure"]["at"] );
					$connection_time_per_min = $helper_date->diffInMinutes( $segment["arrival"]["at"] );
				}
				$airline_insert[ $i ][ $j ]["airline_code"] = $segment["carrierCode"];
				$airline_insert[ $i ][ $j ]["is_return"]    = 0;

				$leg_insert[ $i ][ $j ]["seats_remaining"]     = $item["numberOfBookableSeats"];
				$leg_insert[ $i ][ $j ]["leg_flight_number"]   = $segment["number"];
				$leg_insert[ $i ][ $j ]["cabin_class"]         = MyHelperFunction::turn_class_to_code( $item["travelerPricings"][0]["fareDetailsBySegment"][ $j ]["cabin"] );
				$leg_insert[ $i ][ $j ]["leg_depart_time"]     = $segment["departure"]["at"];
				$leg_insert[ $i ][ $j ]["leg_depart_airport"]  = $segment["departure"]["iataCode"];
				$leg_insert[ $i ][ $j ]["leg_arrival_time"]    = $segment["arrival"]["at"];
				$leg_insert[ $i ][ $j ]["leg_arrival_airport"] = $segment["arrival"]["iataCode"];
				$leg_insert[ $i ][ $j ]["leg_time"]            = MyHelperFunction::ISO8601ToMin( $segment["duration"] );
				$leg_insert[ $i ][ $j ]["leg_waiting"]         = $connection_time_per_min;
				$leg_insert[ $i ][ $j ]["leg_airline_code"]    = $segment["carrierCode"];
				$leg_insert[ $i ][ $j ]["is_charter"]          = 0;
				$leg_insert[ $i ][ $j ]["is_return"]           = 0;

				if ( isset( $item["travelerPricings"][0]["fareDetailsBySegment"][ $j ]["includedCheckedBags"]["quantity"] ) ) {
					$leg_insert[ $i ][ $j ]["leg_bar"] = $item["travelerPricings"][0]["fareDetailsBySegment"][ $j ]["includedCheckedBags"]["quantity"] . " Bags";
				} elseif ( isset( $item["travelerPricings"][0]["fareDetailsBySegment"][ $j ]["includedCheckedBags"]["weight"] ) ) {
					$leg_insert[ $i ][ $j ]["leg_bar"] = $item["travelerPricings"][0]["fareDetailsBySegment"][ $j ]["includedCheckedBags"]["weight"] . " " . $item["travelerPricings"][0]["fareDetailsBySegment"][ $j ]["includedCheckedBags"]["weightUnit"];
				} else {
					$leg_insert[ $i ][ $j ]["leg_bar"] = "";
				}

				$total_fly_time_segments_per_min += MyHelperFunction::ISO8601ToMin( $segment["duration"] );

				$j ++;
			}


			$total_time_per_min         = MyHelperFunction::ISO8601ToMin( $item["itineraries"][0]["duration"] );
			$total_waiting_time_per_min = $total_time_per_min - $total_fly_time_segments_per_min;

			$query .= ",";
			$query .= Flight::amadeus . ",";
			$query .= "'" . 0 . "'" . ",";
			$query .= 0 . ",";
			$query .= 0 . ",";
			$query .= ( isset( $item["itineraries"][1] ) ? 2 : 1 ) . ",";
			$query .= 0 . ",";
			$query .= "'" . $item["validatingAirlineCodes"][0] . "'" . ",";
			$query .= "'" . $item["itineraries"][0]["segments"][0]["number"] . "'" . ",";
			$query .= "'" . $item["itineraries"][0]["segments"][0]["departure"]["at"] . "'" . ",";
			$query .= $depart_range . ",";
			$query .= "'" . $item["itineraries"][0]["segments"][0]["departure"]["iataCode"] . "'" . ",";

			$help_var2 = sizeof( $item["itineraries"][0]["segments"] ) - 1;
			$query     .= "'" . $item["itineraries"][0]["segments"][ $help_var2 ]["arrival"]["at"] . "'" . ",";
			$query     .= "'" . $item["itineraries"][0]["segments"][ $help_var2 ]["arrival"]["iataCode"] . "'" . ",";
			$query     .= $help_var2 . ",";
			$query     .= $total_fly_time_segments_per_min . ",";
			$query     .= $total_waiting_time_per_min . ",";

			if ( isset( $item["travelerPricings"][0]["fareDetailsBySegment"][ $j ]["includedCheckedBags"]["quantity"] ) ) {
				$query .= "'" . $item["travelerPricings"][0]["fareDetailsBySegment"][ $j ]["includedCheckedBags"]["quantity"] . " Bags" . "'" . ",";
				$query .= 1 . ",";
			} elseif ( isset( $item["travelerPricings"][0]["fareDetailsBySegment"][ $j ]["includedCheckedBags"]["weight"] ) ) {
				$query .= "'" . $item["travelerPricings"][0]["fareDetailsBySegment"][ $j ]["includedCheckedBags"]["weight"] . " " . $item["travelerPricings"][0]["fareDetailsBySegment"][ $j ]["includedCheckedBags"]["weightUnit"] . "'" . ",";
				$query .= 1 . ",";
			} else {
				$query .= "null,";
				$query .= 0 . ",";
			}


			$query .= MyHelperFunction::turn_class_to_code( $item["travelerPricings"][0]["fareDetailsBySegment"][0]["cabin"] ) . ",";

			$depart_return_time = $total_time_per_min;


			if ( isset( $item["itineraries"][1] ) and $item["oneWay"] == false ) {

				$return_depart_time     = date( "H", strtotime( $item["itineraries"][1]["segments"][0]["departure"]["at"] ) );
				$return_depart_time_min = date( "i", strtotime( $item["itineraries"][1]["segments"][0]["departure"]["at"] ) );
				$return_depart_time     += $return_depart_time_min / 60;
				if ( $return_depart_time > 0 && $return_depart_time < 8 ) {
					$return_depart_range = 0;
				} else if ( $return_depart_time >= 8 && $return_depart_time < 12 ) {
					$return_depart_range = 1;
				} else if ( $return_depart_time >= 12 && $return_depart_time <= 18 ) {
					$return_depart_range = 2;
				} else if ( $return_depart_time > 18 && $return_depart_time <= 24 ) {
					$return_depart_range = 3;
				}

				$return_total_fly_time_segments_per_min = 0;
				$return_first_segment                   = $j;
				foreach ( $item["itineraries"][1]["segments"] as $key => $segment ) {

					$connection_time_per_min = 0;
					if ( $key != sizeof( $item["itineraries"][1]["segments"] ) - 1 ) {
						$helper_date             = new Carbon( $item["itineraries"][1]["segments"][ $key + 1 ]["departure"]["at"] );
						$connection_time_per_min = $helper_date->diffInMinutes( $segment["arrival"]["at"] );
					}
					$airline_insert[ $i ][ $j ]["airline_code"] = $segment["carrierCode"];
					$airline_insert[ $i ][ $j ]["is_return"]    = 1;

					$leg_insert[ $i ][ $j ]["seats_remaining"]     = $item["numberOfBookableSeats"];
					$leg_insert[ $i ][ $j ]["leg_flight_number"]   = $segment["number"];
					$leg_insert[ $i ][ $j ]["cabin_class"]         = MyHelperFunction::turn_class_to_code( $item["travelerPricings"][0]["fareDetailsBySegment"][ $j ]["cabin"] );
					$leg_insert[ $i ][ $j ]["leg_depart_time"]     = $segment["departure"]["at"];
					$leg_insert[ $i ][ $j ]["leg_depart_airport"]  = $segment["departure"]["iataCode"];
					$leg_insert[ $i ][ $j ]["leg_arrival_time"]    = $segment["arrival"]["at"];
					$leg_insert[ $i ][ $j ]["leg_arrival_airport"] = $segment["arrival"]["iataCode"];
					$leg_insert[ $i ][ $j ]["leg_time"]            = MyHelperFunction::ISO8601ToMin( $segment["duration"] );
					$leg_insert[ $i ][ $j ]["leg_waiting"]         = $connection_time_per_min;
					$leg_insert[ $i ][ $j ]["leg_airline_code"]    = $segment["carrierCode"];
					$leg_insert[ $i ][ $j ]["is_charter"]          = 0;
					$leg_insert[ $i ][ $j ]["is_return"]           = 1;

					if ( isset( $item["travelerPricings"][0]["fareDetailsBySegment"][ $j ]["includedCheckedBags"]["quantity"] ) ) {
						$leg_insert[ $i ][ $j ]["leg_bar"] = $item["travelerPricings"][0]["fareDetailsBySegment"][ $j ]["includedCheckedBags"]["quantity"] . " Bags";
					} elseif ( isset( $item["travelerPricings"][0]["fareDetailsBySegment"][ $j ]["includedCheckedBags"]["weight"] ) ) {
						$leg_insert[ $i ][ $j ]["leg_bar"] = $item["travelerPricings"][0]["fareDetailsBySegment"][ $j ]["includedCheckedBags"]["weight"] . " " . $item["travelerPricings"][0]["fareDetailsBySegment"][ $j ]["includedCheckedBags"]["weightUnit"];
					} else {
						$leg_insert[ $i ][ $j ]["leg_bar"] = "";
					}

					$return_total_fly_time_segments_per_min += MyHelperFunction::ISO8601ToMin( $segment["duration"] );

					$j ++;

				}


				$return_total_time_per_min         = MyHelperFunction::ISO8601ToMin( $item["itineraries"][1]["duration"] );
				$return_total_waiting_time_per_min = $return_total_time_per_min - $return_total_fly_time_segments_per_min;


				$query .= "'" . $item["itineraries"][1]["segments"][0]["number"] . "'" . ",";
				$query .= "'" . $item["itineraries"][1]["segments"][0]["departure"]["at"] . "'" . ",";
				$query .= $return_depart_range . ",";
				$query .= "'" . $item["itineraries"][1]["segments"][0]["departure"]["iataCode"] . "'" . ",";

				$help_var3 = sizeof( $item["itineraries"][1]["segments"] ) - 1;
				$query     .= "'" . $item["itineraries"][1]["segments"][ $help_var3 ]["arrival"]["at"] . "'" . ",";
				$query     .= "'" . $item["itineraries"][1]["segments"][ $help_var3 ]["arrival"]["iataCode"] . "'" . ",";
				$query     .= $help_var3 . ",";
				$query     .= $return_total_fly_time_segments_per_min . ",";
				$query     .= $return_total_waiting_time_per_min . ",";

				if ( isset( $item["travelerPricings"][0]["fareDetailsBySegment"][ $return_first_segment ]["includedCheckedBags"]["quantity"] ) ) {
					$query .= "'" . $item["travelerPricings"][0]["fareDetailsBySegment"][ $return_first_segment ]["includedCheckedBags"]["quantity"] . " Bags" . "'" . ",";
					$query .= 1 . ",";
				} elseif ( isset( $item["travelerPricings"][0]["fareDetailsBySegment"][ $return_first_segment ]["includedCheckedBags"]["weight"] ) ) {
					$query .= "'" . $item["travelerPricings"][0]["fareDetailsBySegment"][ $return_first_segment ]["includedCheckedBags"]["weight"] . " " . $item["travelerPricings"][0]["fareDetailsBySegment"][ $return_first_segment ]["includedCheckedBags"]["weightUnit"] . "'" . ",";
					$query .= 1 . ",";
				} else {
					$query .= "null,";
					$query .= 0 . ",";
				}

				$query .= MyHelperFunction::turn_class_to_code( $item["travelerPricings"][0]["fareDetailsBySegment"][ $return_first_segment ]["cabin"] ) . ",";

				$depart_return_time += $return_total_time_per_min;


			} else {
				$query .= "null,null,null,null,null,null,null,null,null,null,null,null,";
			}

			$query .= $depart_return_time . ",";

			$query .= "'" . $flight_offers_json . "'";

			$query .= ")";

			$cost_insert[ $i ]["FareType"]        = MyHelperFunction::turn_fare_type_to_code( $item["pricingOptions"]["fareType"][0] );
			$cost_insert[ $i ]["TotalFare"]       = SetPriceFunction::index( $item["price"]["grandTotal"], $item["validatingAirlineCodes"][0], "amadeus" );
			$cost_insert[ $i ]["VendorTotalFare"] = $item["price"]["grandTotal"];
			$cost_insert[ $i ]["TotalCommission"] = 0;
			$cost_insert[ $i ]["TotalTax"]        = $item["price"]["total"] - $item["price"]["base"];
			$cost_insert[ $i ]["ServiceTax"]      = 0;
			$cost_insert[ $i ]["Currency"]        = $item["price"]["currency"];

			$cost_insert[ $i ]["adult"]  = 0; //number of adult
			$cost_insert[ $i ]["child"]  = 0; //number of child
			$cost_insert[ $i ]["infant"] = 0; //number of inf

			foreach ( $item["travelerPricings"] as $traveler_pricing ) {

				if ( $traveler_pricing["travelerType"] == "ADULT" ) {
					$cost_insert[ $i ]["FarePerAdult"] = $traveler_pricing["price"]["total"]; //total fare per adult
					$cost_insert[ $i ]["adult"] ++;
				} elseif ( $traveler_pricing["travelerType"] == "CHILD" ) {
					$cost_insert[ $i ]["FarePerChild"] = $traveler_pricing["price"]["total"]; //total fare per child
					$cost_insert[ $i ]["child"] ++;
				} elseif ( $traveler_pricing["travelerType"] == "SEATED_INFANT" || $traveler_pricing["travelerType"] == "HELD_INFANT" ) {
					$cost_insert[ $i ]["FarePerInf"] = $traveler_pricing["price"]["total"]; //total fare per inf
					$cost_insert[ $i ]["infant"] ++;
				}

			}

			$i ++;
		}


		//dd($query);

		$flight_id = Flight::my_insert( $query );

		$flight_count = $flight_id;
		for ( $j = 0; $j < $i; $j ++ ) {
			$cost_insert[ $j ]["flight_id"] = $flight_count;
			$flight_count ++;
		}

		$flight_count = $flight_id;
		$k            = 0;
		foreach ( $airline_insert as $airline ) {

			foreach ( $airline as $item ) {
				$item["flight_id"]          = $flight_count;
				$final_airline_insert[ $k ] = $item;
				$k ++;
			}
			$flight_count ++;
		}

		$flight_count = $flight_id;
		$k            = 0;
		foreach ( $leg_insert as $leg ) {

			foreach ( $leg as $item2 ) {
				$item2["flight_id"]     = $flight_count;
				$final_leg_insert[ $k ] = $item2;
				$k ++;
			}
			$flight_count ++;

			if ( sizeof( $final_leg_insert ) * sizeof( $final_leg_insert[ $k - 1 ] ) > 60000 ) {
				Leg::insert( $final_leg_insert );
				$final_leg_insert = [];
				$k                = 0;
			}

		}

		if ( ! empty( $final_leg_insert ) ) {
			Leg::insert( $final_leg_insert );
		}

		Cost::insert( $cost_insert );
		FlightAirline::insert( $final_airline_insert );

		$search_id = Flight::where( 'id', $flight_id )->select( 'search_id' )->get();

		$search_id = json_decode( json_encode( $search_id ), true );

		$search_id = $search_id[0]["search_id"];

//		save search_id in page or cookie

//		//save search_id in page or cookie

		return $search_id;


	}

	public function revalidate( $flight ) {

		$flight_offers_json = $flight["flight_offers_json"];

		$service_url = $this->base . '/v1/shopping/flight-offers/pricing';

		$array = [
			"data" => [
				"type"         => "flight-offers-pricing",
				"flightOffers" => [ json_decode( $flight_offers_json ) ]
			]
		];

		$ch1 = curl_init();

		curl_setopt( $ch1, CURLOPT_URL, $service_url );
		curl_setopt( $ch1, CURLOPT_VERBOSE, 1 );
		curl_setopt( $ch1, CURLOPT_HEADER, 0 );
		curl_setopt( $ch1, CURLOPT_CONNECTTIMEOUT, 120 );
		curl_setopt( $ch1, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt( $ch1, CURLOPT_HTTPHEADER, array(
			"Content-Type: application/json",
			"Authorization: Bearer $this->session"
		) );
		curl_setopt( $ch1, CURLOPT_POST, 1 );
		curl_setopt( $ch1, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch1, CURLOPT_POSTFIELDS, json_encode( $array ) );

		$result = curl_exec( $ch1 );
		curl_close( $ch1 );

		$response = json_decode( $result, true );

		if ( isset( $response["errors"] ) || ! isset( $response["data"] ) || ! isset( $response["data"]["flightOffers"][0]["price"]["grandTotal"] ) || $response["data"]["flightOffers"][0]["price"]["grandTotal"] != $flight["VendorTotalFare"] ) {
			return 0;
		}

		return 1;

	}

	public function book( $flight, $payment ) {

		$book_unique_id = $payment["books"]["UniqueId"];
		$book_id        = $payment["book_id"];
		$flight_id      = $flight["id"];

		$return = [
			"book_unique_id" => $book_unique_id,
			"error"          => 0
		];

		$airbook_data["data"] = [
			"type"         => "flight-order",
			"flightOffers" => [ json_decode( $flight["flight_offers_json"] ) ],
			"travelers"    => []
		];

		$i = 0;
		foreach ( $payment["books"]["passengers"] as $passenger ) {

			$airbook_data["data"]["travelers"][ $i ] = [
				"id"          => $i + 1,
				"dateOfBirth" => $passenger["birthday"],
				"name"        => [
					"firstName" => $passenger["first_name"],
					"lastName"  => $passenger["last_name"]
				],
				"gender"      => $passenger["gender"] == 0 ? "MALE" : "FEMALE",
			];

			$i ++;
		}

		$airbook_data["data"]["contacts"] = [
			[
				"addresseeName" => [
					"firstName" => $payment["books"]["arranger_first_name"],
					"lastName"  => $payment["books"]["arranger_last_name"]
				],
				"purpose"       => "STANDARD",
				"phones"        => [
					[
						"deviceType"         => "MOBILE",
						"countryCallingCode" => str_replace( "+", "", $payment["books"]["dial_code"] ),
						"number"             => $payment["books"]["phone"]
					]
				],
				"emailAddress"  => $payment["books"]["users"]["email"],
				"address"       => [
					"lines"       => [
						"no address"
					],
					"postalCode"  => "11111",
					"cityName"    => "dus",
					"countryCode" => "DE"
				]
			]
		];


		if ( ! $book_unique_id ) {

			$response = $this->flight_create_orders( $airbook_data );


			if ( isset( $response["errors"] ) || ! isset( $response["data"] ) ) {
				//error handling

				Book::where( 'id', $book_id )->update( [
					"status" => "vendor_failed"
				] );

//show error message code
				echo "a";
				dd( $response );

//end error
				$return["error"] = 1;

				return $return;

			}

			$book_unique_id           = $response["data"]["id"];
			$return["book_unique_id"] = $book_unique_id;
			Book::where( 'id', '=', $book_id )->update( [
				"UniqueId" => $book_unique_id,
				"status"   => "wait_for_ticket"
			] );
			Flight::where( 'id', '=', $flight_id )->update( [ "status" => "wait_for_ticket" ] );


		}

		return $return;

	}

	public function flight_create_orders( $airbook_data ) {

		$service_url = $this->base . '/v1/booking/flight-orders';


		$ch1 = curl_init();

		curl_setopt( $ch1, CURLOPT_URL, $service_url );
		curl_setopt( $ch1, CURLOPT_VERBOSE, 1 );
		curl_setopt( $ch1, CURLOPT_HEADER, 0 );
		curl_setopt( $ch1, CURLOPT_CONNECTTIMEOUT, 120 );
		curl_setopt( $ch1, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt( $ch1, CURLOPT_HTTPHEADER, array(
			"Content-Type: application/json",
			"Authorization: Bearer $this->session"
		) );
		curl_setopt( $ch1, CURLOPT_POST, 1 );
		curl_setopt( $ch1, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch1, CURLOPT_POSTFIELDS, json_encode( $airbook_data ) );

		$result = curl_exec( $ch1 );
		curl_close( $ch1 );

		$response = json_decode( $result, true );

		return $response;
	}

	public function update_booking_status( $book, $book_unique_id ) {

		$book_id   = $book["id"];
		$flight_id = $book["flight_id"];

//		$response = $this->flight_order_management( $book_unique_id );


		$returm = [
			"airline_pnr" => "",
			"booked"      => false,
			"book"        => $book,
		];

		return $returm;
	}

	public function flight_order_management( $book_unique_id ) {

		$service_url = $this->base . "/v1/booking/flight-orders/" . $book_unique_id;

		$ch1 = curl_init();

		curl_setopt( $ch1, CURLOPT_URL, $service_url );
		curl_setopt( $ch1, CURLOPT_VERBOSE, 1 );
		curl_setopt( $ch1, CURLOPT_HEADER, 0 );
		curl_setopt( $ch1, CURLOPT_CONNECTTIMEOUT, 120 );
		curl_setopt( $ch1, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt( $ch1, CURLOPT_HTTPHEADER, array(
			"Content-Type: application/json",
			"Authorization: Bearer $this->session"
		) );
		curl_setopt( $ch1, CURLOPT_RETURNTRANSFER, 1 );

		$result = curl_exec( $ch1 );
		curl_close( $ch1 );

		$response = json_decode( $result, true );

		return $response;

	}

	public function airrules( $flight ) {}


}
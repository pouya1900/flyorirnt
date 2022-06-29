<?php


namespace App\Services\Renders;


use App\Models\Airline;
use App\Models\Book;
use App\Models\Cost;
use App\Models\Tax;
use App\Models\Airplane;
use App\Models\Flight;
use App\Models\FlightAirline;
use App\Models\Leg;
use App\Models\Passenger;
use App\Models\Payment;
use App\Models\Search;
use App\Models\Session;
use App\Models\Setting;
use App\Models\Airport;
use App\Services\MyHelperFunction;
use App\Services\SetPriceFunction;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use SoapClient;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\AppException;
use App\Services\xmlFile\Irr;
use App\Services\Log\log;

class iranAir implements render_interface
{

    private $auth;
    public $base;
    public $render_code;
    public $agent_id;
    public $irr;
    public $log;

    public function __construct($code = 0)
    {
        $this->log = new log();

        $config = \Illuminate\Support\Facades\Config::get("AuthInfo");

        $setting = Setting::find(1);

        if ($code == Setting::iranAir || ($code == 0 && $setting->flight_render == Setting::iranAir)) {
            $this->auth = $config["iran_air_info"]["main"]["auth"];
            $this->base = $config["iran_air_info"]["main"]["base"];
            $this->render_code = Setting::iranAir;
            $this->agent_id = $config["iran_air_info"]["main"]["agent_id"];

        } else {
            $this->auth = $config["iran_air_info"]["demo"]["auth"];
            $this->base = $config["iran_air_info"]["demo"]["base"];
            $this->render_code = Setting::iranAir_demo;
            $this->agent_id = $config["iran_air_info"]["demo"]["agent_id"];
        }


        $this->irr = new Irr($this->agent_id);

    }

    public function redirect_lowfaresearch($flight_id)
    {

        $flight = Flight::with(['costs'])->where('id', '=', $flight_id)->get();
        $flight = json_decode(json_encode($flight), true);
        $flight = $flight[0];


    }


    public function lowfaresearch($origin, $destination, $depart, $return, $class, $adl, $chl, $inf, $none_stop, $search_id)
    {

        $origin_ob = Airport::where('code', '=', $origin)->first();
        $destination_ob = Airport::where('code', '=', $destination)->first();

        if ($origin_ob->is_city) {
            $origin_ob = Airport::where('city_id', $origin_ob->id)->where('iran_air', 1)->get();
        } else {
            $origin_ob = [$origin_ob];
        }


        if ($destination_ob->is_city) {
            $destination_ob = Airport::where('city_id', $destination_ob->id)->where('iran_air', 1)->get();
        } else {
            $destination_ob = [$destination_ob];
        }

        foreach ($origin_ob as $item) {
            foreach ($destination_ob as $item2) {

                $origin = $item->code;
                $destination = $item2->code;
                $search_id = $this->lowfaresearch2($origin, $destination, $depart, $return, $class, $adl, $chl, $inf, $none_stop, $search_id);
            }

        }

        return $search_id;

    }


    public function lowfaresearch2($origin, $destination, $depart, $return, $class, $adl, $chl, $inf, $none_stop, $search_id)
    {

        $class = strtolower($class);

        switch ($class) {
            case "economy":
                $class = 'Economy';
                break;
            case "business":
                $class = 'Business';
                break;
            default:
                $class = 'Economy';
        }

        $depart = date('Y-m-d', strtotime($depart));
        if ($return != "-") {
            $return = date('Y-m-d', strtotime($return));
        } else {
            $return = null;
        }

        $airplanes = Airplane::all();

        $adl = intval($adl);
        $chl = intval($chl);
        $inf = intval($inf);

        $calc_price = new SetPriceFunction();

        //		test for timing
        //$test_time1 = Carbon::now();
        //		test for timing


        $service_url = $this->base . '/availability/lowfaresearch';


        $array = [

            "AdultCount"                    => $adl,
            "ChildCount"                    => $chl,
            "InfantCount"                   => $inf,
            "RequestOption"                 => "Fifty",
            "searchType"                    => "STANDARD",
            "OriginDestinationInformations" => [
                [
                    "DepartureDateTime"       => $depart,
                    "DestinationLocationCode" => $destination,
                    "OriginLocationCode"      => $origin,
                ],
            ],
            "TravelPreference"              => [
                "CabinType"        => $class,
                "MaxStopsQuantity" => "All",
                "AirTripType"      => "OneWay",
            ],

        ];

        if ($return != null) {
            $array["OriginDestinationInformations"][1] = [
                "DepartureDateTime"       => $return,
                "DestinationLocationCode" => $origin,
                "OriginLocationCode"      => $destination,
            ];
            $array["TravelPreference"]["AirTripType"] = "Return";
        }

        if (isset($none_stop) and $none_stop == 1) {
            $array["TravelPreference"]["MaxStopsQuantity"] = "Direct";

        }


        $req = $this->irr->LowFareSearch($array);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/xml",
            "Accept: application/xml",
            "Authorization: <$this->auth>",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);

        $result = curl_exec($ch);
        curl_close($ch);
        $xml = simplexml_load_string($result);
        $json = json_encode($xml);
        $response = json_decode($json, true);
//		test for timing
        //$this->time2     = Carbon::now();
        //$this->diff_time = Carbon::now()->diffInSeconds( $test_time1 );
//		test for timing

        if (!$search_id) {
            $search = Search::create();
            $search_id = $search->id;
        }

//		log test

//        $log = new log();
//
//        $log->save($result);
//		end log test

        if (!empty($response) && isset($response["Success"])) {


            $response = $response["PricedItineraries"]["PricedItinerary"];
            if (!isset($response[0])) {
                $hlp[0] = $response;
                $response = $hlp;
            }


            $cost_insert = [];
            $tax_insert = [];
            $final_tax_insert = [];
            $leg_insert = [];
            $airline_insert = [];
            $final_airline_insert = [];
            $final_leg_insert = [];
            $i = 0;


            $query = "INSERT INTO flights(search_id,token,render,FareSourceCode,IsPassportMandatory,IsPassportIssueDateMandatory,IsPassportNumberMandatory,DirectionInd,RefundMethod,ValidatingAirlineCode,flight_number,depart_time,depart_time_range,depart_airport,arrival_time,arrival_airport,stops,total_time,total_waiting,bar,bar_exist,class,class_code,return_flight_number,return_depart_time,return_depart_time_range,return_depart_airport,return_arrival_time,return_arrival_airport,return_stops,return_total_time,return_total_waiting,return_bar,return_bar_exist,return_class,return_class_code,depart_return_time) VALUES ($search_id";
            foreach ($response as $item) {

                $itinerary_depart = [];
                $itinerary_return = [];
                if (!isset($item["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0])) {

                    $itinerary_depart = $item["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"]["FlightSegment"];
                } else {
                    $itinerary_depart = $item["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"];
                    if (isset($item["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][1]["FlightSegment"])) {
                        $itinerary_return = $item["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][1]["FlightSegment"];
                    }

                }


                if (!isset($itinerary_depart[0])) {
                    $hlp[0] = $itinerary_depart;
                    $itinerary_depart = $hlp;
                }
                if ($itinerary_return && !isset($itinerary_return[0])) {
                    $hlp[0] = $itinerary_return;
                    $itinerary_return = $hlp;
                }
                $help_var = sizeof($itinerary_depart) - 1;
                $help_var2 = sizeof($itinerary_return) - 1;

                if ($help_var > 0 || $help_var2 > 0) {
                    continue;
                }

                $PTC_FareBreakdown = $item["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"];
                if (!isset($item["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"][0])) {
                    $hlp[0] = $item["AirItineraryPricingInfo"]["PTC_FareBreakdowns"]["PTC_FareBreakdown"];
                    $PTC_FareBreakdown = $hlp;
                }

                $FareBasisCode = $PTC_FareBreakdown[0]["FareBasisCodes"]["FareBasisCode"];

                if (!is_array($PTC_FareBreakdown[0]["FareBasisCodes"]["FareBasisCode"]) || !isset($PTC_FareBreakdown[0]["FareBasisCodes"]["FareBasisCode"][0])) {
                    $hlp[0] = $PTC_FareBreakdown[0]["FareBasisCodes"]["FareBasisCode"];
                    $FareBasisCode = $hlp;
                }

                $FareBasisCodeXmlModel = $xml->PricedItineraries->PricedItinerary->AirItineraryPricingInfo->PTC_FareBreakdowns->PTC_FareBreakdown[0]->FareBasisCodes->FareBasisCode;


                if ($i != 0) {
                    $query .= ",($search_id";
                }

                $depart_time = date("H", strtotime($itinerary_depart[0]["@attributes"]["DepartureDateTime"]));
                $depart_time_min = date("i", strtotime($itinerary_depart[0]["@attributes"]["DepartureDateTime"]));
                $depart_time += $depart_time_min / 60;
                if ($depart_time > 0 && $depart_time < 8) {
                    $depart_range = 0;
                } else if ($depart_time >= 8 && $depart_time < 12) {
                    $depart_range = 1;
                } else if ($depart_time >= 12 && $depart_time <= 18) {
                    $depart_range = 2;
                } else if ($depart_time > 18 && $depart_time <= 24) {
                    $depart_range = 3;
                }

                $total_fly_time_segments_per_min = intval(substr($itinerary_depart[0]["@attributes"]["Duration"], 0, 2)) * 60
                    + intval(substr($itinerary_depart[0]["@attributes"]["Duration"], 3, 2));

                $query .= ",";
                $query .= "0,";
                $query .= $this->render_code . ",";
                $query .= "'" . 0 . "'" . ",";
                $query .= 1 . ",";
                $query .= 0 . ",";
                $query .= 1 . ",";
                $query .= ($itinerary_return ? 2 : 1) . ",";
                $query .= 0 . ",";
                $query .= "'" . $itinerary_depart[0]["OperatingAirline"]["@attributes"]["Code"] . "'" . ",";
                $query .= "'" . $itinerary_depart[0]["@attributes"]["FlightNumber"] . "'" . ",";
                $query .= "'" . $itinerary_depart[0]["@attributes"]["DepartureDateTime"] . "'" . ",";
                $query .= $depart_range . ",";
                $query .= "'" . $itinerary_depart[0]["DepartureAirport"]["@attributes"]["LocationCode"] . "'" . ",";


                $query .= "'" . $itinerary_depart[$help_var]["@attributes"]["ArrivalDateTime"] . "'" . ",";
                $query .= "'" . $itinerary_depart[$help_var]["ArrivalAirport"]["@attributes"]["LocationCode"] . "'" . ",";
                $query .= $help_var . ",";
                $query .= $total_fly_time_segments_per_min . ",";
                $query .= 0 . ",";
                $query .= '"nd"' . ",";


                $query .= 2 . ",";


                $query .= MyHelperFunction::turn_OTA_code_to_class($itinerary_depart[0]["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"]) . ",";
                $query .= "'" . $itinerary_depart[0]["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"] . "'" . ",";

                $depart_return_time = $total_fly_time_segments_per_min;

                $j = 0;
                foreach ($itinerary_depart as $segment) {

                    $airline_insert[$i][$j]["airline_code"] = $segment["OperatingAirline"]["@attributes"]["Code"];
                    $airline_insert[$i][$j]["is_return"] = 0;

                    foreach ($airplanes as $airplane) {
                        if ($airplane->code == $segment["Equipment"]["@attributes"]["AirEquipType"]) {
                            $aircraft = $airplane;
                            break;
                        }
                    }

                    $leg_insert[$i][$j]["seats_remaining"] = $segment["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigQuantity"];
                    $leg_insert[$i][$j]["aircraft_type"] = isset($aircraft) ? $aircraft->manufacture . ' ' . $aircraft->code : $segment["Equipment"]["@attributes"]["AirEquipType"];
                    $leg_insert[$i][$j]["aircraft_type_description"] = isset($aircraft) ? $aircraft->description : $segment["Equipment"]["@attributes"]["AirEquipType"];
                    $leg_insert[$i][$j]["RPH"] = $segment["@attributes"]["RPH"];
                    $leg_insert[$i][$j]["leg_flight_number"] = $segment["@attributes"]["FlightNumber"];
                    $leg_insert[$i][$j]["cabin_class"] = MyHelperFunction::turn_OTA_code_to_class($segment["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"]);
                    $leg_insert[$i][$j]["cabin_class_code"] = $segment["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"];
                    $leg_insert[$i][$j]["leg_depart_time"] = $segment["@attributes"]["DepartureDateTime"];
                    $leg_insert[$i][$j]["leg_depart_airport"] = $segment["DepartureAirport"]["@attributes"]["LocationCode"];
                    $leg_insert[$i][$j]["leg_arrival_time"] = $segment["@attributes"]["ArrivalDateTime"];
                    $leg_insert[$i][$j]["leg_arrival_airport"] = $segment["ArrivalAirport"]["@attributes"]["LocationCode"];
                    $leg_insert[$i][$j]["leg_time"] = $total_fly_time_segments_per_min;
                    $leg_insert[$i][$j]["leg_waiting"] = 0;
                    $leg_insert[$i][$j]["leg_airline_code"] = $segment["OperatingAirline"]["@attributes"]["Code"];
                    $leg_insert[$i][$j]["is_charter"] = 0;
                    $leg_insert[$i][$j]["is_return"] = 0;
                    $leg_insert[$i][$j]["leg_bar"] = "nd";
                    $leg_insert[$i][$j]["fare_basis_code"] = $FareBasisCode[0];
                    $leg_insert[$i][$j]["fareRPH"] = json_decode(json_encode($FareBasisCodeXmlModel[0]->attributes()->fareRPH), true)[0];


                    $j++;
                }

                if ($itinerary_return) {
                    $return_depart_time = date("H", strtotime($itinerary_return[0]["@attributes"]["DepartureDateTime"]));
                    $return_depart_time_min = date("i", strtotime($itinerary_return[0]["@attributes"]["DepartureDateTime"]));
                    $return_depart_time += $return_depart_time_min / 60;
                    if ($return_depart_time > 0 && $return_depart_time < 8) {
                        $return_depart_range = 0;
                    } else if ($return_depart_time >= 8 && $return_depart_time < 12) {
                        $return_depart_range = 1;
                    } else if ($return_depart_time >= 12 && $return_depart_time <= 18) {
                        $return_depart_range = 2;
                    } else if ($return_depart_time > 18 && $return_depart_time <= 24) {
                        $return_depart_range = 3;
                    }

                    $total_return_fly_time_segments_per_min = intval(substr($itinerary_return[0]["@attributes"]["Duration"], 0, 2)) * 60
                        + intval(substr($itinerary_return[0]["@attributes"]["Duration"], 3, 2));


                    $query .= "'" . $itinerary_return[0]["@attributes"]["FlightNumber"] . "'" . ",";
                    $query .= "'" . $itinerary_return[0]["@attributes"]["DepartureDateTime"] . "'" . ",";
                    $query .= $return_depart_range . ",";
                    $query .= "'" . $itinerary_return[0]["DepartureAirport"]["@attributes"]["LocationCode"] . "'" . ",";

                    $query .= "'" . $itinerary_return[$help_var2]["@attributes"]["ArrivalDateTime"] . "'" . ",";
                    $query .= "'" . $itinerary_return[$help_var2]["ArrivalAirport"]["@attributes"]["LocationCode"] . "'" . ",";
                    $query .= $help_var2 . ",";
                    $query .= $total_return_fly_time_segments_per_min . ",";
                    $query .= 0 . ",";
                    $query .= '"nd"' . ",";


                    $query .= 2 . ",";


                    $query .= MyHelperFunction::turn_OTA_code_to_class($itinerary_return[0]["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"]) . ",";
                    $query .= "'" . $itinerary_return[0]["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"] . "'" . ",";


                    $depart_return_time += $total_return_fly_time_segments_per_min;

                    foreach ($itinerary_return as $segment) {
                        $airline_insert[$i][$j]["airline_code"] = $segment["OperatingAirline"]["@attributes"]["Code"];
                        $airline_insert[$i][$j]["is_return"] = 1;

                        foreach ($airplanes as $airplane) {
                            if ($airplane->code == $segment["Equipment"]["@attributes"]["AirEquipType"]) {
                                $aircraft = $airplane;
                                break;
                            }
                        }

                        $leg_insert[$i][$j]["seats_remaining"] = $segment["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigQuantity"];
                        $leg_insert[$i][$j]["aircraft_type"] = isset($aircraft) ? $aircraft->manufacture . ' ' . $aircraft->code : $segment["Equipment"]["@attributes"]["AirEquipType"];
                        $leg_insert[$i][$j]["aircraft_type_description"] = isset($aircraft) ? $aircraft->description : $segment["Equipment"]["@attributes"]["AirEquipType"];
                        $leg_insert[$i][$j]["RPH"] = $segment["@attributes"]["RPH"];
                        $leg_insert[$i][$j]["leg_flight_number"] = $segment["@attributes"]["FlightNumber"];
                        $leg_insert[$i][$j]["cabin_class"] = MyHelperFunction::turn_OTA_code_to_class($segment["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"]);
                        $leg_insert[$i][$j]["cabin_class_code"] = $segment["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"];
                        $leg_insert[$i][$j]["leg_depart_time"] = $segment["@attributes"]["DepartureDateTime"];
                        $leg_insert[$i][$j]["leg_depart_airport"] = $segment["DepartureAirport"]["@attributes"]["LocationCode"];
                        $leg_insert[$i][$j]["leg_arrival_time"] = $segment["@attributes"]["ArrivalDateTime"];
                        $leg_insert[$i][$j]["leg_arrival_airport"] = $segment["ArrivalAirport"]["@attributes"]["LocationCode"];
                        $leg_insert[$i][$j]["leg_time"] = $total_return_fly_time_segments_per_min;
                        $leg_insert[$i][$j]["leg_waiting"] = 0;
                        $leg_insert[$i][$j]["leg_airline_code"] = $segment["OperatingAirline"]["@attributes"]["Code"];
                        $leg_insert[$i][$j]["is_charter"] = 0;
                        $leg_insert[$i][$j]["is_return"] = 1;
                        $leg_insert[$i][$j]["leg_bar"] = "nd";
                        $leg_insert[$i][$j]["fare_basis_code"] = $FareBasisCode[1];
                        $leg_insert[$i][$j]["fareRPH"] = json_decode(json_encode($FareBasisCodeXmlModel[1]->attributes()->fareRPH), true)[0];


                        $j++;
                    }

                } else {
                    $query .= "null,null,null,null,null,null,null,null,null,null,0,null,null,";
                }

                $query .= $depart_return_time;

                $query .= ")";


                $cost_insert[$i]["FareType"] = 1;
                $cost_insert[$i]["VendorTotalFare"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["TotalFare"]["@attributes"]["Amount"];
                $cost_insert[$i]["TotalCommission"] = 0;
                $cost_insert[$i]["TotalTax"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["TotalFare"]["@attributes"]["Amount"] - $item["AirItineraryPricingInfo"]["ItinTotalFare"]["BaseFare"]["@attributes"]["Amount"];
                $cost_insert[$i]["ServiceTax"] = 0;
                $cost_insert[$i]["Currency"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["TotalFare"]["@attributes"]["CurrencyCode"];
                $cost_insert[$i]["FarePerAdult"] = $calc_price->index($PTC_FareBreakdown[0]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"], 0); //total fare per adult
                $cost_insert[$i]["serviceAdult"] = $cost_insert[$i]["FarePerAdult"] - $PTC_FareBreakdown[0]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"]; //service fee per adult
                $cost_insert[$i]["adult"] = $PTC_FareBreakdown[0]["PassengerTypeQuantity"]["@attributes"]["Quantity"]; //number of adult
                $calc_price->setCount($cost_insert[$i]["adult"], 0);

                $cost_insert[$i]["taxAdult"] = $PTC_FareBreakdown[0]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"] - $PTC_FareBreakdown[0]["PassengerFare"]["BaseFare"]["@attributes"]["Amount"];

                if (isset($xml->PricedItineraries->PricedItinerary->AirItineraryPricingInfo->PTC_FareBreakdowns->PTC_FareBreakdown[0]->PassengerFare->Taxes)) {
                    foreach ($xml->PricedItineraries->PricedItinerary->AirItineraryPricingInfo->PTC_FareBreakdowns->PTC_FareBreakdown[0]->PassengerFare->Taxes->Tax as $x) {

                        $name = json_decode(json_encode($x->attributes()->TaxName), true)[0];
                        $code = json_decode(json_encode($x->attributes()->TaxCode), true)[0];
                        $price = json_decode(json_encode($x), true)[0];

                        $tax_insert[$i][] = [
                            "type"  => 0,
                            "name"  => str_replace("International", "Int.", ucwords(strtolower($name))),
                            "code"  => $code,
                            "price" => $price,
                        ];

                    }
                }
                if (isset($PTC_FareBreakdown[1])) {

                    if ($PTC_FareBreakdown[1]["PassengerTypeQuantity"]["@attributes"]["Code"] == "CHD") {
                        $cost_insert[$i]["FarePerChild"] = $calc_price->index($PTC_FareBreakdown[1]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"], 1); //per child
                        $cost_insert[$i]["serviceChild"] = $cost_insert[$i]["FarePerChild"] - $PTC_FareBreakdown[1]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"]; //service fee per child
                        $cost_insert[$i]["child"] = $PTC_FareBreakdown[1]["PassengerTypeQuantity"]["@attributes"]["Quantity"]; //number of child
                        $calc_price->setCount($cost_insert[$i]["child"], 1);
                        $cost_insert[$i]["taxChild"] = $PTC_FareBreakdown[1]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"] - $PTC_FareBreakdown[1]["PassengerFare"]["BaseFare"]["@attributes"]["Amount"];
                        $tax_type = 1;
                    } else {
                        $cost_insert[$i]["FarePerInf"] = $calc_price->index($PTC_FareBreakdown[1]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"], 2); //per inf
                        $cost_insert[$i]["serviceInfant"] = $cost_insert[$i]["FarePerInf"] - $PTC_FareBreakdown[1]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"]; //service fee per inf
                        $cost_insert[$i]["infant"] = $PTC_FareBreakdown[1]["PassengerTypeQuantity"]["@attributes"]["Quantity"]; //number of inf
                        $calc_price->setCount($cost_insert[$i]["infant"], 2);
                        $cost_insert[$i]["taxInfant"] = $PTC_FareBreakdown[1]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"] - $PTC_FareBreakdown[1]["PassengerFare"]["BaseFare"]["@attributes"]["Amount"];
                        $tax_type = 2;
                    }

                    if (isset($xml->PricedItineraries->PricedItinerary->AirItineraryPricingInfo->PTC_FareBreakdowns->PTC_FareBreakdown[1]->PassengerFare->Taxes)) {
                        foreach ($xml->PricedItineraries->PricedItinerary->AirItineraryPricingInfo->PTC_FareBreakdowns->PTC_FareBreakdown[1]->PassengerFare->Taxes->Tax as $x) {

                            $name = json_decode(json_encode($x->attributes()->TaxName), true)[0];
                            $code = json_decode(json_encode($x->attributes()->TaxCode), true)[0];
                            $price = json_decode(json_encode($x), true)[0];

                            $tax_insert[$i][] = [
                                "type"  => $tax_type,
                                "name"  => str_replace("International", "Int.", ucwords(strtolower($name))),
                                "code"  => $code,
                                "price" => $price,
                            ];

                        }
                    }
                    if (isset($PTC_FareBreakdown[2])) {

                        $cost_insert[$i]["FarePerInf"] = $calc_price->index($PTC_FareBreakdown[2]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"], 2); //per inf
                        $cost_insert[$i]["serviceInfant"] = $cost_insert[$i]["FarePerInf"] - $PTC_FareBreakdown[2]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"]; //service fee per inf
                        $cost_insert[$i]["infant"] = $PTC_FareBreakdown[2]["PassengerTypeQuantity"]["@attributes"]["Quantity"]; //number of inf
                        $calc_price->setCount($cost_insert[$i]["infant"], 2);
                        $cost_insert[$i]["taxInfant"] = $PTC_FareBreakdown[2]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"] - $PTC_FareBreakdown[2]["PassengerFare"]["BaseFare"]["@attributes"]["Amount"];

                        if (isset($xml->PricedItineraries->PricedItinerary->AirItineraryPricingInfo->PTC_FareBreakdowns->PTC_FareBreakdown[2]->PassengerFare->Taxes)) {
                            foreach ($xml->PricedItineraries->PricedItinerary->AirItineraryPricingInfo->PTC_FareBreakdowns->PTC_FareBreakdown[2]->PassengerFare->Taxes->Tax as $x) {

                                $name = json_decode(json_encode($x->attributes()->TaxName), true)[0];
                                $code = json_decode(json_encode($x->attributes()->TaxCode), true)[0];
                                $price = json_decode(json_encode($x), true)[0];

                                $tax_insert[$i][] = [
                                    "type"  => 2,
                                    "name"  => str_replace("International", "Int.", ucwords(strtolower($name))),
                                    "code"  => $code,
                                    "price" => $price,
                                ];

                            }
                        }
                    }

                }

                $cost_insert[$i]["TotalFare"] = $calc_price->getTotal();


                $i++;
            }

            if (!$i) {
                return $search_id;
            }

            $flight_id = Flight::my_insert($query);

            $k_h = 0;
            $flight_count = $flight_id;
            for ($j = 0; $j < $i; $j++) {
                $cost_insert[$j]["flight_id"] = $flight_count;
                $item = [];
                if (isset($tax_insert[$j])) {
                    $item = $tax_insert[$j];
                }
                foreach ($item as $item_h) {
                    $item_h["flight_id"] = $flight_count;
                    $final_tax_insert[] = $item_h;

                }
                $flight_count++;
            }


            $flight_count = $flight_id;
            $k = 0;
            foreach ($airline_insert as $airline) {

                foreach ($airline as $item) {
                    $item["flight_id"] = $flight_count;
                    $final_airline_insert[$k] = $item;
                    $k++;
                }
                $flight_count++;
            }

            $flight_count = $flight_id;
            $k = 0;
            foreach ($leg_insert as $leg) {

                foreach ($leg as $item2) {
                    $item2["flight_id"] = $flight_count;
                    $final_leg_insert[$k] = $item2;
                    $k++;
                }
                $flight_count++;
                if (sizeof($final_leg_insert) * sizeof($final_leg_insert[$k - 1]) > 60000) {
                    Leg::insert($final_leg_insert);
                    $final_leg_insert = [];
                    $k = 0;
                }

            }

            if (!empty($final_leg_insert)) {
                Leg::insert($final_leg_insert);
            }

            Cost::insert($cost_insert);
            Tax::insert($final_tax_insert);
            FlightAirline::insert($final_airline_insert);

            $flight_count = $flight_id;
            for ($j = 0; $j < $i; $j++) {
                $this->get_bag_info($flight_id);
                $flight_count++;
            }

//		save search_id in page or cookie

//		//save search_id in page or cookie


        }

        return $search_id;
    }

    public function revalidate($flight)
    {

        return 1;
    }


    public function book($flight, $payment)
    {

        $book = $payment->books;

        $book_unique_id = $book->UniqueId;
        $book_id = $book->id;
        $flight_id = $flight["id"];
        $payment_id = $payment->id;

        $return = [
            "book_unique_id" => $book_unique_id,
            "error"          => 0,
        ];


        if (!$book_unique_id) {

            $res = $this->airbook($payment_id);

            $response = $res["response"];

            if (isset($response["errors"]) || !isset($response["AirReservation"])) {
                //error handling

                $book->update([
                    "status" => "vendor_failed",
                ]);

                $this->log->api_error($res["request"], json_encode($response), "AirBook", $flight);


//show error message code
                if (env('APP_DEBUG')) {
                    echo "a";
                    dd($response);
                }

//end error
                $return["error"] = 1;

                return $return;

            }

            $book_unique_id = $response["AirReservation"]["BookingReferenceID"]["@attributes"]["ID"];
            $return["book_unique_id"] = $book_unique_id;
            $book->update([
                "UniqueId" => $book_unique_id,
                "status"   => "booked",
            ]);
            Flight::where('id', '=', $flight_id)->update(["status" => "booked"]);

            $ticketing = $response["AirReservation"]["Ticketing"];
            if (!is_array($response["AirReservation"]["Ticketing"]) || !isset($response["AirReservation"]["Ticketing"][0])) {
                $hlp[0] = $response["AirReservation"]["Ticketing"];
                $ticketing = $hlp;
            }
            $i = 0;
            foreach ($book->passengers as $passenger) {

                Passenger::where('id', '=', $passenger->id)->update([
                    "ticket_number" => $ticketing[$i]["@attributes"]["TicketDocumentNbr"],
                ]);
                $i++;
            }


        }

        return $return;

    }

    public function airbook($payment_id)
    {

        $payment = Payment::find($payment_id);

        $service_url = $this->base . '/booking/create';


        $req = $this->irr->book($payment);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/xml",
            "Accept: application/xml",
            "Authorization: <$this->auth>",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);

        $result = curl_exec($ch);
        curl_close($ch);


        $xml = simplexml_load_string($result);
        $json = json_encode($xml);
        $response = json_decode($json, true);

        return ["response" => $response, "request" => $req];
    }


    public function update_booking_status($book, $book_unique_id)
    {

        $book_id = $book->id;
        $flight_id = $book->flight_id;

//        $booking_data = $this->airbookdata($book_unique_id);


        $returm = [
            "airline_pnr" => "",
            "booked"      => true,
            "book"        => $book,
        ];


        return $returm;

    }

    public function airbookdata($book_unique_id)
    {

        $service_url = $this->base . '/booking/read';

        $req = $this->irr->book_data($book_unique_id);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/xml",
            "Accept: application/xml",
            "Authorization: <$this->auth>",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);

        $result = curl_exec($ch);
        curl_close($ch);

        $xml = simplexml_load_string($result);
        $json = json_encode($xml);
        $response = json_decode($json, true);

        return $response;

    }


    public function airrules($flight)
    {


        $service_url = $this->base . '/availability/fareRuleInformation';


        $req = $this->irr->airRule($flight);


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/xml",
            "Accept: application/xml",
            "Authorization: <$this->auth>",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);

        $result = curl_exec($ch);
        curl_close($ch);


        $xml = simplexml_load_string($result);
        $json = json_encode($xml);
        $response = json_decode($json, true);

        return $response;

    }


    public function cancel_fee($book_id)
    {

        $book = Book::find($book_id);

        $service_url = $this->base . '/modifybooking/fees';


        $req = $this->irr->cancel_fee($book);


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/xml",
            "Accept: application/xml",
            "Authorization: <$this->auth>",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);

        $result = curl_exec($ch);
        curl_close($ch);


        $xml = simplexml_load_string($result);
        $json = json_encode($xml);
        $response = json_decode($json, true);


        return $response;
    }

    public function aircancel($book_id)
    {

        $book = Book::find($book_id);

        $service_url = $this->base . '/modifybooking/cnxbkg';


        $req = $this->irr->cancel($book);


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/xml",
            "Accept: application/xml",
            "Authorization: <$this->auth>",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);

        $result = curl_exec($ch);
        curl_close($ch);


        $xml = simplexml_load_string($result);
        $json = json_encode($xml);
        $response = json_decode($json, true);


        return $response;

    }


    public function split($book_id)
    {

        $book = Book::find($book_id);

        $service_url = $this->base . '/modifybooking/splitbkg';

        $req = $this->irr->split($book);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/xml",
            "Accept: application/xml",
            "Authorization: <$this->auth>",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);

        $result = curl_exec($ch);
        curl_close($ch);


        $xml = simplexml_load_string($result);
        $json = json_encode($xml);
        $response = json_decode($json, true);


        return $response;


    }

    public function editBookingContact($book_id)
    {

        $book = Book::find($book_id);

        $service_url = $this->base . '/modifybooking/editBookingContact';

        $req = $this->irr->edit($book);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/xml",
            "Accept: application/xml",
            "Authorization: <$this->auth>",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);

        $result = curl_exec($ch);
        curl_close($ch);


        $xml = simplexml_load_string($result);
        $json = json_encode($xml);
        $response = json_decode($json, true);


        return $response;


    }


    public function bag($flight)
    {

        $service_url = $this->base . '/availability/fareRuleInformation';


        $req = $this->irr->airRule($flight);


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/xml",
            "Accept: application/xml",
            "Authorization: <$this->auth>",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);

        $result = curl_exec($ch);
        curl_close($ch);

        $xml = simplexml_load_string($result);
        $json = json_encode($xml);
        $response = json_decode($json, true);

        return $response;

    }

    public function get_bag_info($flight_id)
    {

        $flight = Flight::find($flight_id);
        $rules = $this->bag($flight);
        $bar[0] = "";
        $bar[1] = "";
        if ($rules && isset($rules["Success"]) && isset($rules["FareRuleText"])) {
            if (isset($rules["FareRuleText"][0])) {
                $explode = preg_split('/[,\s:]/', strtolower($rules["FareRuleText"][0]["Description"]));
                foreach ($explode as $p) {
                    if (strpos($p, 'kg')) {
                        $p = str_replace("adult", "", $p);
                        $bar[0] = str_replace("child", "", $p);
                        break;
                    }
                }
                $explode = preg_split('/[,\s:]/', strtolower($rules["FareRuleText"][1]["Description"]));
                foreach ($explode as $p) {
                    if (strpos($p, 'kg')) {
                        $p = str_replace("adult", "", $p);
                        $bar[1] = str_replace("child", "", $p);
                        break;
                    }
                }
            } else {
                $explode = preg_split("/[,\s:]/", strtolower($rules["FareRuleText"]["Description"]));
                foreach ($explode as $p) {
                    if (strpos($p, 'kg')) {
                        $p = str_replace("adult", "", $p);
                        $bar[0] = str_replace("child", "", $p);
                        break;
                    }
                }
            }
        }

        $flight->update([
            'bar'              => $bar[0],
            'bar_exist'        => $bar[0] ? 1 : 0,
            'return_bar'       => $bar[1],
            'return_bar_exist' => $bar[1] ? 1 : 0,
        ]);

        foreach ($flight->legs as $leg) {
            if (!$leg->is_return) {
                $leg->update([
                    'leg_bar'       => $bar[0],
                    'leg_bar_exist' => 1,
                ]);
            } else {
                $leg->update([
                    'leg_bar'       => $bar[1],
                    'leg_bar_exist' => 1,
                ]);
            }

        }


    }


}
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
use App\Models\Page;
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
        $flights = [];
        $airlines_list = [];
        $airlines_filter_list = [];
        $flight_grouped = [];
        foreach ($origin_ob as $item) {
            foreach ($destination_ob as $item2) {

                $origin = $item->code;
                $destination = $item2->code;
                $response = $this->lowfaresearch2($origin, $destination, $depart, $return, $class, $adl, $chl, $inf, $none_stop, $search_id);
                $flights = array_merge($flights, $response["flights"]);
                $airlines_list = array_merge($airlines_list, $response["airlines_list"]);
                $airlines_filter_list = array_merge($airlines_filter_list, $response["airlines_filter_list"]);
                $flight_grouped = array_merge($flight_grouped, $response["flight_grouped"]);
            }

        }

        return ["flights" => $flights, "airlines_list" => $airlines_list, "airlines_filter_list" => $airlines_filter_list, "flight_grouped" => $flight_grouped];

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
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 400);
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

        $airlines_list = [];
        $airlines_filter_list = [];
        $flight_grouped = [];
        $flights = [];

        if (!empty($response) && isset($response["Success"])) {


            $response = $response["PricedItineraries"]["PricedItinerary"];
            if (!isset($response[0])) {
                $hlp[0] = $response;
                $response = $hlp;
            }


            $cost_insert = [];
            $tax_insert = [];
            $final_tax_insert = [];
            $i = 0;

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


                $inserted_flight = [
                    "id"                           => $i,
                    "search_id"                    => $search_id,
                    "token"                        => 0,
                    "render"                       => $this->render_code,
                    "FareSourceCode"               => 0,
                    "IsPassportMandatory"          => 1,
                    "IsPassportIssueDateMandatory" => 0,
                    "IsPassportNumberMandatory"    => 1,
                    "DirectionInd"                 => $itinerary_return ? 2 : 1,
                    "RefundMethod"                 => 0,
                    "ValidatingAirlineCode"        => $itinerary_depart[0]["OperatingAirline"]["@attributes"]["Code"],
                    "flight_number"                => $itinerary_depart[0]["@attributes"]["FlightNumber"],
                    "depart_time"                  => date("Y-m-d H:i:s", strtotime(substr($itinerary_depart[0]["@attributes"]["DepartureDateTime"], 0, -6))),
                    "depart_time_range"            => $depart_range,
                    "depart_airport"               => $itinerary_depart[0]["DepartureAirport"]["@attributes"]["LocationCode"],
                    "arrival_time"                 => date("Y-m-d H:i:s", strtotime(substr($itinerary_depart[$help_var]["@attributes"]["ArrivalDateTime"], 0, -6))),
                    "arrival_airport"              => $itinerary_depart[$help_var]["ArrivalAirport"]["@attributes"]["LocationCode"],
                    "stops"                        => $help_var,
                    "total_time"                   => $total_fly_time_segments_per_min,
                    "total_waiting"                => 0,
                    "bar"                          => "nd",
                    "bar_exist"                    => 2,
                    "class"                        => MyHelperFunction::turn_OTA_code_to_class($itinerary_depart[0]["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"]),
                    "class_code"                   => $itinerary_depart[0]["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"],
                    "depart_first_airline"         => $itinerary_depart[0]["OperatingAirline"]["@attributes"]["Code"],
                ];

                $inserted_flight["airports1"] = Airport::where("code", $inserted_flight["depart_airport"])->first();
                $inserted_flight["airports2"] = Airport::where("code", $inserted_flight["arrival_airport"])->first();


                $depart_return_time = $total_fly_time_segments_per_min;


                $inserted_flight["legs"] = [];
                $inserted_flight["airlines"] = [];
                $inserted_flight["costs"] = [];
                $inserted_flight["taxes"] = [];

                $j = 0;
                foreach ($itinerary_depart as $segment) {


                    foreach ($airplanes as $airplane) {
                        if ($airplane->code == $segment["Equipment"]["@attributes"]["AirEquipType"]) {
                            $aircraft = $airplane;
                            break;
                        }
                    }

                    $leg = [
                        "seats_remaining"           => $segment["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigQuantity"],
                        "aircraft_type"             => isset($aircraft) ? $aircraft->manufacture . ' ' . $aircraft->code : $segment["Equipment"]["@attributes"]["AirEquipType"],
                        "aircraft_type_description" => isset($aircraft) ? $aircraft->description : $segment["Equipment"]["@attributes"]["AirEquipType"],
                        "RPH"                       => $segment["@attributes"]["RPH"],
                        "leg_flight_number"         => $segment["@attributes"]["FlightNumber"],
                        "cabin_class"               => MyHelperFunction::turn_OTA_code_to_class($segment["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"]),
                        "cabin_class_code"          => $segment["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"],
                        "leg_depart_time"           => date("Y-m-d H:i:s", strtotime(substr($segment["@attributes"]["DepartureDateTime"], 0, -6))),
                        "leg_depart_airport"        => $segment["DepartureAirport"]["@attributes"]["LocationCode"],
                        "leg_arrival_time"          => date("Y-m-d H:i:s", strtotime(substr($segment["@attributes"]["ArrivalDateTime"], 0, -6))),
                        "leg_arrival_airport"       => $segment["ArrivalAirport"]["@attributes"]["LocationCode"],
                        "leg_time"                  => $total_fly_time_segments_per_min,
                        "leg_waiting"               => 0,
                        "leg_airline_code"          => $segment["OperatingAirline"]["@attributes"]["Code"],
                        "is_charter"                => 0,
                        "is_return"                 => 0,
                        "leg_bar"                   => "nd",
                        "leg_bar_exist"             => 2,
                        "fare_basis_code"           => $FareBasisCode[0],
                        "fareRPH"                   => json_decode(json_encode($FareBasisCodeXmlModel[0]->attributes()->fareRPH), true)[0],
                    ];

                    $leg["airports1"] = Airport::where("code", $leg["leg_depart_airport"])->first();
                    $leg["airports2"] = Airport::where("code", $leg["leg_arrival_airport"])->first();
                    $leg["airlines"] = Airline::where("code", $leg["leg_airline_code"])->first();

                    $inserted_flight["legs"][] = $leg;

                    $airline = Airline::where("code", $segment["OperatingAirline"]["@attributes"]["Code"])->first();
                    $airline->is_return = 0;
                    $inserted_flight["airlines"][] = $airline;

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

                    $inserted_flight["return_flight_number"] = $itinerary_return[0]["@attributes"]["FlightNumber"];
                    $inserted_flight["return_depart_time"] = date("Y-m-d H:i:s", strtotime(substr($itinerary_return[0]["@attributes"]["DepartureDateTime"], 0, -6)));
                    $inserted_flight["return_depart_time_range"] = $return_depart_range;
                    $inserted_flight["return_depart_airport"] = $itinerary_return[0]["DepartureAirport"]["@attributes"]["LocationCode"];
                    $inserted_flight["return_arrival_time"] = date("Y-m-d H:i:s", strtotime(substr($itinerary_return[$help_var2]["@attributes"]["ArrivalDateTime"], 0, -6)));
                    $inserted_flight["return_arrival_airport"] = $itinerary_return[$help_var2]["ArrivalAirport"]["@attributes"]["LocationCode"];
                    $inserted_flight["return_stops"] = $help_var2;
                    $inserted_flight["return_total_time"] = $total_return_fly_time_segments_per_min;
                    $inserted_flight["return_total_waiting"] = 0;
                    $inserted_flight["return_bar"] = "nd";
                    $inserted_flight["return_bar_exist"] = 2;
                    $inserted_flight["return_class"] = MyHelperFunction::turn_OTA_code_to_class($itinerary_return[0]["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"]);
                    $inserted_flight["return_class_code"] = $itinerary_return[0]["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"];
                    $inserted_flight["return_first_airline"] = $itinerary_return[0]["OperatingAirline"]["@attributes"]["Code"];

                    $inserted_flight["airports3"] = Airport::where("code", $inserted_flight["return_depart_airport"])->first();
                    $inserted_flight["airports4"] = Airport::where("code", $inserted_flight["return_arrival_airport"])->first();


                    $depart_return_time += $total_return_fly_time_segments_per_min;

                    foreach ($itinerary_return as $segment) {

                        foreach ($airplanes as $airplane) {
                            if ($airplane->code == $segment["Equipment"]["@attributes"]["AirEquipType"]) {
                                $aircraft = $airplane;
                                break;
                            }
                        }

                        $leg = [
                            "seats_remaining"           => $segment["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigQuantity"],
                            "aircraft_type"             => isset($aircraft) ? $aircraft->manufacture . ' ' . $aircraft->code : $segment["Equipment"]["@attributes"]["AirEquipType"],
                            "aircraft_type_description" => isset($aircraft) ? $aircraft->description : $segment["Equipment"]["@attributes"]["AirEquipType"],
                            "RPH"                       => $segment["@attributes"]["RPH"],
                            "leg_flight_number"         => $segment["@attributes"]["FlightNumber"],
                            "cabin_class"               => MyHelperFunction::turn_OTA_code_to_class($segment["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"]),
                            "cabin_class_code"          => $segment["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"],
                            "leg_depart_time"           => $segment["@attributes"]["DepartureDateTime"],
                            "leg_depart_airport"        => $segment["DepartureAirport"]["@attributes"]["LocationCode"],
                            "leg_arrival_time"          => $segment["@attributes"]["ArrivalDateTime"],
                            "leg_arrival_airport"       => $segment["ArrivalAirport"]["@attributes"]["LocationCode"],
                            "leg_time"                  => $total_return_fly_time_segments_per_min,
                            "leg_waiting"               => 0,
                            "leg_airline_code"          => $segment["OperatingAirline"]["@attributes"]["Code"],
                            "is_charter"                => 0,
                            "is_return"                 => 1,
                            "leg_bar"                   => "nd",
                            "leg_bar_exist"             => 2,
                            "fare_basis_code"           => $FareBasisCode[1],
                            "fareRPH"                   => json_decode(json_encode($FareBasisCodeXmlModel[1]->attributes()->fareRPH), true)[0],
                        ];

                        $leg["airports1"] = Airport::where("code", $leg["leg_depart_airport"])->first();
                        $leg["airports2"] = Airport::where("code", $leg["leg_arrival_airport"])->first();
                        $leg["airlines"] = Airline::where("code", $leg["leg_airline_code"])->first();

                        $inserted_flight["legs"][] = $leg;

                        $airline = Airline::where("code", $segment["OperatingAirline"]["@attributes"]["Code"])->first();
                        $airline->is_return = 1;
                        $inserted_flight["airlines"][] = $airline;


                        $j++;
                    }

                } else {
                    $inserted_flight["return_flight_number"] = null;
                    $inserted_flight["return_depart_time"] = null;
                    $inserted_flight["return_depart_time_range"] = null;
                    $inserted_flight["return_depart_airport"] = null;
                    $inserted_flight["return_arrival_time"] = null;
                    $inserted_flight["return_arrival_airport"] = null;
                    $inserted_flight["return_stops"] = null;
                    $inserted_flight["return_total_time"] = null;
                    $inserted_flight["return_total_waiting"] = null;
                    $inserted_flight["return_bar"] = null;
                    $inserted_flight["return_bar_exist"] = 0;
                    $inserted_flight["return_class"] = null;
                    $inserted_flight["return_class_code"] = null;
                    $inserted_flight["return_first_airline"] = null;
                }
                $inserted_flight["depart_return_time"] = $depart_return_time;

                $price_addition_adult = 0;
                $price_addition_child = 0;
                $price_addition_infant = 0;
                $commission_adult = 0;
                $commission_child = 0;
                $commission_infant = 0;
                if (Auth::check() && Auth::user()->role == User::agency) {
                    $user = Auth::user();
                    $price_addition_adult = $user->balance->commission_adult - $user->balance->discount_adult;
                    $price_addition_child = $user->balance->commission_child - $user->balance->discount_child;
                    $price_addition_infant = $user->balance->commission_infant - $user->balance->discount_infant;
                    $commission_adult = $user->balance->commission_adult;
                    $commission_child = $user->balance->commission_child;
                    $commission_infant = $user->balance->commission_infant;
                }

                $cost_insert[$i]["FareType"] = 1;
                $cost_insert[$i]["VendorTotalFare"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["TotalFare"]["@attributes"]["Amount"];
                $cost_insert[$i]["TotalCommission"] = 0;
                $cost_insert[$i]["TotalTax"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["TotalFare"]["@attributes"]["Amount"] - $item["AirItineraryPricingInfo"]["ItinTotalFare"]["BaseFare"]["@attributes"]["Amount"];
                $cost_insert[$i]["ServiceTax"] = 0;
                $cost_insert[$i]["Currency"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["TotalFare"]["@attributes"]["CurrencyCode"];
                $cost_insert[$i]["FarePerAdult"] = $calc_price->index($PTC_FareBreakdown[0]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"], 0, $itinerary_depart[0]["OperatingAirline"]["@attributes"]["Code"], 'iran_air', $inserted_flight["depart_airport"], $inserted_flight["arrival_airport"]); //total fare per adult
                $cost_insert[$i]["serviceAdult"] = $cost_insert[$i]["FarePerAdult"] - $PTC_FareBreakdown[0]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"] - $price_addition_adult; //service fee per adult
                $cost_insert[$i]["adult"] = $PTC_FareBreakdown[0]["PassengerTypeQuantity"]["@attributes"]["Quantity"]; //number of adult
                $cost_insert[$i]["AgencyCommissionAdult"] = $commission_adult;
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
                        $cost_insert[$i]["FarePerChild"] = $calc_price->index($PTC_FareBreakdown[1]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"], 1, $itinerary_depart[0]["OperatingAirline"]["@attributes"]["Code"], 'iran_air', $inserted_flight["depart_airport"], $inserted_flight["arrival_airport"]); //per child
                        $cost_insert[$i]["serviceChild"] = $cost_insert[$i]["FarePerChild"] - $PTC_FareBreakdown[1]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"] - $price_addition_child; //service fee per child
                        $cost_insert[$i]["child"] = $PTC_FareBreakdown[1]["PassengerTypeQuantity"]["@attributes"]["Quantity"]; //number of child
                        $calc_price->setCount($cost_insert[$i]["child"], 1);
                        $cost_insert[$i]["taxChild"] = $PTC_FareBreakdown[1]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"] - $PTC_FareBreakdown[1]["PassengerFare"]["BaseFare"]["@attributes"]["Amount"];
                        $cost_insert[$i]["AgencyCommissionChild"] = $commission_child;
                        $tax_type = 1;
                    } else {
                        $cost_insert[$i]["FarePerInf"] = $calc_price->index($PTC_FareBreakdown[1]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"], 2, $itinerary_depart[0]["OperatingAirline"]["@attributes"]["Code"], 'iran_air', $inserted_flight["depart_airport"], $inserted_flight["arrival_airport"]); //per inf
                        $cost_insert[$i]["serviceInfant"] = $cost_insert[$i]["FarePerInf"] - $PTC_FareBreakdown[1]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"] - $price_addition_infant; //service fee per inf
                        $cost_insert[$i]["infant"] = $PTC_FareBreakdown[1]["PassengerTypeQuantity"]["@attributes"]["Quantity"]; //number of inf
                        $calc_price->setCount($cost_insert[$i]["infant"], 2);
                        $cost_insert[$i]["taxInfant"] = $PTC_FareBreakdown[1]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"] - $PTC_FareBreakdown[1]["PassengerFare"]["BaseFare"]["@attributes"]["Amount"];
                        $cost_insert[$i]["AgencyCommissionInfant"] = $commission_infant;
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

                        $cost_insert[$i]["FarePerInf"] = $calc_price->index($PTC_FareBreakdown[2]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"], 2, $itinerary_depart[0]["OperatingAirline"]["@attributes"]["Code"], 'iran_air', $inserted_flight["depart_airport"], $inserted_flight["arrival_airport"]); //per inf
                        $cost_insert[$i]["serviceInfant"] = $cost_insert[$i]["FarePerInf"] - $PTC_FareBreakdown[2]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"] - $price_addition_infant; //service fee per inf
                        $cost_insert[$i]["infant"] = $PTC_FareBreakdown[2]["PassengerTypeQuantity"]["@attributes"]["Quantity"]; //number of inf
                        $calc_price->setCount($cost_insert[$i]["infant"], 2);
                        $cost_insert[$i]["taxInfant"] = $PTC_FareBreakdown[2]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"] - $PTC_FareBreakdown[2]["PassengerFare"]["BaseFare"]["@attributes"]["Amount"];
                        $cost_insert[$i]["AgencyCommissionInfant"] = $commission_infant;

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
                $cost_insert[$i]["child"] = $cost_insert[$i]["child"] ?? 0;
                $cost_insert[$i]["infant"] = $cost_insert[$i]["infant"] ?? 0;

                $cost_insert[$i]["TotalFare"] = $calc_price->getTotal();
                $cost_insert[$i]["TotalAgencyCommission"] = $calc_price->getTotalAgencyCommission();

                $inserted_flight = array_merge($inserted_flight, $cost_insert[$i]);
                $inserted_flight["taxes"] = $tax_insert[$i];

                $airline_code = $inserted_flight["ValidatingAirlineCode"];

                if (!isset($airlines_list[$airline_code])) {
                    $airlines_list[$airline_code] = [];
                }

                $airline = Airline::where("code", $airline_code)->first();

                $airline_array = ["airline" => $airline, "costs" => $cost_insert[$i], "stops" => $inserted_flight["stops"], "return_stops" => $inserted_flight["return_stops"], "depart_time" => $inserted_flight["depart_time"]];

                for ($k = 0; $k <= 2; $k++) {
                    if (!isset($airlines_list[$airline_code][$k])) {
                        $airlines_list[$airline_code][$k] = $airline_array;
                        break;
                    } else {
                        if ($airlines_list[$airline_code][$k]["stops"] > $inserted_flight["stops"]) {
                            if (isset($airlines_list[$airline_code][$k + 1])) {
                                $airlines_list[$airline_code][$k + 2] = $airlines_list[$airline_code][$k + 1];
                            }
                            $x = $airlines_list[$airline_code][$k];
                            $airlines_list[$airline_code][$k] = $airline_array;
                            $airlines_list[$airline_code][$k + 1] = $x;
                            break;
                        } elseif ($airlines_list[$airline_code][$k]["stops"] == $inserted_flight["stops"]) {
                            if ($airlines_list[$airline_code][$k]["costs"]["TotalFare"] > $cost_insert[$i]["TotalFare"]) {
                                $airlines_list[$airline_code][$k]["costs"] = $cost_insert[$i];
                            }
                            break;
                        }
                    }
                }

                if (!isset($airlines_filter_list[$airline_code]) || $airlines_filter_list[$airline_code]["totalFare"] > $cost_insert[$i]["TotalFare"]) {
                    $airlines_filter_list[$airline_code] = ["airline" => $airline, "totalFare" => $cost_insert[$i]["TotalFare"]];
                }

                for ($k = 0; $k <= 2; $k++) {
                    if (!isset($flight_grouped[$k])) {
                        $flight_grouped[$k] = $inserted_flight["stops"];
                        break;
                    }
                    if ($flight_grouped[$k] > $inserted_flight["stops"]) {
                        $x = $flight_grouped[$k];
                        $flight_grouped[$k] = $inserted_flight["stops"];
                        $flight_grouped[$k + 1] = $x;
                        break;
                    }
                    if ($flight_grouped[$k] == $inserted_flight["stops"]) {
                        break;
                    }
                }

                $inserted_flight = $this->get_bag_info($inserted_flight);
                $flights[] = $inserted_flight;

                $i++;
            }
        }

        usort($airlines_list, function ($item1, $item2) {
            if ($item2[0]["costs"]["TotalFare"] == $item1[0]["costs"]["TotalFare"]) {
                if (isset($item1[1]) && isset($item2[1])) {
                    return $item1[1]["costs"]['TotalFare'] <=> $item2[1]["costs"]['TotalFare'];
                }
            }

            return $item1[0]["costs"]['TotalFare'] <=> $item2[0]["costs"]['TotalFare'];

        });

        $last = Carbon::now();

        return ["flights" => $flights, "airlines_list" => $airlines_list, "airlines_filter_list" => $airlines_filter_list, "flight_grouped" => $flight_grouped];

    }

    public function lowfaresearchMulti($origin, $destination, $depart, $origin2, $destination2, $depart2, $class, $adl, $chl, $inf, $none_stop, $search_id, $origin3, $destination3, $depart3, $origin4, $destination4, $depart4)
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
                "AirTripType"      => "Multi",
            ],

        ];

        $array["OriginDestinationInformations"][] = [
            "DepartureDateTime"       => $depart2,
            "DestinationLocationCode" => $destination2,
            "OriginLocationCode"      => $origin2,
        ];

        if ($origin3 != null) {
            $array["OriginDestinationInformations"][] = [
                "DepartureDateTime"       => $depart3,
                "DestinationLocationCode" => $destination3,
                "OriginLocationCode"      => $origin3,
            ];
        }

        if ($origin4 != null) {
            $array["OriginDestinationInformations"][] = [
                "DepartureDateTime"       => $depart4,
                "DestinationLocationCode" => $destination4,
                "OriginLocationCode"      => $origin4,
            ];
        }

        if (isset($none_stop) and $none_stop == 1) {
            $array["TravelPreference"]["MaxStopsQuantity"] = "Direct";
        }


        $req = $this->irr->LowFareSearch($array);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 400);
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

        $airlines_list = [];
        $airlines_filter_list = [];
        $flight_grouped = [];
        $flights = [];

        if (!empty($response) && isset($response["Success"])) {


            $response = $response["PricedItineraries"]["PricedItinerary"];
            if (!isset($response[0])) {
                $hlp[0] = $response;
                $response = $hlp;
            }


            $cost_insert = [];
            $tax_insert = [];
            $final_tax_insert = [];
            $i = 0;

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

                $itinerary_depart = $item["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][0]["FlightSegment"];

                $other_flights = [];
                $none_stop_flight = 0;

                $other_flights[0] = $item["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][1]["FlightSegment"];

                if (isset($item["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][2])) {
                    $other_flights[1] = $item["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][2]["FlightSegment"];
                }
                if (isset($item["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][3])) {
                    $other_flights[2] = $item["AirItinerary"]["OriginDestinationOptions"]["OriginDestinationOption"][3]["FlightSegment"];
                }

                if (!isset($itinerary_depart[0])) {
                    $hlp[0] = $itinerary_depart;
                    $itinerary_depart = $hlp;
                }
                foreach ($other_flights as $other_flight) {
                    if (!isset($other_flight[0])) {
                        $hlp[0] = $other_flight;
                        $other_flight = $hlp;
                    }
                    if (sizeof($other_flight) > 0) {
                        $none_stop_flight = 1;
                    }
                }
                $help_var = sizeof($itinerary_depart) - 1;

                if ($help_var > 0 || $none_stop_flight) {
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


                $inserted_flight = [
                    "id"                           => $i,
                    "search_id"                    => $search_id,
                    "token"                        => 0,
                    "render"                       => $this->render_code,
                    "FareSourceCode"               => 0,
                    "IsPassportMandatory"          => 1,
                    "IsPassportIssueDateMandatory" => 0,
                    "IsPassportNumberMandatory"    => 1,
                    "DirectionInd"                 => $itinerary_return ? 2 : 1,
                    "RefundMethod"                 => 0,
                    "ValidatingAirlineCode"        => $itinerary_depart[0]["OperatingAirline"]["@attributes"]["Code"],
                    "flight_number"                => $itinerary_depart[0]["@attributes"]["FlightNumber"],
                    "depart_time"                  => date("Y-m-d H:i:s", strtotime(substr($itinerary_depart[0]["@attributes"]["DepartureDateTime"], 0, -6))),
                    "depart_time_range"            => $depart_range,
                    "depart_airport"               => $itinerary_depart[0]["DepartureAirport"]["@attributes"]["LocationCode"],
                    "arrival_time"                 => date("Y-m-d H:i:s", strtotime(substr($itinerary_depart[$help_var]["@attributes"]["ArrivalDateTime"], 0, -6))),
                    "arrival_airport"              => $itinerary_depart[$help_var]["ArrivalAirport"]["@attributes"]["LocationCode"],
                    "stops"                        => $help_var,
                    "total_time"                   => $total_fly_time_segments_per_min,
                    "total_waiting"                => 0,
                    "bar"                          => "nd",
                    "bar_exist"                    => 2,
                    "class"                        => MyHelperFunction::turn_OTA_code_to_class($itinerary_depart[0]["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"]),
                    "class_code"                   => $itinerary_depart[0]["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"],
                    "depart_first_airline"         => $itinerary_depart[0]["OperatingAirline"]["@attributes"]["Code"],
                ];

                $inserted_flight["airports1"] = Airport::where("code", $inserted_flight["depart_airport"])->first();
                $inserted_flight["airports2"] = Airport::where("code", $inserted_flight["arrival_airport"])->first();


                $depart_return_time = $total_fly_time_segments_per_min;


                $inserted_flight["legs"] = [];
                $inserted_flight["airlines"] = [];
                $inserted_flight["costs"] = [];
                $inserted_flight["taxes"] = [];

                $j = 0;
                foreach ($itinerary_depart as $segment) {


                    foreach ($airplanes as $airplane) {
                        if ($airplane->code == $segment["Equipment"]["@attributes"]["AirEquipType"]) {
                            $aircraft = $airplane;
                            break;
                        }
                    }

                    $leg = [
                        "seats_remaining"           => $segment["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigQuantity"],
                        "aircraft_type"             => isset($aircraft) ? $aircraft->manufacture . ' ' . $aircraft->code : $segment["Equipment"]["@attributes"]["AirEquipType"],
                        "aircraft_type_description" => isset($aircraft) ? $aircraft->description : $segment["Equipment"]["@attributes"]["AirEquipType"],
                        "RPH"                       => $segment["@attributes"]["RPH"],
                        "leg_flight_number"         => $segment["@attributes"]["FlightNumber"],
                        "cabin_class"               => MyHelperFunction::turn_OTA_code_to_class($segment["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"]),
                        "cabin_class_code"          => $segment["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"],
                        "leg_depart_time"           => date("Y-m-d H:i:s", strtotime(substr($segment["@attributes"]["DepartureDateTime"], 0, -6))),
                        "leg_depart_airport"        => $segment["DepartureAirport"]["@attributes"]["LocationCode"],
                        "leg_arrival_time"          => date("Y-m-d H:i:s", strtotime(substr($segment["@attributes"]["ArrivalDateTime"], 0, -6))),
                        "leg_arrival_airport"       => $segment["ArrivalAirport"]["@attributes"]["LocationCode"],
                        "leg_time"                  => $total_fly_time_segments_per_min,
                        "leg_waiting"               => 0,
                        "leg_airline_code"          => $segment["OperatingAirline"]["@attributes"]["Code"],
                        "is_charter"                => 0,
                        "is_return"                 => 0,
                        "leg_bar"                   => "nd",
                        "leg_bar_exist"             => 2,
                        "fare_basis_code"           => $FareBasisCode[0],
                        "fareRPH"                   => json_decode(json_encode($FareBasisCodeXmlModel[0]->attributes()->fareRPH), true)[0],
                    ];

                    $leg["airports1"] = Airport::where("code", $leg["leg_depart_airport"])->first();
                    $leg["airports2"] = Airport::where("code", $leg["leg_arrival_airport"])->first();
                    $leg["airlines"] = Airline::where("code", $leg["leg_airline_code"])->first();

                    $inserted_flight["legs"][] = $leg;

                    $airline = Airline::where("code", $segment["OperatingAirline"]["@attributes"]["Code"])->first();
                    $airline->is_return = 0;
                    $inserted_flight["airlines"][] = $airline;

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

                    $inserted_flight["return_flight_number"] = $itinerary_return[0]["@attributes"]["FlightNumber"];
                    $inserted_flight["return_depart_time"] = date("Y-m-d H:i:s", strtotime(substr($itinerary_return[0]["@attributes"]["DepartureDateTime"], 0, -6)));
                    $inserted_flight["return_depart_time_range"] = $return_depart_range;
                    $inserted_flight["return_depart_airport"] = $itinerary_return[0]["DepartureAirport"]["@attributes"]["LocationCode"];
                    $inserted_flight["return_arrival_time"] = date("Y-m-d H:i:s", strtotime(substr($itinerary_return[$help_var2]["@attributes"]["ArrivalDateTime"], 0, -6)));
                    $inserted_flight["return_arrival_airport"] = $itinerary_return[$help_var2]["ArrivalAirport"]["@attributes"]["LocationCode"];
                    $inserted_flight["return_stops"] = $help_var2;
                    $inserted_flight["return_total_time"] = $total_return_fly_time_segments_per_min;
                    $inserted_flight["return_total_waiting"] = 0;
                    $inserted_flight["return_bar"] = "nd";
                    $inserted_flight["return_bar_exist"] = 2;
                    $inserted_flight["return_class"] = MyHelperFunction::turn_OTA_code_to_class($itinerary_return[0]["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"]);
                    $inserted_flight["return_class_code"] = $itinerary_return[0]["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"];
                    $inserted_flight["return_first_airline"] = $itinerary_return[0]["OperatingAirline"]["@attributes"]["Code"];

                    $inserted_flight["airports3"] = Airport::where("code", $inserted_flight["return_depart_airport"])->first();
                    $inserted_flight["airports4"] = Airport::where("code", $inserted_flight["return_arrival_airport"])->first();


                    $depart_return_time += $total_return_fly_time_segments_per_min;

                    foreach ($itinerary_return as $segment) {

                        foreach ($airplanes as $airplane) {
                            if ($airplane->code == $segment["Equipment"]["@attributes"]["AirEquipType"]) {
                                $aircraft = $airplane;
                                break;
                            }
                        }

                        $leg = [
                            "seats_remaining"           => $segment["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigQuantity"],
                            "aircraft_type"             => isset($aircraft) ? $aircraft->manufacture . ' ' . $aircraft->code : $segment["Equipment"]["@attributes"]["AirEquipType"],
                            "aircraft_type_description" => isset($aircraft) ? $aircraft->description : $segment["Equipment"]["@attributes"]["AirEquipType"],
                            "RPH"                       => $segment["@attributes"]["RPH"],
                            "leg_flight_number"         => $segment["@attributes"]["FlightNumber"],
                            "cabin_class"               => MyHelperFunction::turn_OTA_code_to_class($segment["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"]),
                            "cabin_class_code"          => $segment["BookingClassAvails"]["BookingClassAvail"]["@attributes"]["ResBookDesigCode"],
                            "leg_depart_time"           => $segment["@attributes"]["DepartureDateTime"],
                            "leg_depart_airport"        => $segment["DepartureAirport"]["@attributes"]["LocationCode"],
                            "leg_arrival_time"          => $segment["@attributes"]["ArrivalDateTime"],
                            "leg_arrival_airport"       => $segment["ArrivalAirport"]["@attributes"]["LocationCode"],
                            "leg_time"                  => $total_return_fly_time_segments_per_min,
                            "leg_waiting"               => 0,
                            "leg_airline_code"          => $segment["OperatingAirline"]["@attributes"]["Code"],
                            "is_charter"                => 0,
                            "is_return"                 => 1,
                            "leg_bar"                   => "nd",
                            "leg_bar_exist"             => 2,
                            "fare_basis_code"           => $FareBasisCode[1],
                            "fareRPH"                   => json_decode(json_encode($FareBasisCodeXmlModel[1]->attributes()->fareRPH), true)[0],
                        ];

                        $leg["airports1"] = Airport::where("code", $leg["leg_depart_airport"])->first();
                        $leg["airports2"] = Airport::where("code", $leg["leg_arrival_airport"])->first();
                        $leg["airlines"] = Airline::where("code", $leg["leg_airline_code"])->first();

                        $inserted_flight["legs"][] = $leg;

                        $airline = Airline::where("code", $segment["OperatingAirline"]["@attributes"]["Code"])->first();
                        $airline->is_return = 1;
                        $inserted_flight["airlines"][] = $airline;


                        $j++;
                    }

                } else {
                    $inserted_flight["return_flight_number"] = null;
                    $inserted_flight["return_depart_time"] = null;
                    $inserted_flight["return_depart_time_range"] = null;
                    $inserted_flight["return_depart_airport"] = null;
                    $inserted_flight["return_arrival_time"] = null;
                    $inserted_flight["return_arrival_airport"] = null;
                    $inserted_flight["return_stops"] = null;
                    $inserted_flight["return_total_time"] = null;
                    $inserted_flight["return_total_waiting"] = null;
                    $inserted_flight["return_bar"] = null;
                    $inserted_flight["return_bar_exist"] = 0;
                    $inserted_flight["return_class"] = null;
                    $inserted_flight["return_class_code"] = null;
                    $inserted_flight["return_first_airline"] = null;
                }
                $inserted_flight["depart_return_time"] = $depart_return_time;

                $price_addition_adult = 0;
                $price_addition_child = 0;
                $price_addition_infant = 0;
                $commission_adult = 0;
                $commission_child = 0;
                $commission_infant = 0;
                if (Auth::check() && Auth::user()->role == User::agency) {
                    $user = Auth::user();
                    $price_addition_adult = $user->balance->commission_adult - $user->balance->discount_adult;
                    $price_addition_child = $user->balance->commission_child - $user->balance->discount_child;
                    $price_addition_infant = $user->balance->commission_infant - $user->balance->discount_infant;
                    $commission_adult = $user->balance->commission_adult;
                    $commission_child = $user->balance->commission_child;
                    $commission_infant = $user->balance->commission_infant;
                }

                $cost_insert[$i]["FareType"] = 1;
                $cost_insert[$i]["VendorTotalFare"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["TotalFare"]["@attributes"]["Amount"];
                $cost_insert[$i]["TotalCommission"] = 0;
                $cost_insert[$i]["TotalTax"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["TotalFare"]["@attributes"]["Amount"] - $item["AirItineraryPricingInfo"]["ItinTotalFare"]["BaseFare"]["@attributes"]["Amount"];
                $cost_insert[$i]["ServiceTax"] = 0;
                $cost_insert[$i]["Currency"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["TotalFare"]["@attributes"]["CurrencyCode"];
                $cost_insert[$i]["FarePerAdult"] = $calc_price->index($PTC_FareBreakdown[0]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"], 0, $itinerary_depart[0]["OperatingAirline"]["@attributes"]["Code"], 'iran_air'); //total fare per adult
                $cost_insert[$i]["serviceAdult"] = $cost_insert[$i]["FarePerAdult"] - $PTC_FareBreakdown[0]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"] - $price_addition_adult; //service fee per adult
                $cost_insert[$i]["adult"] = $PTC_FareBreakdown[0]["PassengerTypeQuantity"]["@attributes"]["Quantity"]; //number of adult
                $cost_insert[$i]["AgencyCommissionAdult"] = $commission_adult;
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
                        $cost_insert[$i]["FarePerChild"] = $calc_price->index($PTC_FareBreakdown[1]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"], 1, $itinerary_depart[0]["OperatingAirline"]["@attributes"]["Code"], 'iran_air'); //per child
                        $cost_insert[$i]["serviceChild"] = $cost_insert[$i]["FarePerChild"] - $PTC_FareBreakdown[1]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"] - $price_addition_child; //service fee per child
                        $cost_insert[$i]["child"] = $PTC_FareBreakdown[1]["PassengerTypeQuantity"]["@attributes"]["Quantity"]; //number of child
                        $calc_price->setCount($cost_insert[$i]["child"], 1);
                        $cost_insert[$i]["taxChild"] = $PTC_FareBreakdown[1]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"] - $PTC_FareBreakdown[1]["PassengerFare"]["BaseFare"]["@attributes"]["Amount"];
                        $cost_insert[$i]["AgencyCommissionChild"] = $commission_child;
                        $tax_type = 1;
                    } else {
                        $cost_insert[$i]["FarePerInf"] = $calc_price->index($PTC_FareBreakdown[1]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"], 2, $itinerary_depart[0]["OperatingAirline"]["@attributes"]["Code"], 'iran_air'); //per inf
                        $cost_insert[$i]["serviceInfant"] = $cost_insert[$i]["FarePerInf"] - $PTC_FareBreakdown[1]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"] - $price_addition_infant; //service fee per inf
                        $cost_insert[$i]["infant"] = $PTC_FareBreakdown[1]["PassengerTypeQuantity"]["@attributes"]["Quantity"]; //number of inf
                        $calc_price->setCount($cost_insert[$i]["infant"], 2);
                        $cost_insert[$i]["taxInfant"] = $PTC_FareBreakdown[1]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"] - $PTC_FareBreakdown[1]["PassengerFare"]["BaseFare"]["@attributes"]["Amount"];
                        $cost_insert[$i]["AgencyCommissionInfant"] = $commission_infant;
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

                        $cost_insert[$i]["FarePerInf"] = $calc_price->index($PTC_FareBreakdown[2]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"], 2, $itinerary_depart[0]["OperatingAirline"]["@attributes"]["Code"], 'iran_air'); //per inf
                        $cost_insert[$i]["serviceInfant"] = $cost_insert[$i]["FarePerInf"] - $PTC_FareBreakdown[2]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"] - $price_addition_infant; //service fee per inf
                        $cost_insert[$i]["infant"] = $PTC_FareBreakdown[2]["PassengerTypeQuantity"]["@attributes"]["Quantity"]; //number of inf
                        $calc_price->setCount($cost_insert[$i]["infant"], 2);
                        $cost_insert[$i]["taxInfant"] = $PTC_FareBreakdown[2]["PassengerFare"]["TotalFare"]["@attributes"]["Amount"] - $PTC_FareBreakdown[2]["PassengerFare"]["BaseFare"]["@attributes"]["Amount"];
                        $cost_insert[$i]["AgencyCommissionInfant"] = $commission_infant;

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
                $cost_insert[$i]["child"] = $cost_insert[$i]["child"] ?? 0;
                $cost_insert[$i]["infant"] = $cost_insert[$i]["infant"] ?? 0;

                $cost_insert[$i]["TotalFare"] = $calc_price->getTotal();
                $cost_insert[$i]["TotalAgencyCommission"] = $calc_price->getTotalAgencyCommission();

                $inserted_flight = array_merge($inserted_flight, $cost_insert[$i]);
                $inserted_flight["taxes"] = $tax_insert[$i];

                $airline_code = $inserted_flight["ValidatingAirlineCode"];

                if (!isset($airlines_list[$airline_code])) {
                    $airlines_list[$airline_code] = [];
                }

                $airline = Airline::where("code", $airline_code)->first();

                $airline_array = ["airline" => $airline, "costs" => $cost_insert[$i], "stops" => $inserted_flight["stops"], "return_stops" => $inserted_flight["return_stops"], "depart_time" => $inserted_flight["depart_time"]];

                for ($k = 0; $k <= 2; $k++) {
                    if (!isset($airlines_list[$airline_code][$k])) {
                        $airlines_list[$airline_code][$k] = $airline_array;
                        break;
                    } else {
                        if ($airlines_list[$airline_code][$k]["stops"] > $inserted_flight["stops"]) {
                            if (isset($airlines_list[$airline_code][$k + 1])) {
                                $airlines_list[$airline_code][$k + 2] = $airlines_list[$airline_code][$k + 1];
                            }
                            $x = $airlines_list[$airline_code][$k];
                            $airlines_list[$airline_code][$k] = $airline_array;
                            $airlines_list[$airline_code][$k + 1] = $x;
                            break;
                        } elseif ($airlines_list[$airline_code][$k]["stops"] == $inserted_flight["stops"]) {
                            if ($airlines_list[$airline_code][$k]["costs"]["TotalFare"] > $cost_insert[$i]["TotalFare"]) {
                                $airlines_list[$airline_code][$k]["costs"] = $cost_insert[$i];
                            }
                            break;
                        }
                    }
                }

                if (!isset($airlines_filter_list[$airline_code]) || $airlines_filter_list[$airline_code]["totalFare"] > $cost_insert[$i]["TotalFare"]) {
                    $airlines_filter_list[$airline_code] = ["airline" => $airline, "totalFare" => $cost_insert[$i]["TotalFare"]];
                }

                for ($k = 0; $k <= 2; $k++) {
                    if (!isset($flight_grouped[$k])) {
                        $flight_grouped[$k] = $inserted_flight["stops"];
                        break;
                    }
                    if ($flight_grouped[$k] > $inserted_flight["stops"]) {
                        $x = $flight_grouped[$k];
                        $flight_grouped[$k] = $inserted_flight["stops"];
                        $flight_grouped[$k + 1] = $x;
                        break;
                    }
                    if ($flight_grouped[$k] == $inserted_flight["stops"]) {
                        break;
                    }
                }

                $inserted_flight = $this->get_bag_info($inserted_flight);
                $flights[] = $inserted_flight;

                $i++;
            }
        }

        usort($airlines_list, function ($item1, $item2) {
            if ($item2[0]["costs"]["TotalFare"] == $item1[0]["costs"]["TotalFare"]) {
                if (isset($item1[1]) && isset($item2[1])) {
                    return $item1[1]["costs"]['TotalFare'] <=> $item2[1]["costs"]['TotalFare'];
                }
            }

            return $item1[0]["costs"]['TotalFare'] <=> $item2[0]["costs"]['TotalFare'];

        });

        $last = Carbon::now();

        return ["flights" => $flights, "airlines_list" => $airlines_list, "airlines_filter_list" => $airlines_filter_list, "flight_grouped" => $flight_grouped];

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

        $book = Book::find($book_id);

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

    public function get_bag_info($flight)
    {
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

                if (isset($rules["FareRuleText"]["FlightRefNumberRPH"][1])) {
                    $bar[1] = $bar[0];
                }
            }

            $flight['bar'] = $bar[0];
            $flight['bar_exist'] = $bar[0] ? 1 : 0;
            $flight['return_bar'] = $bar[1];
            $flight['return_bar_exist'] = $bar[1] ? 1 : 0;


            foreach ($flight["legs"] as $key => $leg) {
                if (!$leg["is_return"]) {

                    $flight["legs"][$key]['leg_bar'] = $bar[0];
                    $flight["legs"][$key]['leg_bar_exist'] = 1;

                } else {
                    $flight["legs"][$key]['leg_bar'] = $bar[1];
                    $flight["legs"][$key]['leg_bar_exist'] = 1;
                }

            }
        }

        return $flight;
    }

    public function getCondition()
    {
        return Page::where('name', 'condition_ir')->first();
    }


    public function test()
    {
        $req = $this->irr->test();
        $ch = curl_init();
        $service_url = $this->base . '/availability/lowfaresearch';

        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 400);
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
        dd($response);
    }
}

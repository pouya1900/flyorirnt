<?php


namespace App\Services\Renders;


use App\Models\Airline;
use App\Models\Airport;
use App\Models\Book;
use App\Models\Cost;
use App\Models\Tax;
use App\Models\Flight;
use App\Models\FlightAirline;
use App\Models\Leg;
use App\Models\Search;
use App\Models\Session;
use App\Models\Setting;
use App\Models\Page;
use App\Models\Airplane;
use App\Models\Scheduler;
use App\Services\MyHelperFunction;
use App\Services\SetPriceFunction;
use App\Services\Log\log;
use App\User;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use SoapClient;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\AppException;

class parto implements render_interface
{

    private $session;
    public $base;
    public $render_code;
    public $log;

    public function __construct($code = 0)
    {

        $this->log = new log();

//		Session::where('created_at','>','0')->delete();

        $config = \Illuminate\Support\Facades\Config::get("AuthInfo");

        $setting = Setting::find(1);

        if ($code == Setting::parto || ($code == 0 && $setting->flight_render == Setting::parto)) {
            $this->base = $config["parto_info"]["main"]["base"];
            $this->render_code = 1;

        } else {
            $this->base = $config["parto_info"]["demo"]["base"];
            $this->render_code = 3;

        }

        $session_obj = new Session();
        $session = $session_obj->get_session($this->render_code);


        if (strlen($session) < 2 && $session == 0) {

            if ($this->render_code == Setting::parto) {
                //			main
                $hash = strtoupper(hash('sha512', $config["parto_info"]["main"]["hash_code"]));

                $post_data = [

                    "OfficeId" => $config["parto_info"]["main"]["OfficeId"],
                    "UserName" => $config["parto_info"]["main"]["UserName"],
                    "Password" => "$hash",

                ];
            } else {
//				demo
                $hash = strtoupper(hash('sha512', $config["parto_info"]["demo"]["hash_code"]));

                $post_data = [

                    "OfficeId" => $config["parto_info"]["demo"]["OfficeId"],
                    "UserName" => $config["parto_info"]["demo"]["UserName"],
                    "Password" => "$hash",

                ];
            }


            $service_url = $this->base . '/Rest/Authenticate/CreateSession';


            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $service_url);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json",
            ]);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));

            $result = curl_exec($ch);
            $response = json_decode($result, true);
            curl_close($ch);

            if ($response) {
                $session = $response["SessionId"];
            } else {
                $session = "";
            }
            if ($session == "") {

                if (!env('APP_DEBUG')) {
                    throw new AppException();
                }
                dd("parto dosent work at this time");
            }

            $now = Carbon::now();
            Session::insert([
                "session_id" => $session,
                "render"     => $this->render_code,
                "created_at" => $now,
            ]);

        }

        $this->session = $session;

    }

    public function redirect_lowfaresearch($flight_id)
    {

        $flight = Flight::with(['costs'])->where('id', '=', $flight_id)->get();
        $flight = json_decode(json_encode($flight), true);
        $flight = $flight[0];


    }

    public function lowfaresearch($origin, $destination, $depart, $return, $class, $adl, $chl, $inf, $none_stop, $search_id, $origin2, $destination2, $depart2, $origin3, $destination3, $depart3, $origin4, $destination4, $depart4)
    {

        switch (strtolower($class)) {
            case "economy":
                $class = 'Y';
                break;
            case "premium":
                $class = 'S';
                break;
            case "business":
                $class = 'C';
                break;
            case "first":
                $class = 'F';
                break;
            default:
                $class = 'Default';
        }

        $depart = date('Y-m-d', strtotime($depart));
        if ($return != "-") {
            $return = date('Y-m-d', strtotime($return));
        } else {
            $return = null;
        }
        $airplanes = Airplane::all();

        $setting = Setting::find(1);

        $destination_airport = Airport::where('code', $destination)->first();
        $adl = intval($adl);
        $chl = intval($chl);
        $inf = intval($inf);

        $calc_price = new SetPriceFunction();

        //		test for timing
        //$test_time1 = Carbon::now();
        //		test for timing


        $service_url = $this->base . '/Rest/Air/AirLowFareSearch';

        $array = [
            "RequestOption"                 => 2,
            "AdultCount"                    => $adl,
            "ChildCount"                    => $chl,
            "InfantCount"                   => $inf,
            "NearByAirports"                => false,
            "PricingSourceType"             => 0,
            "SessionId"                     => $this->session,
            "OriginDestinationInformations" => [
                [
                    "DepartureDateTime"       => $depart,
                    "DestinationLocationCode" => $destination,
                    "OriginLocationCode"      => $origin,
                ],
            ],
            "TravelPreference"              => [
                "CabinType"        => $class,
                "MaxStopsQuantity" => 0,
                "AirTripType"      => 1,
            ],

        ];

        if ($return != null) {
            $array["OriginDestinationInformations"][1] = [
                "DepartureDateTime"       => $return,
                "DestinationLocationCode" => $origin,
                "OriginLocationCode"      => $destination,
            ];
            $array["TravelPreference"]["AirTripType"] = 2;
        }

        if ($origin2 != null) {
            $array["OriginDestinationInformations"][] = [
                "DepartureDateTime"       => $depart2,
                "DestinationLocationCode" => $destination2,
                "OriginLocationCode"      => $origin2,
            ];
            $array["TravelPreference"]["AirTripType"] = 4;
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
        }

        if (isset($none_stop) and $none_stop == 1) {
            $array["TravelPreference"]["MaxStopsQuantity"] = 2;
        }
        ini_set('memory_limit', '512M');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));

        $result = curl_exec($ch);
        $response = json_decode($result, true);
        curl_close($ch);
//		test for timing
        //$this->time2     = Carbon::now();
        //$this->diff_time = Carbon::now()->diffInSeconds( $test_time1 );
//		test for timing

        $response = array_slice($response["PricedItineraries"], 0, \config('AdminVariable.flight_max_result'));
//        $response = array_slice($response["PricedItineraries"], 0, 10);

        if (!$search_id) {
            $search = Search::create();
            $search_id = $search->id;
        }

        if (!empty($response)) {
            global $cost_insert, $tax_insert;

            $cost_insert = [];
            $tax_insert = [];
            $final_tax_insert = [];
            $leg_insert = [];
            $airline_insert = [];
            $final_airline_insert = [];
            $final_leg_insert = [];
            $i = 0;
            $leg_insert_equal = [];
            $query = "INSERT INTO flights(search_id,token,render,FareSourceCode,IsPassportMandatory,IsPassportIssueDateMandatory,IsPassportNumberMandatory,DirectionInd,RefundMethod,ValidatingAirlineCode,flight_number,depart_time,depart_time_range,depart_airport,arrival_time,arrival_airport,stops,total_time,total_waiting,bar,bar_exist,class,class_code,depart_first_airline,return_flight_number,return_depart_time,return_depart_time_range,return_depart_airport,return_arrival_time,return_arrival_airport,return_stops,return_total_time,return_total_waiting,return_bar,return_bar_exist,return_class,return_class_code,return_first_airline,depart_return_time) VALUES ($search_id";
            foreach ($response as $item) {
                $leg_insert_equal_text = "";
                $before_arrival = "";
                $different_airport_error = 0;
                foreach ($item["OriginDestinationOptions"][0]["FlightSegments"] as $segment) {
                    $baggage_equal = $this->equal_bar($segment["Baggage"]);
                    $leg_insert_equal_text .= $segment["FlightNumber"] . $baggage_equal;
                    if ($before_arrival && $before_arrival != $segment["DepartureAirportLocationCode"]) {
                        $different_airport_error = 1;
                    }

                    $before_arrival = $segment["ArrivalAirportLocationCode"];
                }
                if (isset($item["OriginDestinationOptions"][1]) and $item["DirectionInd"] == 2) {
                    $before_arrival = "";
                    foreach ($item["OriginDestinationOptions"][1]["FlightSegments"] as $segment) {
                        $baggage_equal = $this->equal_bar($segment["Baggage"]);
                        $leg_insert_equal_text .= $segment["FlightNumber"] . $baggage_equal;
                        if ($before_arrival && $before_arrival != $segment["DepartureAirportLocationCode"]) {
                            $different_airport_error = 1;
                        }

                        $before_arrival = $segment["ArrivalAirportLocationCode"];
                    }
                }

                if ($different_airport_error) {
                    continue;
                }

                if (in_array($leg_insert_equal_text, $leg_insert_equal)) {
                    continue;
                }

                $leg_insert_equal[] = $leg_insert_equal_text;

                if ($item["ValidatingAirlineCode"] == "IR" && ($setting->flight_render == Setting::iranAir || ($setting->flight_render_ajax && in_array(Setting::iranAir, json_decode($setting->flight_render_ajax, true))))) {
                    continue;
                }
                if ($item["ValidatingAirlineCode"] == "W5") {
                    continue;
                }


                $help_var2 = sizeof($item["OriginDestinationOptions"][0]["FlightSegments"]) - 1;

                if (!$destination_airport->is_city && $item["OriginDestinationOptions"][0]["FlightSegments"][$help_var2]["ArrivalAirportLocationCode"] != $destination) {
                    continue;
                }


                if ($i != 0) {
                    $query .= ",($search_id";
                }

                $depart_time = date("H", strtotime($item["OriginDestinationOptions"][0]["FlightSegments"][0]["DepartureDateTime"]));
                $depart_time_min = date("i", strtotime($item["OriginDestinationOptions"][0]["FlightSegments"][0]["DepartureDateTime"]));
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

                $query .= ",";
                $query .= "0,";
                $query .= $this->render_code . ",";
                $query .= "'" . $item["FareSourceCode"] . "'" . ",";
//                $query .= (boolval($item["IsPassportMandatory"]) ? "1" : "0") . ",";
                $query .= "1" . ",";
                $query .= (boolval($item["IsPassportIssueDateMandatory"]) ? "1" : "0") . ",";
                $query .= "1" . ",";
                $query .= $item["DirectionInd"] . ",";
                $query .= $item["RefundMethod"] . ",";
                $query .= "'" . $item["OriginDestinationOptions"][0]["FlightSegments"][0]["MarketingAirlineCode"] . "'" . ",";
                $query .= "'" . (substr($item["OriginDestinationOptions"][0]["FlightSegments"][0]["FlightNumber"], 0, 2) != $item["OriginDestinationOptions"][0]["FlightSegments"][0]["MarketingAirlineCode"] ? $item["OriginDestinationOptions"][0]["FlightSegments"][0]["MarketingAirlineCode"] : "") . $item["OriginDestinationOptions"][0]["FlightSegments"][0]["FlightNumber"] . "'" . ",";
                $query .= "'" . $item["OriginDestinationOptions"][0]["FlightSegments"][0]["DepartureDateTime"] . "'" . ",";
                $query .= $depart_range . ",";
                $query .= "'" . $item["OriginDestinationOptions"][0]["FlightSegments"][0]["DepartureAirportLocationCode"] . "'" . ",";

                $query .= "'" . $item["OriginDestinationOptions"][0]["FlightSegments"][$help_var2]["ArrivalDateTime"] . "'" . ",";
                $query .= "'" . $item["OriginDestinationOptions"][0]["FlightSegments"][$help_var2]["ArrivalAirportLocationCode"] . "'" . ",";
                $query .= $help_var2 . ",";
                $query .= $item["OriginDestinationOptions"][0]["JourneyDurationPerMinute"] . ",";
                $query .= $item["OriginDestinationOptions"][0]["ConnectionTimePerMinute"] . ",";
                $query .= "'" . $this->baggage_filter($item["OriginDestinationOptions"][0]["FlightSegments"][0]["Baggage"]) . "'" . ",";

                if (!$item["OriginDestinationOptions"][0]["FlightSegments"][0]["Baggage"] || substr($item["OriginDestinationOptions"][0]["FlightSegments"][0]["Baggage"], 0, 1) == 0) {
                    $query .= 0 . ",";
                } else {
                    $query .= 1 . ",";
                }

                $query .= $item["OriginDestinationOptions"][0]["FlightSegments"][0]["CabinClassCode"] . ",";
                $query .= "'" . $item["OriginDestinationOptions"][0]["FlightSegments"][0]["ResBookDesigCode"] . "'" . ",";
                $query .= "'" . $item["OriginDestinationOptions"][0]["FlightSegments"][0]["MarketingAirlineCode"] . "'" . ",";
                $depart_return_time = $item["OriginDestinationOptions"][0]["JourneyDurationPerMinute"] + $item["OriginDestinationOptions"][0]["ConnectionTimePerMinute"];

                $j = 0;
                foreach ($item["OriginDestinationOptions"][0]["FlightSegments"] as $segment) {

                    $airline_insert[$i][$j]["airline_code"] = $segment["MarketingAirlineCode"];
                    $airline_insert[$i][$j]["is_return"] = $segment["IsReturn"] ? 1 : 0;

                    foreach ($airplanes as $airplane) {
                        if ($airplane->code == $segment["OperatingAirline"]["Equipment"]) {
                            $aircraft = $airplane;
                            break;
                        }
                    }

                    $leg_insert[$i][$j]["aircraft_type"] = isset($aircraft) ? $aircraft->manufacture . ' ' . $aircraft->code : $segment["OperatingAirline"]["Equipment"];
                    $leg_insert[$i][$j]["aircraft_type_description"] = isset($aircraft) ? $aircraft->description : $segment["OperatingAirline"]["Equipment"];
                    $leg_insert[$i][$j]["seats_remaining"] = $segment["SeatsRemaining"];
                    $leg_insert[$i][$j]["leg_flight_number"] = (substr($segment["FlightNumber"], 0, 2) != $segment["MarketingAirlineCode"] ? $segment["MarketingAirlineCode"] : "") . $segment["FlightNumber"];
                    $leg_insert[$i][$j]["cabin_class"] = $segment["CabinClassCode"];
                    $leg_insert[$i][$j]["cabin_class_code"] = $segment["ResBookDesigCode"];
                    $leg_insert[$i][$j]["leg_depart_time"] = $segment["DepartureDateTime"];
                    $leg_insert[$i][$j]["leg_depart_airport"] = $segment["DepartureAirportLocationCode"];
                    $leg_insert[$i][$j]["leg_arrival_time"] = $segment["ArrivalDateTime"];
                    $leg_insert[$i][$j]["leg_arrival_airport"] = $segment["ArrivalAirportLocationCode"];
                    $leg_insert[$i][$j]["leg_time"] = $segment["JourneyDurationPerMinute"];
                    $leg_insert[$i][$j]["leg_waiting"] = $segment["ConnectionTimePerMinute"];
                    $leg_insert[$i][$j]["leg_airline_code"] = $segment["MarketingAirlineCode"];
                    $leg_insert[$i][$j]["is_charter"] = $segment["IsCharter"];
                    $leg_insert[$i][$j]["is_return"] = $segment["IsReturn"];
                    $leg_insert[$i][$j]["leg_bar"] = $this->baggage_filter($segment["Baggage"]);
                    $leg_insert[$i][$j]["leg_bar_exist"] = !$segment["Baggage"] || substr($segment["Baggage"], 0, 1) == 0 ? 0 : 1;


                    $j++;
                }

                if (isset($item["OriginDestinationOptions"][1]) and $item["DirectionInd"] == 2) {

                    $return_depart_time = date("H", strtotime($item["OriginDestinationOptions"][1]["FlightSegments"][0]["DepartureDateTime"]));
                    $return_depart_time_min = date("i", strtotime($item["OriginDestinationOptions"][1]["FlightSegments"][0]["DepartureDateTime"]));
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


                    $query .= "'" . (substr($item["OriginDestinationOptions"][1]["FlightSegments"][0]["FlightNumber"], 0, 2) != $item["OriginDestinationOptions"][1]["FlightSegments"][0]["MarketingAirlineCode"] ? $item["OriginDestinationOptions"][1]["FlightSegments"][0]["MarketingAirlineCode"] : "") . $item["OriginDestinationOptions"][1]["FlightSegments"][0]["FlightNumber"] . "'" . ",";
                    $query .= "'" . $item["OriginDestinationOptions"][1]["FlightSegments"][0]["DepartureDateTime"] . "'" . ",";
                    $query .= $return_depart_range . ",";
                    $query .= "'" . $item["OriginDestinationOptions"][1]["FlightSegments"][0]["DepartureAirportLocationCode"] . "'" . ",";

                    $help_var3 = sizeof($item["OriginDestinationOptions"][1]["FlightSegments"]) - 1;
                    $query .= "'" . $item["OriginDestinationOptions"][1]["FlightSegments"][$help_var3]["ArrivalDateTime"] . "'" . ",";
                    $query .= "'" . $item["OriginDestinationOptions"][1]["FlightSegments"][$help_var3]["ArrivalAirportLocationCode"] . "'" . ",";
                    $query .= $help_var3 . ",";
                    $query .= $item["OriginDestinationOptions"][1]["JourneyDurationPerMinute"] . ",";
                    $query .= $item["OriginDestinationOptions"][1]["ConnectionTimePerMinute"] . ",";
                    $query .= "'" . $this->baggage_filter($item["OriginDestinationOptions"][1]["FlightSegments"][0]["Baggage"]) . "'" . ",";

                    if (!$item["OriginDestinationOptions"][1]["FlightSegments"][0]["Baggage"] || substr($item["OriginDestinationOptions"][1]["FlightSegments"][0]["Baggage"], 0, 1) == 0) {
                        $query .= 0 . ",";
                    } else {
                        $query .= 1 . ",";
                    }

                    $query .= $item["OriginDestinationOptions"][1]["FlightSegments"][0]["CabinClassCode"] . ",";
                    $query .= "'" . $item["OriginDestinationOptions"][1]["FlightSegments"][0]["ResBookDesigCode"] . "'" . ",";
                    $query .= "'" . $item["OriginDestinationOptions"][1]["FlightSegments"][0]["MarketingAirlineCode"] . "'" . ",";

                    $depart_return_time += $item["OriginDestinationOptions"][1]["JourneyDurationPerMinute"] + $item["OriginDestinationOptions"][1]["ConnectionTimePerMinute"];

                    foreach ($item["OriginDestinationOptions"][1]["FlightSegments"] as $segment) {

                        $airline_insert[$i][$j]["airline_code"] = $segment["MarketingAirlineCode"];
                        $airline_insert[$i][$j]["is_return"] = $segment["IsReturn"] ? 1 : 0;

                        foreach ($airplanes as $airplane) {
                            if ($airplane->code == $segment["OperatingAirline"]["Equipment"]) {
                                $aircraft = $airplane;
                                break;
                            }
                        }
                        $leg_insert[$i][$j]["aircraft_type"] = isset($aircraft) ? $aircraft->manufacture . ' ' . $aircraft->code : $segment["OperatingAirline"]["Equipment"];
                        $leg_insert[$i][$j]["aircraft_type_description"] = isset($aircraft) ? $aircraft->description : $segment["OperatingAirline"]["Equipment"];
                        $leg_insert[$i][$j]["seats_remaining"] = $segment["SeatsRemaining"] ?? 0;
                        $leg_insert[$i][$j]["leg_flight_number"] = (substr($segment["FlightNumber"], 0, 2) != $segment["MarketingAirlineCode"] ? $segment["MarketingAirlineCode"] : "") . $segment["FlightNumber"];
                        $leg_insert[$i][$j]["cabin_class"] = $segment["CabinClassCode"];
                        $leg_insert[$i][$j]["cabin_class_code"] = $segment["ResBookDesigCode"];
                        $leg_insert[$i][$j]["leg_depart_time"] = $segment["DepartureDateTime"];
                        $leg_insert[$i][$j]["leg_depart_airport"] = $segment["DepartureAirportLocationCode"];
                        $leg_insert[$i][$j]["leg_arrival_time"] = $segment["ArrivalDateTime"];
                        $leg_insert[$i][$j]["leg_arrival_airport"] = $segment["ArrivalAirportLocationCode"];
                        $leg_insert[$i][$j]["leg_time"] = $segment["JourneyDurationPerMinute"];
                        $leg_insert[$i][$j]["leg_waiting"] = $segment["ConnectionTimePerMinute"];
                        $leg_insert[$i][$j]["leg_airline_code"] = $segment["MarketingAirlineCode"];
                        $leg_insert[$i][$j]["is_charter"] = $segment["IsCharter"];
                        $leg_insert[$i][$j]["is_return"] = $segment["IsReturn"];
                        $leg_insert[$i][$j]["leg_bar"] = $this->baggage_filter($segment["Baggage"]) ?? 0;
                        $leg_insert[$i][$j]["leg_bar_exist"] = !$segment["Baggage"] || substr($segment["Baggage"], 0, 1) == 0 ? 0 : 1;


                        $j++;
                    }

                } else {
                    $query .= "null,null,null,null,null,null,null,null,null,null,0,null,null,null,";
                }

                $query .= $depart_return_time;

                $query .= ")";

                $cost_insert[$i]["FareType"] = $item["AirItineraryPricingInfo"]["FareType"];
                $cost_insert[$i]["VendorTotalFare"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["TotalFare"];
                $cost_insert[$i]["TotalCommission"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["TotalCommission"];
                $cost_insert[$i]["TotalTax"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["TotalTax"];
                $cost_insert[$i]["ServiceTax"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["ServiceTax"];
                $cost_insert[$i]["Currency"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["Currency"];

                $calc_price = $this->price_type($item, $calc_price, 0, $i);


                if (isset($item["AirItineraryPricingInfo"]["PtcFareBreakdown"][1])) {

                    $calc_price = $this->price_type($item, $calc_price, 1, $i);

                    if (isset($item["AirItineraryPricingInfo"]["PtcFareBreakdown"][2])) {
                        $calc_price = $this->price_type($item, $calc_price, 2, $i);
                    }

                }


                $cost_insert[$i]["TotalFare"] = $calc_price->getTotal();
                $cost_insert[$i]["TotalAgencyCommission"] = $calc_price->getTotalAgencyCommission();


                $i++;
            }
            if ($i > 0) {
                $flight_id = Flight::my_insert($query);

                $flight_count = $flight_id;
                for ($j = 0; $j < $i; $j++) {
                    $cost_insert[$j]["flight_id"] = $flight_count;
                    $item = $tax_insert[$j];
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

            }
//		save search_id in page or cookie

//		//save search_id in page or cookie

        }

        return $search_id;

    }

    public function lowfaresearchMulti($origin, $destination, $depart, $origin2, $destination2, $depart2, $class, $adl, $chl, $inf, $none_stop, $search_id, $origin3, $destination3, $depart3, $origin4, $destination4, $depart4)
    {

        switch (strtolower($class)) {
            case "economy":
                $class = 'Y';
                break;
            case "premium":
                $class = 'S';
                break;
            case "business":
                $class = 'C';
                break;
            case "first":
                $class = 'F';
                break;
            default:
                $class = 'Default';
        }

        $depart = date('Y-m-d', strtotime($depart));

        $airplanes = Airplane::all();

        $setting = Setting::find(1);

        $destination_airports = [
            Airport::where('code', $destination)->first(),
            Airport::where('code', $destination2)->first(),
            Airport::where('code', $destination3)->first(),
            Airport::where('code', $destination4)->first(),
        ];
        $adl = intval($adl);
        $chl = intval($chl);
        $inf = intval($inf);

        $calc_price = new SetPriceFunction();

        //		test for timing
        //$test_time1 = Carbon::now();
        //		test for timing

        $service_url = $this->base . '/Rest/Air/AirLowFareSearch';

        $array = [
            "RequestOption"                 => 2,
            "AdultCount"                    => $adl,
            "ChildCount"                    => $chl,
            "InfantCount"                   => $inf,
            "NearByAirports"                => false,
            "PricingSourceType"             => 0,
            "SessionId"                     => $this->session,
            "OriginDestinationInformations" => [
                [
                    "DepartureDateTime"       => $depart,
                    "DestinationLocationCode" => $destination,
                    "OriginLocationCode"      => $origin,
                ],
            ],
            "TravelPreference"              => [
                "CabinType"        => $class,
                "MaxStopsQuantity" => 0,
                "AirTripType"      => 1,
            ],

        ];

        $array["OriginDestinationInformations"][] = [
            "DepartureDateTime"       => "2023-08-08",
            "DestinationLocationCode" => "IKA",
            "OriginLocationCode"      => "PAR",
        ];

        $array["OriginDestinationInformations"][] = [
            "DepartureDateTime"       => $depart2,
            "DestinationLocationCode" => $destination2,
            "OriginLocationCode"      => $origin2,
        ];
        $array["TravelPreference"]["AirTripType"] = 4;

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
            $array["TravelPreference"]["MaxStopsQuantity"] = 2;
        }
        ini_set('memory_limit', '512M');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));

        $result = curl_exec($ch);
        $response = json_decode($result, true);
        curl_close($ch);

//		test for timing
        //$this->time2     = Carbon::now();
        //$this->diff_time = Carbon::now()->diffInSeconds( $test_time1 );
//		test for timing

//        $response = array_slice($response["PricedItineraries"], 0, \config('AdminVariable.flight_max_result'));
        $response = array_slice($response["PricedItineraries"], 0, 10);
        if (!$search_id) {
            $search = Search::create();
            $search_id = $search->id;
        }

        if (!empty($response)) {
            global $cost_insert, $tax_insert;

            $cost_insert = [];
            $tax_insert = [];
            $final_tax_insert = [];
            $leg_insert = [];
            $airline_insert = [];
            $final_airline_insert = [];
            $final_leg_insert = [];
            $i = 0;
            $leg_insert_equal = [];
            foreach ($response as $item) {
                $leg_insert_equal_text = "";
                $before_arrival = "";
                $different_airport_error = 0;
                $flights = [];
                $segment_counter = 0;
                $destination_check = $destination_airports[0];
                foreach ($item["OriginDestinationOptions"][0]["FlightSegments"] as $segment) {
                    $baggage_equal = $this->equal_bar($segment["Baggage"]);
                    $leg_insert_equal_text .= $segment["FlightNumber"] . $baggage_equal;
                    if ($before_arrival && $before_arrival != $segment["DepartureAirportLocationCode"]) {
                        $different_airport_error = 1;
                    }

                    $flights[$segment_counter][] = $segment;
                    if (($destination_check->is_city && $destination_check->childAirports()->where('code', $segment["ArrivalAirportLocationCode"])->first()) || $destination_check->code == $segment["ArrivalAirportLocationCode"]) {
                        $segment_counter++;
                        $destination_check = $destination_airports[$segment_counter] ?? "";
                    }

                    $before_arrival = $segment["ConnectionTimePerMinute"] ? $segment["ArrivalAirportLocationCode"] : "";
                }

                if ($different_airport_error) {
                    continue;
                }

                if (in_array($leg_insert_equal_text, $leg_insert_equal)) {
                    continue;
                }

                $leg_insert_equal[] = $leg_insert_equal_text;

                if ($item["ValidatingAirlineCode"] == "IR" && ($setting->flight_render == Setting::iranAir || ($setting->flight_render_ajax && in_array(Setting::iranAir, json_decode($setting->flight_render_ajax, true))))) {
                    continue;
                }
                if ($item["ValidatingAirlineCode"] == "W5") {
                    continue;
                }

                $multi_flight_id = null;
                foreach ($flights as $key => $flight_part) {
                    $help_var2 = sizeof($flight_part) - 1;

//                if (!$destination_airport->is_city && $item["OriginDestinationOptions"][0]["FlightSegments"][$help_var2]["ArrivalAirportLocationCode"] != $destination) {
//                    continue;
//                }


                    $depart_time = date("H", strtotime($flight_part[0]["DepartureDateTime"]));
                    $depart_time_min = date("i", strtotime($flight_part[0]["DepartureDateTime"]));
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

                    $JourneyDurationPerMinute = 0;
                    $ConnectionTimePerMinute = 0;
                    foreach ($flight_part as $flight_part_segment) {
                        $JourneyDurationPerMinute += $flight_part_segment["JourneyDurationPerMinute"];
                        $ConnectionTimePerMinute += $flight_part_segment["ConnectionTimePerMinute"];
                    }


                    $depart_return_time = $JourneyDurationPerMinute + $ConnectionTimePerMinute;

                    $inserted_flight = Flight::create([
                        "search_id"                    => $search_id,
                        "token"                        => 0,
                        "render"                       => $this->render_code,
                        "FareSourceCode"               => $item["FareSourceCode"],
                        "IsPassportMandatory"          => 1,
                        "IsPassportIssueDateMandatory" => boolval($item["IsPassportIssueDateMandatory"]),
                        "IsPassportNumberMandatory"    => 1,
                        "DirectionInd"                 => $item["DirectionInd"],
                        "RefundMethod"                 => $item["RefundMethod"],
                        "ValidatingAirlineCode"        => $flight_part[0]["MarketingAirlineCode"],
                        "flight_number"                => (substr($flight_part[0]["FlightNumber"], 0, 2) != $flight_part[0]["MarketingAirlineCode"] ? $flight_part[0]["MarketingAirlineCode"] : "") . $flight_part[0]["FlightNumber"],
                        "depart_time"                  => $flight_part[0]["DepartureDateTime"],
                        "depart_time_range"            => $depart_range,
                        "depart_airport"               => $flight_part[0]["DepartureAirportLocationCode"],
                        "arrival_time"                 => $flight_part[$help_var2]["ArrivalDateTime"],
                        "arrival_airport"              => $flight_part[$help_var2]["ArrivalAirportLocationCode"],
                        "stops"                        => $help_var2,
                        "total_time"                   => $JourneyDurationPerMinute,
                        "total_waiting"                => $ConnectionTimePerMinute,
                        "bar"                          => $this->baggage_filter($flight_part[0]["Baggage"]),
                        "bar_exist"                    => !$flight_part[0]["Baggage"] || substr($flight_part[0]["Baggage"], 0, 1) == 0 ? 0 : 1,
                        "class"                        => $flight_part[0]["CabinClassCode"],
                        "class_code"                   => $flight_part[0]["ResBookDesigCode"],
                        "depart_first_airline"         => $flight_part[0]["MarketingAirlineCode"],
                        "depart_return_time"           => $depart_return_time,
                        "multi_flight_id"              => $multi_flight_id ?? null,
                    ]);

                    if (!$multi_flight_id) {
                        $multi_flight_id = $inserted_flight->id;
                    }

                    $j = 0;
                    foreach ($flight_part as $segment) {

                        foreach ($airplanes as $airplane) {
                            if ($airplane->code == $segment["OperatingAirline"]["Equipment"]) {
                                $aircraft = $airplane;
                                break;
                            }
                        }
                        $inserted_flight->legs()->create([
                            "aircraft_type"             => isset($aircraft) ? $aircraft->manufacture . ' ' . $aircraft->code : $segment["OperatingAirline"]["Equipment"],
                            "aircraft_type_description" => isset($aircraft) ? $aircraft->description : $segment["OperatingAirline"]["Equipment"],
                            "seats_remaining"           => $segment["SeatsRemaining"],
                            "leg_flight_number"         => (substr($segment["FlightNumber"], 0, 2) != $segment["MarketingAirlineCode"] ? $segment["MarketingAirlineCode"] : "") . $segment["FlightNumber"],
                            "cabin_class"               => $segment["CabinClassCode"],
                            "cabin_class_code"          => $segment["ResBookDesigCode"],
                            "leg_depart_time"           => $segment["DepartureDateTime"],
                            "leg_depart_airport"        => $segment["DepartureAirportLocationCode"],
                            "leg_arrival_time"          => $segment["ArrivalDateTime"],
                            "leg_arrival_airport"       => $segment["ArrivalAirportLocationCode"],
                            "leg_time"                  => $segment["JourneyDurationPerMinute"],
                            "leg_waiting"               => $segment["ConnectionTimePerMinute"],
                            "leg_airline_code"          => $segment["MarketingAirlineCode"],
                            "is_charter"                => $segment["IsCharter"],
                            "is_return"                 => $segment["IsReturn"],
                            "leg_bar"                   => $this->baggage_filter($segment["Baggage"]),
                            "leg_bar_exist"             => !$segment["Baggage"] || substr($segment["Baggage"], 0, 1) == 0 ? 0 : 1,

                        ]);


                        $inserted_flight->airlines()->attach($segment["MarketingAirlineCode"], [
                            "is_return" => $segment["IsReturn"] ? 1 : 0,
                        ]);

                        $j++;
                    }


                    $cost_insert[$i]["flight_id"] = $inserted_flight->id;
                    $cost_insert[$i]["FareType"] = $item["AirItineraryPricingInfo"]["FareType"];
                    $cost_insert[$i]["VendorTotalFare"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["TotalFare"];
                    $cost_insert[$i]["TotalCommission"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["TotalCommission"];
                    $cost_insert[$i]["TotalTax"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["TotalTax"];
                    $cost_insert[$i]["ServiceTax"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["ServiceTax"];
                    $cost_insert[$i]["Currency"] = $item["AirItineraryPricingInfo"]["ItinTotalFare"]["Currency"];

                    $calc_price = $this->price_type($item, $calc_price, 0, $i, $inserted_flight->id);


                    if (isset($item["AirItineraryPricingInfo"]["PtcFareBreakdown"][1])) {

                        $calc_price = $this->price_type($item, $calc_price, 1, $i);

                        if (isset($item["AirItineraryPricingInfo"]["PtcFareBreakdown"][2])) {
                            $calc_price = $this->price_type($item, $calc_price, 2, $i);
                        }

                    }

                    $cost_insert[$i]["TotalFare"] = $calc_price->getTotal();
                    $cost_insert[$i]["TotalAgencyCommission"] = $calc_price->getTotalAgencyCommission();


                    $i++;
                }
            }
            if ($i > 0) {
                Cost::insert($cost_insert);
                Tax::insert($final_tax_insert);
            }

        }

        return $search_id;

    }


    public function revalidate($flight)
    {

        $code = $flight["FareSourceCode"];

        $service_url = $this->base . '/Rest/Air/AirRevalidate';

        $array = [
            "SessionId"      => $this->session,
            "FareSourceCode" => $code,
        ];

        if (isset($flight->costs)) {
            $total_fare = $flight->costs["VendorTotalFare"];
        } else {
            $total_fare = $flight["VendorTotalFare"];
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content - Type: application / json",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));

        $result = curl_exec($ch);
        $response = json_decode($result, true);
        curl_close($ch);

        if ($response["Success"]) {
            $response = $response["PricedItinerary"];

            if ($response["AirItineraryPricingInfo"]["ItinTotalFare"]["TotalFare"] == $total_fare) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }

    }


    public function book($flight, $payment)
    {

        $book = $payment->books;

        $book_unique_id = $book->UniqueId;
        $book_id = $book->id;
        $flight_id = $flight["id"];

        $client_unique_id = $book->user_id . chr(rand(65, 90)) . $book_id . chr(rand(65, 90)) . $flight["id"];

        $airbook_data = [
            "FareSourceCode" => $flight["FareSourceCode"],
            "ClientUniqueId" => $client_unique_id,
            "TravelerInfo"   => [
                "PhoneNumber"  => $book->dial_code . $book->phone,
                "Email"        => $book->users->email,
                "AirTravelers" => [],
            ],
        ];

        $i = 0;
        foreach ($book->passengers as $passenger) {

            $airbook_data["TravelerInfo"]["AirTravelers"][$i] = [
                "DateOfBirth"    => $passenger->birthday,
                "Gender"         => $passenger->gender,
                "PassengerType"  => $passenger->type,
                "PassengerName"  => [
                    "PassengerFirstName"  => $passenger->first_name,
                    "PassengerMiddleName" => $passenger->middle_name,
                    "PassengerLastName"   => $passenger->last_name,
                    "PassengerTitle"      => MyHelperFunction::turn_title_code2($passenger->gender, $passenger->type),
                ],
                "Passport"       => [
                    "Country"        => $passenger->country,
                    "ExpiryDate"     => $passenger->expiry_date ?? null,
                    "IssueDate"      => $passenger->issue_date ?? null,
                    "PassportNumber" => $passenger->passport_number ?? null,
                ],
                "NationalId"     => $passenger->national_id ?? null,
                "Nationality"    => $passenger->country,
                "SeatPreference" => 0,
                "MealPreference" => 0,
            ];

            $i++;
        }


        $return = [
            "book_unique_id" => $book_unique_id,
            "error"          => 0,
        ];

        if (!$book_unique_id) {


            $response = $this->airbook($airbook_data);

            if (!isset($response["Success"]) || !$response["Success"]) {
                //error handling

                $book->update([
                    "status" => "vendor_failed",
                ]);

                $this->log->api_error(json_encode($airbook_data), json_encode($response), "AirBook", $flight);

//show error message code
                if (env('APP_DEBUG')) {
                    echo "a";
                    dd($response);
                }
//end error
                $return["error"] = 1;

                return $return;

            }


            //save unique id from parto in database
            $book_unique_id = $response["UniqueId"];

//=============================== cancel booking after airbook for test
//            $can = $this->aircancel($book_unique_id);
//
//            $book->update([
//                "status" => "vendor_failed",
//            ]);
//
//            dd($can);
//===============================

            $return["book_unique_id"] = $book_unique_id;
            $book->update([
                "UniqueId" => $book_unique_id,
                "status"   => "wait_for_ticket",
            ]);
            Flight::where('id', '=', $flight_id)->update(["status" => "wait_for_ticket"]);

            $scheduler = Scheduler::create(["book_id" => $book_id]);
        }
        //if fare type is not webfare
        if ($flight["FareType"] != 4) {

            $booking_data = $this->airbookdata($book_unique_id);
            if (!isset($booking_data["Success"]) || !$booking_data["Success"]) {
                //error handling

                $book->update([
                    "status" => "vendor_failed",
                ]);

                $this->log->api_error(json_encode(["UniqueId" => $book_unique_id]), json_encode($booking_data), "AirBookingData", $flight);

                //show error message code
                if (env('APP_DEBUG')) {
                    echo "b";
                    dd($booking_data);
                }


                //end error

                $return["error"] = 1;

                return $return;

            }

            if (round($booking_data["TravelItinerary"]["ItineraryInfo"]["ItineraryPricing"]["TotalFare"]) == round($flight["VendorTotalFare"])) {
                //price check is ok , go call airorder

                $air_order = $this->airorder($book_unique_id);
                if (!isset($air_order["Success"]) || !$air_order["Success"]) {
                    //air order was unsuccess go call cancel order

                    $this->aircancel($book_unique_id);

                    $book->update([
                        "status" => "vendor_failed",
                    ]);

                    $this->log->api_error(json_encode(["UniqueId" => $book_unique_id]), json_encode($air_order), "AirOrderTicket", $flight);

                    //show error message code
                    if (env('APP_DEBUG')) {
                        echo "c";
                        dd($air_order);
                    }


                    //end error

                    $return["error"] = 1;

                    return $return;

                }


//					booking data after order issue
                //$new_booking_data = this->airbookdata( $book_unique_id );
//					if ( ! isset( $new_booking_data["Success"] ) || ! $new_booking_data["Success"] ) {
//						//error handling
//						dd( $new_booking_data );
//
//						return view( 'front.payment_result.single_validate_error', compact( 'research_data' ) );
//
//					}
                //$ticket_number=$new_booking_data["TravelItinerary"]["ItineraryInfo"]["CustomerInfoes"][0]["ETicketNumbers"]["ETicketNumber"];
//					//booking data after order issue


            } else {
                //price check is'nt ok , go call cancel order
                $this->aircancel($book_unique_id);

                $book->update([
                    "status" => "vendor_failed",
                ]);

                //show error message code
                if (env('APP_DEBUG')) {
                    dd("price not equal");
                }

                //end error

                $return["error"] = 1;

                return $return;

            }

        }

        return $return;

    }


    public function airbook($array)
    {


        $service_url = $this->base . '/Rest/Air/AirBook';

        $array["SessionId"] = $this->session;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content - Type: application / json",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));

        $result = curl_exec($ch);
        $response = json_decode($result, true);
        curl_close($ch);

        return $response;
    }


    public function update_booking_status($book, $book_unique_id)
    {
        $book_id = $book->id;
        $flight_id = $book->flight_id;

        $booking_data = $this->airbookdata($book_unique_id);
        if (isset($booking_data["Success"]) && $booking_data["Success"]) {

            if ($booking_data["Status"] == 21) {

                $ticket_number = $booking_data["TravelItinerary"]["ItineraryInfo"]["CustomerInfoes"][0]["ETicketNumbers"][0]["ETicketNumber"];

                $j = 0;
                foreach ($book->passengers as $passenger) {
                    $passenger->update([
                        "ticket_number" => $booking_data["TravelItinerary"]["ItineraryInfo"]["CustomerInfoes"][$j]["ETickets"],
                    ]);
                    $j++;
                }

                $airline_pnr = $booking_data["TravelItinerary"]["ItineraryInfo"]["ReservationItems"][0]["AirlinePnr"];


                //fare type was webfare or price was ok and airorder done successfully
                $book->update([
                    "status"      => "booked",
                    "airline_pnr" => $airline_pnr,
                ]);
                Flight::where('id', '=', $flight_id)->update(["status" => "booked"]);

                $booked = true;

            } elseif ($booking_data["Status"] < 21) {

                if (isset($booking_data["TravelItinerary"]["ItineraryInfo"]["ReservationItems"][0]["AirlinePnr"])) {
                    $airline_pnr = $booking_data["TravelItinerary"]["ItineraryInfo"]["ReservationItems"][0]["AirlinePnr"];
                } else {
                    $airline_pnr = "";
                }

                //fare type was webfare or price was ok and airorder done successfully
                $book->update([
                    "status"      => "wait_for_ticket",
                    "airline_pnr" => $airline_pnr,
                ]);
                Flight::where('id', '=', $flight_id)->update(["status" => "wait_for_ticket"]);

                $booked = false;

            } elseif ($booking_data["Status"] == 24 || $booking_data["Status"] == 30) {
                $book->update([
                    "status"      => "vendor_cancelled",
                    "airline_pnr" => "",
                ]);
                $booked = false;
            } else {
                $book->update([
                    "status"      => "vendor_failed",
                    "airline_pnr" => "",
                ]);
                $booked = false;
            }
        } else {
            $booked = false;
        }


        $returm = [
            "response" => $booking_data,
            "booked"   => $booked,
            "book"     => $book,
        ];

        return $returm;

    }

    public function airbookdata($book_unique_id)
    {

        $service_url = $this->base . '/Rest/Air/AirBookingData';

        $array = [
            "SessionId" => $this->session,
            "UniqueId"  => $book_unique_id,
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content - Type: application / json",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));

        $result = curl_exec($ch);
        $response = json_decode($result, true);
        curl_close($ch);

        return $response;

    }

    public function airorder($book_unique_id)
    {

        $service_url = $this->base . '/Rest/Air/AirOrderTicket';

        $array = [
            "SessionId" => $this->session,
            "UniqueId"  => $book_unique_id,
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content - Type: application / json",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));

        $result = curl_exec($ch);
        $response = json_decode($result, true);
        curl_close($ch);

        return $response;

    }

    public function aircancel($book_unique_id)
    {

        $service_url = $this->base . '/Rest/Air/AirCancel';

        $array = [
            "SessionId" => $this->session,
            "UniqueId"  => $book_unique_id,
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content - Type: application / json",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));

        $result = curl_exec($ch);
        $response = json_decode($result, true);
        curl_close($ch);

        return $response;

    }

    public function airrules($flight)
    {

        $faresourcecode = $flight["FareSourceCode"];
        $service_url = $this->base . '/Rest/Air/AirRules';

        $array["SessionId"] = $this->session;
        $array["FareSourceCode"] = $faresourcecode;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content - Type: application / json",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));

        $result = curl_exec($ch);
        $response = json_decode($result, true);
        curl_close($ch);

        return $response;

    }

    public function bag($flight)
    {


        $faresourcecode = $flight["FareSourceCode"];
        $service_url = $this->base . '/Rest/Air/AirBaggages';

        $array["SessionId"] = $this->session;
        $array["FareSourceCode"] = $faresourcecode;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $service_url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content - Type: application / json",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));

        $result = curl_exec($ch);
        $response = json_decode($result, true);
        curl_close($ch);

        return $response;

    }

    public function equal_bar($baggage)
    {
        $baggage = str_replace(' ', '', strtolower($baggage));
        $baggage = str_replace('pc', '', strtolower($baggage));
        $baggage = str_replace('n', '', strtolower($baggage));
        $baggage = str_replace('pieces', '', strtolower($baggage));
        $baggage = str_replace('piece', '', strtolower($baggage));
        $baggage = str_replace('kg', '', strtolower($baggage));
        $baggage = str_replace('k', '', strtolower($baggage));

        return $baggage;
    }

    public function baggage_filter($bar)
    {
        $bar = strtolower($bar);

        if (strpos($bar, "kg") || strpos($bar, "k")) {
            return $bar;
        }
        $bar = str_replace("n", "", $bar);
        $bar = str_replace("pc", "", $bar);
        $bar = str_replace("pieces", "", $bar);
        $bar = str_replace("piece", "", $bar);
        $bar = str_replace(" ", "", $bar);

        if (intval($bar) == 1) $bar = $bar . " " . trans('trs.suitcase');
        if (intval($bar) > 1) $bar = $bar . " " . trans('trs.suitcase_plural_format');
        return $bar;
    }

    public function price_type($item, $calc_price, $k, $i, $flight_id = 0)
    {
        global $cost_insert, $tax_insert;

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

        if ($item["AirItineraryPricingInfo"]["PtcFareBreakdown"][$k]["PassengerTypeQuantity"]["PassengerType"] == 1) {

            $cost_insert[$i]["FarePerAdult"] = $calc_price->index($item["AirItineraryPricingInfo"]["PtcFareBreakdown"][$k]["PassengerFare"]["TotalFare"], 0, $item["OriginDestinationOptions"][0]["FlightSegments"][0]["MarketingAirlineCode"], 'parto'); //total fare per adult
            $cost_insert[$i]["serviceAdult"] = $cost_insert[$i]["FarePerAdult"] - $item["AirItineraryPricingInfo"]["PtcFareBreakdown"][$k]["PassengerFare"]["TotalFare"] - $price_addition_adult; //service fee per adult
            $cost_insert[$i]["adult"] = $item["AirItineraryPricingInfo"]["PtcFareBreakdown"][$k]["PassengerTypeQuantity"]["Quantity"]; //number of adult
            $calc_price->setCount($cost_insert[$i]["adult"], 0);
            $cost_insert[$i]["taxAdult"] = $item["AirItineraryPricingInfo"]["PtcFareBreakdown"][$k]["PassengerFare"]["TotalFare"] - $item["AirItineraryPricingInfo"]["PtcFareBreakdown"][$k]["PassengerFare"]["BaseFare"];
            $cost_insert[$i]["AgencyCommissionAdult"] = $commission_adult;
            $tax_insert[$i][] = [
                "flight_id" => $flight_id,
                "type"      => 0,
                "name"      => "Tax",
                "code"      => "",
                "price"     => $cost_insert[$i]["taxAdult"],
            ];
        } elseif ($item["AirItineraryPricingInfo"]["PtcFareBreakdown"][$k]["PassengerTypeQuantity"]["PassengerType"] == 2) {
            $cost_insert[$i]["FarePerChild"] = $calc_price->index($item["AirItineraryPricingInfo"]["PtcFareBreakdown"][$k]["PassengerFare"]["TotalFare"], 1, $item["OriginDestinationOptions"][0]["FlightSegments"][0]["MarketingAirlineCode"], 'parto'); //per child
            $cost_insert[$i]["serviceChild"] = $cost_insert[$i]["FarePerChild"] - $item["AirItineraryPricingInfo"]["PtcFareBreakdown"][$k]["PassengerFare"]["TotalFare"] - $price_addition_child; //service fee per child
            $cost_insert[$i]["child"] = $item["AirItineraryPricingInfo"]["PtcFareBreakdown"][$k]["PassengerTypeQuantity"]["Quantity"]; //number of child
            $calc_price->setCount($cost_insert[$i]["child"], 1);
            $cost_insert[$i]["taxChild"] = $item["AirItineraryPricingInfo"]["PtcFareBreakdown"][$k]["PassengerFare"]["TotalFare"] - $item["AirItineraryPricingInfo"]["PtcFareBreakdown"][$k]["PassengerFare"]["BaseFare"];
            $cost_insert[$i]["AgencyCommissionChild"] = $commission_child;
            $tax_insert[$i][] = [
                "flight_id" => $flight_id,
                "type"      => 1,
                "name"      => "Tax",
                "code"      => "",
                "price"     => $cost_insert[$i]["taxChild"],
            ];

        } else {
            $cost_insert[$i]["FarePerInf"] = $calc_price->index($item["AirItineraryPricingInfo"]["PtcFareBreakdown"][$k]["PassengerFare"]["TotalFare"], 2, $item["OriginDestinationOptions"][0]["FlightSegments"][0]["MarketingAirlineCode"], 'parto'); //per inf
            $cost_insert[$i]["serviceInfant"] = $cost_insert[$i]["FarePerInf"] - $item["AirItineraryPricingInfo"]["PtcFareBreakdown"][$k]["PassengerFare"]["TotalFare"] - $price_addition_infant; //service fee per inf
            $cost_insert[$i]["infant"] = $item["AirItineraryPricingInfo"]["PtcFareBreakdown"][$k]["PassengerTypeQuantity"]["Quantity"]; //number of inf
            $calc_price->setCount($cost_insert[$i]["infant"], 2);
            $cost_insert[$i]["taxInfant"] = $item["AirItineraryPricingInfo"]["PtcFareBreakdown"][$k]["PassengerFare"]["TotalFare"] - $item["AirItineraryPricingInfo"]["PtcFareBreakdown"][$k]["PassengerFare"]["BaseFare"];
            $cost_insert[$i]["AgencyCommissionInfant"] = $commission_infant;
            $tax_insert[$i][] = [
                "flight_id" => $flight_id,
                "type"      => 2,
                "name"      => "Tax",
                "code"      => "",
                "price"     => $cost_insert[$i]["taxInfant"],
            ];
        }

        return $calc_price;
    }

    public function getCondition()
    {
        return Page::where('name', 'condition_parto')->first();
    }

}

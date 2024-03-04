<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Airline;
use App\Models\Ads_search;
use App\Models\Airport;
use App\Models\Cost;
use App\Models\Flight;
use App\Models\FlightAirline;
use App\Models\Leg;
use App\Models\Search;
use App\Models\Session;
use App\Models\Setting;
use App\Services\MyHelperFunction;
use App\Services\Renders\amadeus;
use App\Services\Renders\iranAir;
use App\Services\Renders\parto;
use App\Services\Renders\Render;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use SoapClient;
use Illuminate\Support\Facades\Auth;
use App\Jobs\ProcessFlight;


class FlightController extends Controller
{

    public $diff_time;
    public $time2;

    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function test_time($data)
    {

        header("Content-type: application/json; charset=utf-8");


        $filename = "log.php";

        $myfile = fopen($filename, "a");
        $date = Carbon::now();
        fwrite($myfile, $date . "<br>");
        fwrite($myfile, "parto waiting time : " . $data["parto"] . "<br>");
        fwrite($myfile, "site waiting time : " . $data['fly']);

        fwrite($myfile, "<br>" . "------------------------" . "<br><br>");

        fclose($myfile);

    }


    public function search_flight($search_id, $order, $filter = [], $start = 0, $length = 25, $select_flight_id = 0, $render = 0)
    {
        switch ($order) {
            case 1:
                $order1 = "ValidatingAirlineCode='ir' DESC , depart_return_time";
                $order2 = "costs.TotalFare";
                $order3 = "depart_time";
                $order4 = "total_time+total_waiting";
                $order5 = "return_total_time+return_total_waiting";
                break;
            case 2:
                $order1 = "ValidatingAirlineCode='ir' DESC , total_time+total_waiting";
                $order2 = "costs.TotalFare";
                $order3 = "depart_time";
                $order4 = "depart_return_time";
                $order5 = "return_total_time+return_total_waiting";
                break;
            case 3:
                $order1 = "ValidatingAirlineCode='ir' DESC , return_total_time+return_total_waiting";
                $order2 = "costs.TotalFare";
                $order3 = "depart_time";
                $order4 = "depart_return_time";
                $order5 = "total_time+total_waiting";
                break;
            default :
                $order1 = "ValidatingAirlineCode='ir' DESC , costs.TotalFare";
                $order2 = "depart_time";
                $order3 = "depart_return_time";
                $order4 = "total_time+total_waiting";
                $order5 = "return_total_time+return_total_waiting";
                break;
        }

        if (empty($filter)) {
            $filter = [['id', '>', 0]];
        }

        $main_filter = [];
        $filter_waiting = [];
        foreach ($filter as $item) {
            if ($item[0] == 'total_waiting' || $item[0] == 'return_total_waiting') {
                $filter_waiting[] = $item;
                continue;
            }
            $main_filter[] = $item;
        }


        if ($search_id != 0) {
            $flight = Flight::where('search_id', '=', $search_id)->where('multi_flight_id', null)->where(function ($q) use ($render) {
                if ($render) {
                    return $q->where('render', '=', $render);
                }
                return $q->where('render', '>', 0);
            })->where($main_filter)->where(function ($q) use ($filter_waiting) {
                if ($filter_waiting) {
                    return $q->where($filter_waiting)->orwhere(function ($q2) {
                        return $q2->where('total_waiting', 0)->where(function ($q3) {
                            return $q3->where('return_total_waiting', 0)->orwhere('return_total_waiting', null);
                        });
                    });
                }
                return $q;
            })->with('airlines', 'legs', 'legs.airlines', 'legs.airports1', 'legs.airports2', 'multi_flights', 'multi_flights.airlines', 'multi_flights.legs', 'multi_flights.legs.airlines', 'multi_flights.legs.airports1', 'multi_flights.legs.airports2')->join('costs', 'costs.flight_id', '=', 'flights.id')->orderByRaw("$order1 ASC , $order2 ASC , $order3 ASC , $order4 ASC , $order5 ASC
			")->get();

            $flight_grouped = Flight::select('stops', DB::raw('count(*) as total'))->where('search_id', '=', $search_id)->groupBy('stops')->orderBy('stops')->get();
            $return_flight_grouped = Flight::select('return_stops', DB::raw('count(*) as total'))->where('search_id', '=', $search_id)->groupBy('return_stops')->get();
            $max = Flight::where('search_id', '=', $search_id)->max('total_waiting');
            $max2 = Flight::where('search_id', '=', $search_id)->max('return_total_waiting');

            if ($max2 > $max) {
                $max = $max2;
            }
            $max = $max - ($max % 60) + 60;

            $count = $flight->count();

            if ($select_flight_id) {
                foreach ($flight as $key => $value) {

                    if ($value->id == $select_flight_id) {
                        $length = $key + 1;
                        break;
                    }
                }

                $h = intval($length / 25);
                $length = ($h + 1) * 25;

            }

            $flight = $flight->splice($start, $length);
            $response = [
                "count"                 => $count,
                "flight"                => $flight,
                "max"                   => $max,
                "flight_grouped"        => $flight_grouped,
                "return_flight_grouped" => $return_flight_grouped,
            ];

        } else {
            $response = [
                "count"                 => 0,
                "flight"                => [],
                "max"                   => 0,
                "flight_grouped"        => [],
                "return_flight_grouped" => [],
            ];
        }

        return $response;

    }

    public function index($origin, $destination, $depart, $return, $class, $adl, $chl, $inf, $none_stop = 0)
    {


        ini_set('max_execution_time', 120);
        set_time_limit(0);
        $actual_link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

        $setting = Setting::find(1);

        $lang = App::getLocale();

        $city_lang = "city_" . $lang;

        $origin_airport = Airport::where('code', '=', $origin)->first();
        $destination_airport = Airport::where('code', '=', $destination)->first();

        $filter = [
            "stops0" => $this->request->input('stops0') ?? 0,
            "stops1" => $this->request->input('stops1') ?? 0,
            "stops2" => $this->request->input('stops2') ?? 0,
            "bar0"   => $this->request->input('bar0') ?? 0,
            "bar1"   => $this->request->input('bar1') ?? 0,
            "wait0"  => $this->request->input('wait0') ?? 0,
            "wait1"  => $this->request->input('wait1') ?? 3000,
        ];


        $ajax_render = json_decode($setting->flight_render_ajax, true);

        if ($ajax_render) {
            $ajax_render = array_map('intval', $ajax_render);
//            $ajax_render = array_diff($ajax_render, [$render_number]);
        }

        if ($origin_airport->country == "ID" || $destination_airport->country == "ID") {
            return redirect()->back();
        }

        if ($destination_airport->country != "IR" && $ajax_render) {

            foreach ($ajax_render as $key => $value) {
                if ($value == Setting::iranAir) {
                    unset($ajax_render[$key]);
                }
            }
        }


        $search = Search::create();
        $search_id = $search->id;


//        if (!$response["count"] && $ajax_render) {
//            $render_number = $ajax_render[0];
//            unset($ajax_render[0]);
//            $instance_render = $this->set_render($render_number);
//            $search_id = $instance_render->lowfaresearch($origin, $destination, $depart, $return, $class, $adl, $chl, $inf, $none_stop, 0);
//            $response = $this->search_flight($search_id, 0);
//        }


        $next_day_link = route('flights', [
            'origin'      => $origin,
            'destination' => $destination,
            'class'       => $class,
            'adl'         => $adl,
            'chl'         => $chl,
            'inf'         => $inf,
            'depart'      => Carbon::createFromFormat("d.m.Y", $depart)->addDay()->format('d.m.Y'),
            'return'      => $return == "-" ? $return : Carbon::createFromFormat("d.m.Y", $return)->addDay()->format('d.m.Y'),
            'none_stop'   => $none_stop,
        ]);
        $prev_day_link = route('flights', [
            'origin'      => $origin,
            'destination' => $destination,
            'class'       => $class,
            'adl'         => $adl,
            'chl'         => $chl,
            'inf'         => $inf,
            'depart'      => Carbon::createFromFormat("d.m.Y", $depart)->subDay()->format('d.m.Y'),
            'return'      => $return == "-" ? $return : Carbon::createFromFormat("d.m.Y", $return)->subDay()->format('d.m.Y'),
            'none_stop'   => $none_stop,
        ]);

        if ($lang != "de") {
            $next_day_link .= "?lang=" . $lang;
            $prev_day_link .= "?lang=" . $lang;
        }

        $search_data = [
            "origin_code"           => $origin_airport->name . "-(" . $origin . ")",
            "origin_code_3chr"      => $origin,
            "origin_country"        => $origin_airport->country,
            "origin_city"           => $origin_airport->$city_lang ?: $origin_airport->city_en,
            "destination_code"      => $destination_airport->name . "-(" . $destination . ")",
            "destination_code_3chr" => $destination,
            "destination_country"   => $destination_airport->country,
            "destination_city"      => $destination_airport->$city_lang ?: $destination_airport->city_en,
            "depart"                => date('y-m-d', strtotime($depart)),
            "return"                => $return != "-" ? date('y-m-d', strtotime($return)) : "-",
            "class"                 => $class,
            "adl"                   => $adl,
            "chl"                   => $chl,
            "inf"                   => $inf,
            "none_stop"             => intval($none_stop),
            "search_id"             => $search_id,
            "render"                => "",
            "main_vendor"           => true,
            "next"                  => $next_day_link,
            "prev"                  => $prev_day_link,
        ];

        //		update search table
        Search::where('id', $search_id)->update([
            "link"             => $actual_link,
            "origin_code"      => $origin,
            "destination_code" => $destination,
            "origin_name"      => $search_data["origin_code"],
            "destination_name" => $search_data["destination_code"],
            "depart_date"      => $search_data["depart"],
            "return_date"      => $search_data["return"] != "-" ? $search_data["return"] : null,
            "class"            => MyHelperFunction::turn_class_to_code_database($search_data["class"]),
            "is_none_stop"     => $search_data["none_stop"],
            "adult"            => $adl,
            "child"            => $chl,
            "infant"           => $inf,
            "user_id"          => Auth::check() ? Auth::user()->id : null,
        ]);


        return response(view('front.flight.flightsvue', compact('lang', 'search_data', 'ajax_render', 'filter')));

    }

    public function reorder(Request $request)
    {

        $search_id = $request->search_id;
        $is_none_stop = $request->is_none_stop;

        $search = Search::find($search_id);

        $search_data = [
            'none_stop' => $is_none_stop,
            "render"    => 0,
            "search_id" => $search_id,
            "adl"       => $search->adult,
            "chl"       => $search->child,
            "inf"       => $search->infant,
        ];
        $lang = $request->lang;
        $order = $request->order;


        $response = $this->search_flight($search_id, $order);
        $flight = $response["flight"];
        $count = $response["count"];
        $returnHTML = view('front.flight.flights_list', compact('flight', 'lang', 'count', 'search_data'))->render();

        return response()->json(["html" => $returnHTML, "count" => $count]);


    }


    public function filter(Request $request)
    {


        $search_id = $request->search_id;
        $lang = $request->lang;
        $order = $request->order;
        $filter = $request->filter;
        $filter2 = $request->filter2;
        $start = $request->start;
        $length = $request->length;
        $is_none_stop = $request->is_none_stop;
        $render_number = $request->render;

        $search = Search::find($search_id);

        $search_data = [
            "none_stop" => $is_none_stop,
            "render"    => $render_number,
            "search_id" => $search_id,
            "adl"       => $search->adult,
            "chl"       => $search->child,
            "inf"       => $search->infant,
        ];

        $response = $this->search_flight($search_id, $order, $filter, $start, $length);
        $flight = $response["flight"];
        $count = $response["count"];

        if (!$count) {
            $response = $this->search_flight($search_id, $order, $filter2, $start, $length);
            $flight = $response["flight"];
            $count = $response["count"];
        }

        $returnHTML = view('front.flight.flights_list', compact('flight', 'lang', 'count', 'start', 'search_data'))->render();


        return response()->json(["html" => $returnHTML, "count" => $count]);

    }

    public function select_flight(Request $request)
    {

        $search_id = $request->search_id;
        $lang = $request->lang;
        $order = $request->order;
        $filter = [];
        $start = 0;
        $length = 0;
        $is_none_stop = $request->is_none_stop;
        $id = $request->id;

        $search = Search::find($search_id);

        $search_data = [
            'none_stop' => $is_none_stop,
            "render"    => 0,
            "search_id" => $search_id,
            "adl"       => $search->adult,
            "chl"       => $search->child,
            "inf"       => $search->infant,
        ];

        $response = $this->search_flight($search_id, $order, $filter, $start, $length, $id);
        $flight = $response["flight"];
        $count = $response["count"];

        $returnHTML = view('front.flight.flights_list', compact('flight', 'lang', 'count', 'start', 'search_data'))->render();

        return response()->json(["html" => $returnHTML, "count" => $count]);

    }


    public function air_rules(Request $request)
    {

        $id = $request->input('id');

        $flight = Flight::find($id);

//		choose render
        $render_number = $flight->render;
        $instance_render = $this->set_render($render_number);
//		choose render


        $response = $instance_render->airrules($flight);

        $rules = $response;

        if ($rules && isset($rules["Success"]) && isset($rules["FareRuleText"])) {

            if (isset($rules["FareRuleText"][0])) {
                $pos = strpos($rules["FareRuleText"][0]["Description"], "table") + 5;
                $description1 = substr_replace($rules["FareRuleText"][0]["Description"], ' class="table table-striped" ', $pos, 0);

                $pos = strpos($rules["FareRuleText"][1]["Description"], "table") + 5;
                $description2 = substr_replace($rules["FareRuleText"][1]["Description"], ' class="table table-striped" ', $pos, 0);
            } else {
                $pos = strpos($rules["FareRuleText"]["Description"], "table") + 5;
                $description1 = substr_replace($rules["FareRuleText"]["Description"], ' class="table table-striped" ', $pos, 0);
                $description2 = "";
            }

            $rules["FareRuleText"]["Description"] = [];

            $rules["FareRuleText"]["Description"][0] = $description1;
            $rules["FareRuleText"]["Description"][1] = $description2;
            $rules["FareRuleText"]["depart"][0] = $flight->depart_airport;
            $rules["FareRuleText"]["depart"][1] = $flight->arrival_airport;
            $rules["FareRuleText"]["return"][0] = $flight->return_depart_airport;
            $rules["FareRuleText"]["return"][1] = $flight->return_arrival_airport;
        }


        return response()->json(['status' => 0, 'rules' => $rules]);

    }

    public function bagRules(Request $request)
    {

        $id = $request->input('id');

        $flight = Flight::find($id);


//		choose render
        $render_number = $flight->render;
        $instance_render = $this->set_render($render_number);
//		choose render

        $response = $instance_render->bag($flight);


        $rules = $response;
        $final1 = "";
        $final2 = "";
        if ($rules && isset($rules["Success"]) && isset($rules["FareRuleText"])) {

            if (isset($rules["FareRuleText"][0])) {

                $description1 = $rules["FareRuleText"][0]["Description"];
                $description2 = $rules["FareRuleText"][1]["Description"];
            } else {
                $description1 = $rules["FareRuleText"]["Description"];
                $description2 = "";
            }

            $x = explode('<td>', $description1);
            foreach ($x as $item) {
                if (strpos($item, 'Kg')) {
                    $final1 = explode('</td>', $item)[0];
                    break;
                }
            }

            $x = explode('<td>', $description2);
            foreach ($x as $item) {
                if (strpos($item, 'Kg')) {
                    $final2 = explode('</td>', $item)[0];
                    break;
                }
            }
            $rules['iran_air'][0] = $final1;
            $rules['iran_air'][1] = $final2;

            $rules["FareRuleText"]["depart"][0] = $flight->depart_airport;
            $rules["FareRuleText"]["depart"][1] = $flight->arrival_airport;
            $rules["FareRuleText"]["return"][0] = $flight->return_depart_airport;
            $rules["FareRuleText"]["return"][1] = $flight->return_arrival_airport;

        }


        return response()->json(['status' => 0, 'rules' => $rules]);

    }


    public function ajax_flight(Request $request)
    {
        $render_number = intval($request->render);
        $search_id = $request->search_id;
        $lang = $request->lang;
        $filter = $request->filter;
//        $filter = json_decode($filter, true);
        $ajax_render = [$render_number];

        $search = Search::find($search_id);


        $origin = $search->origin_code;
        $destination = $search->destination_code;
        $depart = $search->depart_date;
        $return = $search->return_date;
        $class = MyHelperFunction::turn_class_en($search->class);
        $adl = $search->adult;
        $chl = $search->child;
        $inf = $search->infant;
        $none_stop = $search->is_none_stop;
        if (!$return) {
            $return = "-";
        }
//		choose render from database
        $instance_render = $this->set_render($render_number);
//		choose render from database

//        $search_id = $instance_render->lowfaresearch($origin, $destination, $depart, $return, $class, $adl, $chl, $inf, $none_stop, $search_id);
//        $search_id = 620;
//        $response = $this->search_flight($search_id, 0, [], 0, 500, 0, $render_number);

        $response = $instance_render->lowfaresearch($origin, $destination, $depart, $return, $class, $adl, $chl, $inf, $none_stop, $search_id);


//        $airlines_list = Airline::filter_airline_list($search_id);
//        $airlines_list = json_decode(json_encode($airlines_list), true);

//        $airlines_list = $this->sort_airline($airlines_list);


        $flights = $response["flights"];
        $count = count($flights);
        $search_data = [
            "none_stop" => $none_stop,
            "render"    => $render_number,
            "search_id" => $search_id,
            "adl"       => $adl,
            "chl"       => $chl,
            "inf"       => $inf,
        ];
        $max = 30;
//        $flight_grouped = $response["flight_grouped"];
//        $return_flight_grouped = $response["return_flight_grouped"];
//        $airlines = Airline::filter_airline($search_id);
//        $airlines = json_decode(json_encode($airlines), true);

        return response()->json([
            "status"               => 0,
            "flights"              => $flights,
            "time"                 => $response["time"],
            "count"                => $count,
            "search_data"          => $search_data,
            "max"                  => $max,
            "airlines_list"        => $response["airlines_list"],
            "flight_grouped"       => $response["flight_grouped"],
            "airlines_filter_list" => $response["airlines_filter_list"],
        ]);


    }

    public function ajax_flight_other_days(Request $request)
    {

        $render_number = $request->render;
        $search_id = $request->search_id;

        $search = Search::find($search_id);
        $origin = $search->origin_code;
        $destination = $search->destination_code;
        $class = $search->class;
        $adl = $search->adult;
        $chl = $search->child;
        $inf = $search->infant;
        $none_stop = $search->is_none_stop;

        $instance_render = $this->set_render($render_number);


        $flight_day = [2, 4];
        sort($flight_day);

        $today_depart = Carbon::create($search->depart_date);
        $now_day_depart = $today_depart->weekday();

        $today_return = Carbon::create($search->return_date);
        $now_day_return = $today_return->weekday();

        if ($now_day_depart < $flight_day[0]) {
            $f1 = $flight_day[0] - $now_day_depart;
            $f2 = $now_day_depart + 7 - $flight_day[1];
            $depart_day[0] = $today_depart->addDays($f1);
            $depart_day[1] = $today_depart->subDays($f2);
            dd($today_depart);
        } else if ($now_day_depart > $flight_day[0] && $now_day_depart < $flight_day[1]) {
            $f1 = $now_day_depart - $flight_day[0];
            $f2 = $flight_day[1] - $now_day_depart;
            $depart_day[0] = $today_depart->subDays($f1);
            $depart_day[1] = $today_depart->addDays($f2);
        } else if ($now_day_depart == $flight_day[0]) {
            $f1 = $now_day_depart + 7 - $flight_day[1];
            $f2 = $flight_day[1] - $now_day_depart;
            $depart_day[0] = $today_depart->subDays($f1);
            $depart_day[1] = $today_depart->addDays($f2);
        } else if ($now_day_depart == $flight_day[1]) {
            $f1 = $now_day_depart - $flight_day[0];
            $f2 = $flight_day[0] + 7 - $now_day_depart;
            $depart_day[0] = $today_depart->subDays($f1);
            $depart_day[1] = $today_depart->addDays($f2);
        } else {
            $f1 = $flight_day[0] + 7 - $now_day_depart;
            $f2 = $now_day_depart - $flight_day[1];
            $depart_day[0] = $today_depart->addDays($f1);
            $depart_day[1] = $today_depart->subDays($f2);
        }

        $flight_day_return = [1, 3];

        if ($now_day_return < $flight_day_return[0]) {
            $f1 = $flight_day_return[0] - $now_day_return;
            $f2 = $now_day_return + 7 - $flight_day_return[1];
            $return_day[0] = $today_return->addDays($f1);
            $return_day[1] = $today_return->subDays($f2);
        } else if ($now_day_return > $flight_day_return[0] && $now_day_return < $flight_day_return[1]) {
            $f1 = $now_day_return - $flight_day_return[0];
            $f2 = $flight_day_return[1] - $now_day_return;
            $return_day[0] = $today_return->subDays($f1);
            $return_day[1] = $today_return->addDays($f2);
        } else if ($now_day_return == $flight_day_return[0]) {
            $f1 = $now_day_return + 7 - $flight_day_return[1];
            $f2 = $flight_day_return[1] - $now_day_return;
            $return_day[0] = $today_return->subDays($f1);
            $return_day[1] = $today_return->addDays($f2);
        } else if ($now_day_return == $flight_day_return[1]) {
            $f1 = $now_day_return - $flight_day_return[0];
            $f2 = $flight_day_return[0] + 7 - $now_day_return;
            $return_day[0] = $today_return->subDays($f1);
            $return_day[1] = $today_return->addDays($f2);
        } else {
            $f1 = $flight_day_return[0] + 7 - $now_day_return;
            $f2 = $now_day_return - $flight_day_return[1];
            $return_day[0] = $today_return->addDays($f1);
            $return_day[1] = $today_return->subDays($f2);
        }

        $new_search_id = 0;

        dd($depart_day);
        foreach ($depart_day as $dep) {

            foreach ($return_day as $ret) {

                echo $dep;
                echo "    ";
                echo $ret;

                $depart = $dep;
                $return = $ret;

                $new_search_id = $instance_render->lowfaresearch($origin, $destination, $depart, $return, $class, $adl, $chl, $inf, $none_stop, $new_search_id);

            }

        }

        $flights = Flight::where('search_id', $new_search_id)->get();
        $response = [];
        foreach ($flights as $flight) {

            $response[] = [
                "depart" => $flight->depart_time,
                "return" => $flight->return_depart_time,
                "price"  => $flight->costs->TotalFare,
            ];
        }

        dd($response);

        return $response;

    }

    public function sort_airline($airlines_list)
    {

        $i = -1;
        $last_id = 0;
        $grouped_airline_list = [];
        foreach ($airlines_list as $item) {

            if ($item["id"] != $last_id) {

                if (isset($grouped_airline_list[$i])) {
                    usort($grouped_airline_list[$i], function ($item1, $item2) {
                        return $item1["stops"] <=> $item2["stops"];
                    });
                }
                $i++;
            }

            $grouped_airline_list[$i][] = $item;

            if ($item["id"] == $last_id) {
                usort($grouped_airline_list[$i], function ($item1, $item2) {
                    return $item1["stops"] <=> $item2["stops"];
                });
            }
            $last_id = $item["id"];
        }

        usort($grouped_airline_list, function ($item1, $item2) {
            if ($item2[0]["TotalFare"] == $item1[0]["TotalFare"]) {
                if (isset($item1[1]) && isset($item2[1])) {
                    return $item1[1]['TotalFare'] <=> $item2[1]['TotalFare'];
                }
            }

            return $item1[0]['TotalFare'] <=> $item2[0]['TotalFare'];

        });

        return $grouped_airline_list;

    }


    public function iframe_result()
    {

        ini_set('max_execution_time', 0);
        set_time_limit(0);
//        $parsed = parse_url($_SERVER['HTTP_REFERER']);
//        $domain = $parsed['host'];
//
//        if ($domain != "parsian.eu") return 0;

        Ads_search::where('id', '>', 0)->delete();

        $data = Config::get("iran_air_flight");


        foreach ($data as $row) {
            $airport = $row["airport"];

            for ($i = 0; $i < 5; $i++) {
                $search_id = 0;

                foreach ($row["depart"] as $row2) {


                    $depart = $this->get_date($row2);

                    $depart_days_counter = 0;
                    if ($depart->month != Carbon::now()->month) {
                        $depart->subDays(7);
                        $depart_days_counter = 1;
                    }

                    $last_month = $depart->month + $i;
                    if ($last_month > 12) {
                        $last_month -= 12;
                    }
                    $counter = 0;
                    while ($depart->month != $last_month) {
                        $depart->addDays(7);
                        if (!$depart_days_counter) {
                            $counter++;
                        }
                        $depart_days_counter = 0;

                    }

                    $month = $depart->month;

                    $j = 0;
                    while (true) {
                        if ($j > 0) $depart->addDays(7);
                        if ($depart->month != $month) break;
                        foreach ($row["return"] as $row3) {
                            $return = $this->get_date($row3)->addDays($counter * 7 + $j * 7 + 14);
                            if ($depart >= Carbon::now()) {
                                ProcessFlight::dispatch($airport, $depart, $return)->onQueue('search');
                            }
                        }
                        $j++;
                    }
                }
            }
        }
    }

    public function get_date($day)
    {

        $day_now = Carbon::now()->weekday();
        $diff = $day - $day_now;

        if ($diff > 0) $date = Carbon::now()->addDays($diff);
        elseif ($diff < 0) $date = Carbon::now()->addDays(7 + $diff);
        else $date = Carbon::now();
        return $date;

    }

    public function ads_iframe()
    {
        $now = Carbon::now();

        $ads = Ads_search::where('depart', '>=', $now)->orderBy('id')->get();
        $data = [];
        $first_month = 0;
        foreach ($ads as $row) {

            if (!$first_month) {
                $first_month = $row->month;
            }

            if ($row->month < $first_month && $first_month < $row->month + 6) $first_month = $row->month;

            $city = $row->airport->city_de ?: $row->airport->city_en;
            $data[$city][] = $row;
        }


        $month = [];
        for ($i = $first_month; $i <= $first_month + 4; $i++) {
            $month[] = $this->get_month($i);
        }
        return view('front.iframe.flights', compact('data', 'month', 'first_month'));


    }

    public function get_month($number)
    {
        if ($number > 12) $number -= 12;
        switch ($number) {
            case 1:
                $month = "Januar";
                break;
            case 2:
                $month = "Februar";
                break;
            case 3:
                $month = "März";
                break;
            case 4:
                $month = "April";
                break;
            case 5:
                $month = "Mai";
                break;
            case 6:
                $month = "Juni";
                break;
            case 7:
                $month = "Juli";
                break;
            case 8:
                $month = "August";
                break;
            case 9:
                $month = "September";
                break;
            case 10:
                $month = "Oktober";
                break;
            case 11:
                $month = "November";
                break;
            case 12:
                $month = "Dezember";
                break;
        }

        return $month;
    }

    public function multi(Request $request, $origin1, $destination1, $depart1, $origin2, $destination2, $depart2, $class, $adl, $chl, $inf, $none_stop, $origin3 = null, $destination3 = null, $depart3 = null, $origin4 = null, $destination4 = null, $depart4 = null)
    {
        $actual_link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

        $setting = Setting::find(1);

        $lang = App::getLocale();

        $city_lang = "city_" . $lang;

        $origin_airport1 = Airport::where('code', '=', $origin1)->first();
        $destination_airport1 = Airport::where('code', '=', $destination1)->first();

        $origin_airport2 = Airport::where('code', '=', $origin2)->first();
        $destination_airport2 = Airport::where('code', '=', $destination2)->first();

        $origin_airport3 = Airport::where('code', '=', $origin3)->first();
        $destination_airport3 = Airport::where('code', '=', $destination3)->first();

        $origin_airport4 = Airport::where('code', '=', $origin4)->first();
        $destination_airport4 = Airport::where('code', '=', $destination4)->first();

        $filter = [
            "stops0" => $this->request->input('stops0') ?? 0,
            "stops1" => $this->request->input('stops1') ?? 0,
            "stops2" => $this->request->input('stops2') ?? 0,
            "bar0"   => $this->request->input('bar0') ?? 0,
            "bar1"   => $this->request->input('bar1') ?? 0,
            "wait0"  => $this->request->input('wait0') ?? 0,
            "wait1"  => $this->request->input('wait1') ?? 3000,
        ];

        $render_number = 0;

        $ajax_render = json_decode($setting->flight_render_ajax, true);

        if ($ajax_render) {
            $ajax_render = array_map('intval', $ajax_render);
        }

        if ((($origin_airport1->country != "IR" && $destination_airport1->country != "IR")
                || (($origin_airport2->country != "IR" && $destination_airport2->country != "IR"))
                || (($origin_airport3 && $origin_airport3->country != "IR" && $destination_airport3->country != "IR"))
                || (($origin_airport4 && $origin_airport4->country != "IR" && $destination_airport4->country != "IR")))
            && $ajax_render) {

            foreach ($ajax_render as $key => $value) {
                if ($value == Setting::iranAir) {
                    unset($ajax_render[$key]);
                }
            }
        }

        $search = Search::create();
        $search_id = $search->id;
        $other_days_loader = $setting->other_days;


        $next_day_link = route('multi', [
            'origin1'      => $origin1,
            'destination1' => $destination1,
            'depart1'      => Carbon::createFromFormat("d.m.Y", $depart1)->addDay()->format('d.m.Y'),
            'origin2'      => $origin2,
            'destination2' => $destination2,
            'depart2'      => Carbon::createFromFormat("d.m.Y", $depart2)->addDay()->format('d.m.Y'),
            'class'        => $class,
            'adl'          => $adl,
            'chl'          => $chl,
            'inf'          => $inf,
            'none_stop'    => $none_stop,
            'origin3'      => $origin3 ?: "",
            'destination3' => $destination3 ?: "",
            'depart3'      => $depart3 ? Carbon::createFromFormat("d.m.Y", $depart3)->addDay()->format('d.m.Y') : "",
            'origin4'      => $origin4 ?: "",
            'destination4' => $destination4 ?: "",
            'depart4'      => $depart4 ? Carbon::createFromFormat("d.m.Y", $depart4)->addDay()->format('d.m.Y') : "",
        ]);
        $prev_day_link = route('multi', [
            'origin1'      => $origin1,
            'destination1' => $destination1,
            'depart1'      => Carbon::createFromFormat("d.m.Y", $depart1)->addDay()->format('d.m.Y'),
            'origin2'      => $origin2,
            'destination2' => $destination2,
            'depart2'      => Carbon::createFromFormat("d.m.Y", $depart2)->addDay()->format('d.m.Y'),
            'class'        => $class,
            'adl'          => $adl,
            'chl'          => $chl,
            'inf'          => $inf,
            'none_stop'    => $none_stop,
            'origin3'      => $origin3 ?: "",
            'destination3' => $destination3 ?: "",
            'depart3'      => $depart3 ? Carbon::createFromFormat("d.m.Y", $depart3)->subDay()->format('d.m.Y') : "",
            'origin4'      => $origin4 ?: "",
            'destination4' => $destination4 ?: "",
            'depart4'      => $depart4 ? Carbon::createFromFormat("d.m.Y", $depart4)->subDay()->format('d.m.Y') : "",
        ]);
        if ($lang != "de") {
            $next_day_link .= "?lang=" . $lang;
            $prev_day_link .= "?lang=" . $lang;
        }

        $search_data = [
            "class"       => $class,
            "adl"         => $adl,
            "chl"         => $chl,
            "inf"         => $inf,
            "none_stop"   => intval($none_stop),
            "search_id"   => $search_id,
            "render"      => $render_number,
            "main_vendor" => true,
            "next"        => $next_day_link,
            "prev"        => $prev_day_link,
            "multi"       => true,
        ];

        $search_json = json_encode([
            "origin1_code"      => $origin1,
            "destination1_code" => $destination1,
            "depart1_date"      => date('Y-m-d', strtotime($depart1)),
            "origin2_code"      => $origin2,
            "destination2_code" => $destination2,
            "depart2_date"      => date('Y-m-d', strtotime($depart2)),
            "origin3_code"      => $origin3,
            "destination3_code" => $destination3,
            "depart3_date"      => date('Y-m-d', strtotime($depart3)),
            "origin4_code"      => $origin4,
            "destination4_code" => $destination4,
            "depart4_date"      => date('Y-m-d', strtotime($depart4)),
        ]);

        //		update search table
        $search->update([
            "link"         => $actual_link,
            "class"        => MyHelperFunction::turn_class_to_code_database($search_data["class"]),
            "is_none_stop" => $search_data["none_stop"],
            "adult"        => $adl,
            "child"        => $chl,
            "infant"       => $inf,
            "user_id"      => Auth::check() ? Auth::user()->id : null,
            "multi"        => $search_json,
        ]);


        return response(view('front.flight.flightsvue', compact('lang', 'search_data', 'ajax_render', 'filter')));


    }

    public function ajax_flight_multi(Request $request)
    {
        $render_number = intval($request->render);
        $search_id = $request->search_id;
        $lang = $request->lang;
        $ajax_render = [$render_number];

        $search = Search::find($search_id);
        $search_multi = json_decode($search->multi);
        $origin1 = $search_multi->origin1_code;
        $destination1 = $search_multi->destination1_code;
        $depart1 = $search_multi->depart1_date;
        $origin2 = $search_multi->origin2_code;
        $destination2 = $search_multi->destination2_code;
        $depart2 = $search_multi->depart2_date;
        $origin3 = $search_multi->origin3_code;
        $destination3 = $search_multi->destination3_code;
        $depart3 = $search_multi->depart3_date;
        $origin4 = $search_multi->origin4_code;
        $destination4 = $search_multi->destination4_code;
        $depart4 = $search_multi->depart4_date;

        $class = MyHelperFunction::turn_class_en($search->class);
        $adl = $search->adult;
        $chl = $search->child;
        $inf = $search->infant;
        $none_stop = $search->is_none_stop;


//		choose render from database
        $instance_render = $this->set_render($render_number);

//		choose render from database

        $search_id = $instance_render->lowfaresearchMulti($origin1, $destination1, $depart1, $origin2, $destination2, $depart2, $class, $adl, $chl, $inf, $none_stop, $search_id, $origin3, $destination3, $depart3, $origin4, $destination4, $depart4);

//        $search_id = 536;

        $response = $this->search_flight($search_id, 0, [], 0, 500, 0, $render_number);

        $airlines_list = Airline::filter_airline_list($search_id);
        $airlines_list = json_decode(json_encode($airlines_list), true);

        $airlines_list = $this->sort_airline($airlines_list);


        $flight = $response["flight"];
        $count = $response["count"];
        $search_data = [
            "none_stop" => $none_stop,
            "render"    => $render_number,
            "search_id" => $search_id,
            "adl"       => $adl,
            "chl"       => $chl,
            "inf"       => $inf,
        ];
        $max = $response["max"];
        $flight_grouped = $response["flight_grouped"];
        $return_flight_grouped = $response["return_flight_grouped"];
        $airlines = Airline::filter_airline($search_id);
        $airlines = json_decode(json_encode($airlines), true);

        return response()->json([
            "status"         => 0,
            "flights"        => $flight,
            "count"          => $count,
            "search_data"    => $search_data,
            "max"            => $max,
            "airlines_list"  => $airlines_list,
            "flight_grouped" => $flight_grouped,
            "airlines"       => $airlines,
        ]);


    }

}

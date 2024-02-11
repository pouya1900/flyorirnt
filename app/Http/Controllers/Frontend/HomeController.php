<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Airline;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\Book;
use App\Models\Post;
use ClassPreloader\Config;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index()
    {
        $lang = App::getLocale();

//		$ir_airport=\Illuminate\Support\Facades\Config::get("ir_air");

        $airlines = Airline::slide_airline();

        $cip = \Illuminate\Support\Facades\Config::get("cip");
        $cip_airports = $cip["airports"];

        $posts = Post::where('home_page', '=', 1)->limit(4)->get();
        $posts = json_decode(json_encode($posts), true);

        return view('front.home.index', compact('airlines', 'cip_airports', 'lang', 'posts'));


    }

    public function auto_complete(Request $request)
    {

        $data = $request->data;
        $sec = $request->sec;
        $lang = $request->lang;


        $airports = Airport::airport_search($data);


        return view('front.home.search_result', compact('airports', 'sec', 'lang'));
    }

    public function search(Request $request)
    {
        $lang = App::getLocale();


        $data = [
            'class' => $request->input('flight_class'),
            'adl'   => $request->input('adl'),
            'chl'   => $request->input('chl'),
            'inf'   => $request->input('inf'),
        ];

        if ($request->input('origin')) {
            $origin = $request->input('origin');
            $destination = $request->input('destination');

            $x = strripos($origin, '(');
            $x++;
            $origin_code = substr($origin, $x, 3);
            $x = strripos($destination, '(');
            $x++;
            $destination_code = substr($destination, $x, 3);

            $data["origin"] = $origin_code;
            $data["destination"] = $destination_code;

        } else {
            $origin1 = $request->input('origin1');
            $destination1 = $request->input('destination1');
            $origin2 = $request->input('origin2');
            $destination2 = $request->input('destination2');

            $x = strripos($origin1, '(');
            $x++;
            $origin_code = substr($origin1, $x, 3);
            $x = strripos($destination1, '(');
            $x++;
            $destination_code = substr($destination1, $x, 3);


            $data["origin1"] = $origin_code;
            $data["destination1"] = $destination_code;

            $x = strripos($origin2, '(');
            $x++;
            $origin_code = substr($origin2, $x, 3);
            $x = strripos($destination2, '(');
            $x++;
            $destination_code = substr($destination2, $x, 3);

            $data["origin2"] = $origin_code;
            $data["destination2"] = $destination_code;

            $date1 = $request->input("date1");
            $date2 = $request->input("date2");

            $data["depart1"] = $date1;
            $data["depart2"] = $date2;

            if ($request->input("origin3")) {
                $origin3 = $request->input('origin3');
                $destination3 = $request->input('destination3');

                $x = strripos($origin3, '(');
                $x++;
                $origin_code = substr($origin3, $x, 3);
                $x = strripos($destination3, '(');
                $x++;
                $destination_code = substr($destination3, $x, 3);

                $data["origin3"] = $origin_code;
                $data["destination3"] = $destination_code;
                $date3 = $request->input("date3");
                $data["depart3"] = $date3;
            }
            if ($request->input("origin4")) {
                $origin4 = $request->input('origin4');
                $destination4 = $request->input('destination4');

                $x = strripos($origin4, '(');
                $x++;
                $origin_code = substr($origin4, $x, 3);
                $x = strripos($destination4, '(');
                $x++;
                $destination_code = substr($destination4, $x, 3);

                $data["origin4"] = $origin_code;
                $data["destination4"] = $destination_code;

                $date4 = $request->input("date4");
                $data["depart4"] = $date4;
            }

        }

        if ($request->input('daterange_d')) {

            $data['depart'] = $request->input('daterange_d');
            $data['return'] = $request->input('daterange_r');
        } else if ($request->input('date')) {
            $data['depart'] = $request->input('date');
            $data['return'] = "-";
        }
        $data['none_stop'] = 0;
        if ($request->input('stop_q') && $request->input('stop_q') == 'on') {
            $data['none_stop'] = 1;
        }


        if ($lang != "de") {
            $data["lang"] = $lang;
        }

        if (!$request->input('stops0')) {
            $data['stops0'] = 1;
        }
        if (!$request->input('stops1')) {
            $data['stops1'] = 1;
        }
        if (!$request->input('stops2')) {
            $data['stops2'] = 1;
        }
        if (!$request->input('bar0')) {
            $data['bar0'] = 1;
        }
        if (!$request->input('bar1')) {
            $data['bar1'] = 1;
        }

        $data['wait0'] = intval($request->input('wait0'));
        $data['wait1'] = intval($request->input('wait1'));


        if ($request->input("search_type") == "M") {
            $link = route('multi', $data);
        } else {
            $link = route('flights', $data);
        }

        return redirect($link);

    }

}


<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\Setting;
use App\Models\Session;
use App\Models\Payment_scheduler;
use App\Models\Ads_search;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{

    public function index()
    {

        $lang = App::getLocale();

        $payment_schedulers = Payment_scheduler::where("status", "stopped")->get();

        return view('admin.home.index', compact('lang', 'payment_schedulers'));

    }

    public function tickets()
    {
        $books = Book::where("status", "!=", "booking")->orderBy('updated_at', 'desc')->get();
        return view('admin.ticket.index', compact('books'));
    }

    public function booked_tickets()
    {
        $books = Book::where("status", "=", "booked")->orderBy('updated_at', 'desc')->get();
        return view('admin.ticket.index', compact('books'));
    }

    public function bookings()
    {
        $books = Book::where("status", "=", "booking")->orderBy('updated_at', 'desc')->get();
        return view('admin.ticket.index', compact('books'));
    }

    public function search_user_result($id)
    {

        $lang = App::getLocale();


        $user = User::with([
            'books.flights'          => function ($query) {
                $query->join('costs', 'costs.flight_id', '=', 'flights.id');
            },
            'countries',
            'books.flights.legs.airports1',
            'books.flights.legs.airports2',
            'books.flights.legs.airlines',
            'books.flights.airports1',
            'books.flights.airports2',
            'books.flights.airports3',
            'books.flights.airports4',
            'books.flights.taxes',
            'books.flights.airlines' => function ($query) {
                $query->distinct();
            },
        ])->where('id', $id)->first();

        $user = json_decode(json_encode($user), true);

//		$books=$user["books"];
//		$i=0;
//		foreach ($books as $book){
//			$flights[$i]=$book["flights"];
//			$i++;
//		}


        return view('admin.ticket.search_user_result', compact('user', 'lang'));

    }


    public function search_ticket_result($id)
    {

        $lang = App::getLocale();

        $book = Book::find($id);

        if ($book) {
            $user_id = $book->user_id;

            $user = User::with([
                'books'                  => function ($query) use ($id) {
                    $query->where('id', $id);
                },
                'books.flights'          => function ($query) {
                    $query->join('costs', 'costs.flight_id', '=', 'flights.id');
                },
                'countries',
                'books.flights.legs.airports1',
                'books.flights.legs.airports2',
                'books.flights.legs.airlines',
                'books.flights.airports1',
                'books.flights.airports2',
                'books.flights.airports3',
                'books.flights.airports4',
                'books.flights.taxes',
                'books.flights.airlines' => function ($query) {
                    $query->distinct();
                },
            ])->where('id', $user_id)->first();

            $user = json_decode(json_encode($user), true);


            return view('admin.ticket.search_user_result', compact('user', 'lang'));
        }

    }


    public function general_setting()
    {

        $lang = App::getLocale();

        $setting = Setting::find(1);

        $ads_searches = Ads_search::all();

        return view('admin.setting.general_setting', compact('setting', 'lang', 'ads_searches'));

    }

    public function update_setting1(Request $request)
    {

        $site_title = $request->input('site_title');

        $setting = Setting::find(1);

        $setting->update(['site_title' => $site_title]);

        return redirect()->route('admin.general_setting')->with('message', 'Changes made successfully');

    }

    public function update_setting2(Request $request)
    {

        $setting = Setting::find(1);

        if ($request->hasFile('logo')) {

            $request->logo->storeAs('images/settings', 'logo.png', 'upload');
            $setting->update(['logo' => 'settings/logo.png']);
        }

        if ($request->hasFile('favicon')) {

            $request->favicon->storeAs('images/settings', 'favicon.png', 'upload');
            $setting->update(['favicon' => 'settings/favicon.png']);
        }

        if ($request->hasFile('search_loader_background')) {

            $request->search_loader_background->storeAs('images/BackGround', 's_l_b.jpg', 'upload');
            $setting->update(['search_loader_img' => 'BackGround/s_l_b.jpg']);
        }

        $update = [];
        if ($request->has('email')) {
            $update["email"] = $request->input('email');
        }
        if ($request->has('phone')) {
            $update["phone"] = $request->input('phone');
        }
        if ($request->has('fax')) {
            $update["fax"] = $request->input('fax');
        } else {
            $update["fax"] = "";
        }
        if ($request->has('whatsapp')) {
            $update["whatsapp"] = $request->input('whatsapp');
        } else {
            $update["whatsapp"] = "";
        }
        if ($request->has('admin_name')) {
            $update["admin_name"] = $request->input('admin_name');
        }
        if ($request->has('address')) {
            $update["address"] = $request->input('address');
        }
        if ($request->has('logo_position_search_loader')) {
            $update["logo_position_search_loader"] = $request->input('logo_position_search_loader');
        }

        $setting->update($update);

        return redirect()->route('admin.general_setting')->with('message', 'Changes made successfully');


    }

    public function update_setting3(Request $request)
    {

        $render = $request->input('render');
        $ajax_render = $request->input('ajax_render');
        $other_days = $request->has('other_days');


        if ($ajax_render) {
            $ajax_render_json = json_encode($ajax_render);
        } else {
            $ajax_render_json = "";
        }

        $setting = Setting::find(1);

        $setting->update([
            'flight_render'      => $render,
            'flight_render_ajax' => $ajax_render_json,
            'other_days'         => $other_days,
        ]);

//				Session::where('created_at','>','0')->delete();


        return redirect()->route('admin.general_setting')->with('message', 'Changes made successfully');

    }

    public function update_setting4(Request $request)
    {


        $setting = Setting::find(1);

        $payment = 0;
        if ($request->has("payment")) $payment = 1;

        $pure_price = 0;
        if ($request->has("pure_price")) $pure_price = 1;

        $test_one_euro = 0;
        if ($request->has("test_one_euro")) $test_one_euro = 1;

        $test_one_euro_with_book = 0;
        if ($request->has("test_one_euro_with_book")) $test_one_euro_with_book = 1;

        $setting->update([
            'payment'                 => $payment,
            'pure_price'              => $pure_price,
            'test_one_euro'           => $test_one_euro,
            'test_one_euro_with_book' => $test_one_euro_with_book,
        ]);

        return redirect()->route('admin.general_setting')->with('message', 'Changes made successfully');

    }

    public function update_setting5(Request $request)
    {
        $setting = Setting::find(1);

        $cip_active = 0;

        if ($request->has('cip_on_off')) $cip_active = 1;

        $cip_max_time_day = null;
        if ($request->has('cip_max_time_day_active')) {
            $cip_max_time_day = $request->input('cip_max_time_day');
        }

        $setting->update([
            'cip_max_time'     => date('Y-m-d', strtotime($request->cip_max_time)),
            'cip_active'       => $cip_active,
            'cip_max_time_day' => $cip_max_time_day,
        ]);

        return redirect()->route('admin.general_setting')->with('message', 'Changes made successfully');
    }


    public function update_setting6(Request $request)
    {

        Ads_search::where('id', '>', 0)->delete();

        foreach ($request->depart as $key => $value) {

            Ads_search::create([
                "origin"      => $request->origin_code[$key],
                "destination" => $request->destination_code[$key],
                "depart"      => date('y-m-d', strtotime($request->depart[$key])),
                "return"      => date('y-m-d', strtotime($request->return[$key])),
            ]);

        }
        return redirect()->route('admin.general_setting')->with('message', 'Changes made successfully');
    }


}

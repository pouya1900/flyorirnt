<?php

namespace App\Http\Controllers\Frontend;

use App\Mail\cip_ticket;
use App\Mail\cip_ticket_sup;
use App\Mail\cip_ticket_vendor;
use App\Mail\ticket;
use App\Mail\ticket_sup;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\Book;
use App\Models\Cip_book;
use App\Models\Cip_passenger;
use App\Models\Cip_payment;
use App\Models\Cip_service;
use App\Models\Country;
use App\Models\Flight;
use App\Models\Page;
use App\Models\Passenger;
use App\Models\Payment;
use App\Models\Setting;
use App\Services\Payments\paypal;
use App\Services\Renders\parto;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class CIPController extends Controller
{


    public function cip_iran()
    {

        $lang = App::getLocale();

        $text_lang = "text_" . $lang;

        $setting = Setting::find(1);

        $cip = \Illuminate\Support\Facades\Config::get("cip");
        $cip_airports = $cip["airports"];

        $cip_page = Page::where('name', "cip")->first();

        $text = $cip_page->$text_lang;

        $cip_max_time = $setting->cip_max_time;
        $cip_max_time_day = $setting->cip_max_time_day;

        return view('front.cip_home.cip_iran', compact('lang', 'cip_airports', 'text', 'cip_max_time', 'cip_max_time_day'));

    }

    public function search(Request $request)
    {

        $lang = App::getLocale();


        $dir = request()->input('cip_dir');
        $airport = request()->input('cip_airport');

        $x = strripos($airport, '(');
        $x++;
        $airport_code = substr($airport, $x, 3);

        $x = strripos($request->airline, '(');
        $x++;
        $cip_airline_code = substr($request->airline, $x, 2);

        $airline = Airline::where('code', $cip_airline_code)->first();

        if (!$airline->cip_iran_support) {
            return redirect()->back()->withErrors(["errors" => trans('trs.airline_cip_not_available')]);
        }

        $data = [
            'dir'     => $dir,
            'airport' => $airport_code,
            'date'    => request()->input('cip_date'),
            'adl'     => request()->input('adl'),
            'chl'     => request()->input('chl'),
            'inf'     => request()->input('inf'),
            'type'    => request()->input('cip_type'),
            'airline' => $cip_airline_code,
        ];


        $link = route('CIPs', $data);
        if ($lang != "de") {
            $link .= "?lang=" . $lang;
        }

        return redirect($link);

    }

    public function index($dir, $airport, $date, $adl, $chl, $inf, $type, $airline)
    {

        $lang = App::getLocale();

        $cip = \Illuminate\Support\Facades\Config::get("cip");

        $airport = strtoupper($airport);

        $services = $cip["airport_services"][$airport];

        $cip_data = [
            "num"     => "",
            "airport" => $airport,
            "date"    => $date,
            "adl"     => $adl,
            "chl"     => $chl,
            "inf"     => $inf,
            "airline" => $airline,
        ];

        return view('front.cip.index', compact('services', 'lang', 'dir', 'type', 'cip_data'));

    }


    public function cip_passengers($num, $airport, $date, $adl, $chl, $inf, $airline)
    {

        $lang = App::getLocale();

        $airport = strtoupper($airport);

        $airline_code = $airline;

        $airline = Airline::where('code', $airline_code)->first();

        $cip = \Illuminate\Support\Facades\Config::get("cip");

        $services = $cip["airport_services"][$airport];


        $services["service"] = [$services["service"][$num]];

        $dir = $services["service"][0]["dir"];
        $type = $services["service"][0]["tripe_type"];

        $country = Country::all();
        $country = json_decode(json_encode($country), true);

        $cip_data = [
            "num"     => $num,
            "airport" => $airport,
            "date"    => $date,
            "adl"     => $adl,
            "chl"     => $chl,
            "inf"     => $inf,
            "airline" => $airline_code,
        ];

        return view('front.cip_passenger.index', compact('lang', 'services', 'dir', 'type', 'cip_data', 'country', 'airport', 'airline'));

    }

    public function auto_complete_airline(Request $request)
    {

        $data = $request->data;
        $sec = $request->sec;
        $lang = $request->lang;


        $airlines = Airline::airline_search($data);


        return view('front.partials.airline_result', compact('airlines', 'sec', 'lang'));

    }


    public function transfer_data(Request $request)
    {

        $request = $request->input();
        $lang = $request["lang"];

        $request = $request["request"];

        $number = $request["number"];
        $i = $request["target"];
        $dir = $request["dir"];


        $text = view('front.cip_passenger.service_data', compact('number', 'i', 'lang', 'dir'))->render();

        $text = str_replace('disabled', '', $text);

        return $text;

    }


    public function cip_passengers_check(Request $request)
    {


//		convert request to array
        $request = $request->input();
        $request = $request["request"];
//		convert request to array


//		init total_price
        $total_price_e = 0;
        $total_price_r = 0;


//		get lang
        $lang = $request['lang'];
        app()->setLocale($lang);


        //		get cip service from file

        $cip_airport = $request["cip_airport"];
        $cip_airport_num = intval($request["cip_airport_num"]);
        $cip = \Illuminate\Support\Facades\Config::get("cip");

        $services = $cip["airport_services"][$cip_airport];

        $services["service"] = [$services["service"][$cip_airport_num]];


//		last date for birthdate
        $last_date = $request['last_date_bd'];


//		rule for request rule , passenger_insert for insert passengers , user_insert for insert user contact details
        $rule = [];
        $passenger_insert = [];
        $user_insert = [];

//		count is passengers nimber
        $count = $request["count"];


        $rule["airline"] = 'required';
        $rule["flight_number"] = 'required';
        $rule["cip_front_airport"] = 'required';
        $rule["cip_date"] = 'required';
        $rule["cip_time_hour"] = 'required';
        $rule["cip_time_minute"] = 'required';

        $adl = 0;
        $chl = 0;
        $inf = 0;

//		for , for set rule and passenger_insert
        for ($i = 1; $i <= $count; $i++) {

            $twelve = Carbon::parse($last_date)->subYears(12)->format('d.m.Y');
            $two = Carbon::parse($last_date)->subYears(2)->format('d.m.Y');
            $rule['gender' . $i] = 'required';
            $rule['f_name' . $i] = 'required';
            $rule['l_name' . $i] = 'required';
            $rule['country' . $i] = 'required';

            if ($request['type' . $i] == 1) {
                $rule['bd' . $i] = 'required|date|date_format:d.m.Y|before:' . $twelve;
            } else if ($request['type' . $i] == 2) {

                $rule['bd' . $i] = 'required|date|date_format:d.m.Y|before:' . $two . '|after:' . $twelve;
            } else if ($request['type' . $i] == 3) {

                $rule['bd' . $i] = 'required|date|date_format:d.m.Y|after:' . $two;
            }


            $passenger_insert[$i]["first_name"] = $request['f_name' . $i];
            $passenger_insert[$i]["last_name"] = $request['l_name' . $i];
            $passenger_insert[$i]["gender"] = $request['gender' . $i];
            $passenger_insert[$i]["type"] = $request['type' . $i];
            $passenger_insert[$i]["birthday"] = date('Y-m-d', strtotime($request['bd' . $i]));
            $passenger_insert[$i]["country"] = $request['country' . $i];

            if ($request['type' . $i] == 3) {
                $passenger_insert[$i]["price_e"] = $services["service"][0]["passenger"]["inf_passenger_euro"];
                $passenger_insert[$i]["price_r"] = $services["service"][0]["passenger"]["inf_passenger_rial"];
                $inf++;
            } elseif ($request['type' . $i] == 2) {

                $passenger_insert[$i]["price_e"] = $services["service"][0]["passenger"]["chl_passenger_euro"];
                $passenger_insert[$i]["price_r"] = $services["service"][0]["passenger"]["chl_passenger_rial"];
                $chl++;
            } else {
                $passenger_insert[$i]["price_e"] = $services["service"][0]["passenger"]["adl_passenger_euro"];
                $passenger_insert[$i]["price_r"] = $services["service"][0]["passenger"]["adl_passenger_rial"];
                $adl++;
            }

            $total_price_e += $passenger_insert[$i]["price_e"];
            $total_price_r += $passenger_insert[$i]["price_r"];

        }

        $rule['contact'] = 'required';
        $rule['email'] = 'required|email';
        $rule['phone'] = 'required|numeric';

//		contact person is arranger
        if ($request['contact'] == 0) {
            $rule['arranger_first_name'] = 'required';
            $rule['arranger_last_name'] = 'required';
            $arranger_first_name = $request["arranger_first_name"];
            $arranger_last_name = $request["arranger_last_name"];
        } //		contact person is one of the passengers
        else {
            $contact_person = $request['contact'];

            $arranger_first_name = $request['f_name' . $contact_person];
            $arranger_last_name = $request['l_name' . $contact_person];
        }


        $user_insert["email"] = $request["email"];
        $phone = $request["phone"];
        $dial_code = $request["country_dial_code"];


//		insert services
        $service_insert = [];
        $j = 0;
        if (isset($request["host_gender"])) {
            foreach ($request["host_gender"] as $key => $host) {

                $service_insert[$j]["type"] = "host";
                $service_insert[$j]["gender"] = $host;
                $service_insert[$j]["full_name"] = $request["host_full_name"][$key];

                $service_insert[$j]["transfer"] = "";
                $service_insert[$j]["address"] = "";
                $service_insert[$j]["time"] = "";
                $service_insert[$j]["phone"] = "";
                $service_insert[$j]["extra"] = "";
                $service_insert[$j]["number"] = 1;
                $service_insert[$j]["price_e"] = $services["service"][0]["welcome"][0]["costs"]["price_euro"];
                $service_insert[$j]["price_r"] = $services["service"][0]["welcome"][0]["costs"]["price_rial"];

                $total_price_e += $service_insert[$j]["price_e"];
                $total_price_r += $service_insert[$j]["price_r"];

                $j++;
            }
        }

        if (isset($request["transfer"])) {

            foreach ($request["transfer"] as $key => $transfer) {
                foreach ($request["address"][$key] as $key2 => $address) {

                    if ($services["service"][0]["dir"] == 2) {
                        $rule["transfer_phone"] = "required";
                        $rule["transfer_phone.$key"] = "required";
                        $rule["transfer_phone.$key.$key2"] = "required";
                    }
                    $transfer_num = $request["transfer_car_num"][$key];
                    $transfer_item = $services["service"][0]["transfer"][$transfer_num];

                    $service_insert[$j]["type"] = "transfer";
                    $service_insert[$j]["transfer"] = $transfer_item["car"]["name_en"];
                    $service_insert[$j]["address"] = $address;
                    $helper_hour = $request["transfer_time_hour"][$key][$key2];
                    $helper_minute = $request["transfer_time_minute"][$key][$key2];
                    $service_insert[$j]["time"] = date("H:i", strtotime($helper_hour . ":" . $helper_minute));
                    $service_insert[$j]["phone"] = $request["transfer_phone"][$key][$key2];

                    $service_insert[$j]["gender"] = "";
                    $service_insert[$j]["full_name"] = "";
                    $service_insert[$j]["extra"] = "";
                    $service_insert[$j]["number"] = 1;
                    $service_insert[$j]["price_e"] = $transfer_item["costs"]["price_euro"];
                    $service_insert[$j]["price_r"] = $transfer_item["costs"]["price_rial"];

                    $total_price_e += $service_insert[$j]["price_e"];
                    $total_price_r += $service_insert[$j]["price_r"];

                    $j++;
                }
            }
        }

        if (isset($request["extra"])) {

            foreach ($request["extra"] as $key => $extra) {

                $extra_num = $request["extra_num"][$key];
                $extra_item = $services["service"][0]["extra"][$extra_num];

                $service_insert[$j]["type"] = "extra";
                $service_insert[$j]["extra"] = $extra_item["name"]["name_en"];
                $service_insert[$j]["number"] = $request["number_extra"][$key];

                $service_insert[$j]["gender"] = "";
                $service_insert[$j]["full_name"] = "";
                $service_insert[$j]["transfer"] = "";
                $service_insert[$j]["address"] = "";
                $service_insert[$j]["time"] = "";
                $service_insert[$j]["phone"] = "";
                $service_insert[$j]["price_e"] = $request["number_extra"][$key] * $extra_item["costs"]["price_euro"];
                $service_insert[$j]["price_r"] = $request["number_extra"][$key] * $extra_item["costs"]["price_rial"];

                $total_price_e += $service_insert[$j]["price_e"];
                $total_price_r += $service_insert[$j]["price_r"];

                $j++;
            }
        }
//		request validator
        $validator = Validator::make($request, $rule);

        if ($validator->fails()) {

            $errors = $validator->errors();
            $errors = json_decode(json_encode($errors), true);

            for ($i = 0; $i <= 8; $i++) {
                for ($j = 0; $j <= 8; $j++) {
                    $tr = "transfer_phone." . $i . "." . $j;
                    if (isset($errors[$tr])) {
                        $trs = "'transfer_phone][$i][$j]'";
                        $errors[$trs] = $errors[$tr];
                        unset($errors[$tr]);
                    }
                }
            }
            return response()->json(['errors' => $errors]);

        }
//		//request validator


        $user = User::where('email', '=', $user_insert["email"])->get();

        $user_item = json_decode(json_encode($user), true);

//				if user email exist update mobile else insert user
        if (!empty($user_item)) {
            $user_id = $user_item[0]["id"];
        } else {
            User::insert($user_insert);

            $user_id = DB::select("SELECT LAST_INSERT_ID();");
            $user_id = json_decode(json_encode($user_id), true);
            $user_id = $user_id[0]["LAST_INSERT_ID()"];
        }


//				insert new and get insert id

        $cip_date = $request["cip_date"];
        $cip_time_hour = $request["cip_time_hour"];
        $cip_time_minute = $request["cip_time_minute"];

        $cip_time = date("H:i", strtotime($cip_time_hour . ":" . $cip_time_minute));

        $x = strripos($request["cip_front_airport"], '(');
        $x++;
        $cip_front_airport_code = substr($request["cip_front_airport"], $x, 3);

        $x = strripos($request["airline"], '(');
        $x++;
        $cip_airline_code = substr($request["airline"], $x, 2);


        $cip_insert_data = [
            "user_id"             => $user_id,
            "phone"               => $phone,
            "dial_code"           => $dial_code,
            "arranger_first_name" => $arranger_first_name,
            "arranger_last_name"  => $arranger_last_name,
            "cip_airport"         => $cip_airport,
            "service"             => $services["service"][0]["type"],
            "tripe_type"          => $services["service"][0]["tripe_type"],
            "flight_type"         => $services["service"][0]["dir"],
            "price_e"             => "",
            "price_r"             => "",
            "adult"               => $adl,
            "child"               => $chl,
            "infant"              => $inf,
            "airline_code"        => $cip_airline_code,
            "flight_number"       => $request["flight_number"],
            "front_airport"       => $cip_front_airport_code,
            "date_time"           => date('Y-m-d H:i', strtotime($cip_date . " " . $cip_time)),

        ];


        Cip_book::insert($cip_insert_data);

        $book_id = DB::select("SELECT LAST_INSERT_ID();");
        $book_id = json_decode(json_encode($book_id), true);
        $book_id = $book_id[0]["LAST_INSERT_ID()"];
        $book_id_hash = chr(rand(100, 999) % 26 + 65) . chr(rand(10, 99) % 26 + 65) . chr(rand(1000, 9999) % 26 + 65) . $book_id % 1000 . rand(100, 999);
        $helper = $book_id;

        Cip_book::where('id', '=', $book_id)->update([
            "token" => $book_id_hash,
        ]);
//				delete old book and insert new and get insert id


//				set book_id and price for passenger
        for ($i = 1; $i <= $count; $i++) {
            $passenger_insert[$i]["cip_book_id"] = $book_id;
        }

//				insert passengers
        Cip_passenger::insert($passenger_insert);


        foreach ($service_insert as $key => $value) {
            $service_insert[$key]["cip_book_id"] = $book_id;
        }

        Cip_service::insert($service_insert);

        Cip_book::where("id", $book_id)->update(["price_e" => $total_price_e, "price_r" => $total_price_r]);


//				generate next page url for redirect from js with token for book (use book token from this step)
        $x = route('cip_payment', ['book_token' => $book_id_hash]) . ($lang != "de" ? "?lang=" . $lang : "");


        return response()->json(['url' => $x]);

    }

    public function payment($book_token)
    {


        $lang = App::getLocale();


        $book = Cip_book::where('token', 'like', $book_token)->first();

        $cip_airport = $book->cip_airport;
        $cip_service_type = $book->service;
        $type = $book->tripe_type;
        $dir = $book->flight_type;

        $host = [];
        $transfer = [];
        $extra = [];
        foreach ($book->cip_services as $cip_service) {

            if ($cip_service->type == "host") {
                $host[] = $cip_service;
            } else if ($cip_service->type == "transfer") {
                $transfer[] = $cip_service;
            } else if ($cip_service->type == "extra") {
                $extra[] = $cip_service;
            }
        }

        $cip = \Illuminate\Support\Facades\Config::get("cip");

        $services = $cip["airport_services"][$cip_airport];

        foreach ($services["service"] as $service) {

            if ($service["type"] == $cip_service_type && $service["tripe_type"] == $type && $service["dir"] == $dir) {

                $services["service"] = [$service];
                break;
            }

        }

        $cip_data = [
            "num" => "",
            "adl" => $book->adult,
            "chl" => $book->child,
            "inf" => $book->infant,
        ];

        if (empty($services["service"])) {
            //error handling
            return redirect()->back();
        }

        return view('front.cip_payment.cip_payment', compact('lang', 'services', 'dir', 'type', 'book', 'host', 'transfer', 'extra', 'cip_data'));
    }

    public function cip_process_payment(request $request, $book_token)
    {

        ini_set('max_execution_time', 120);

        $lang = App::getLocale();

        $book = Cip_book::with([
            'cip_payments',
        ])->where('token', 'like', $book_token)->get();
        $book = json_decode(json_encode($book), true);
        $book = $book[0];


        if (!empty($book["payments"]) && $book["payments"]["status"] != "CREATED") {
            //			there is a payment for this book , go to passenger page and generate a new book

            $data["error"] = 1;

            $data["url"] = route('cip_iran') . ($lang != "de" ? "?lang=" . $lang : "");

            return $data;
        }


        $paypal = new paypal();

        $create_data = [
            "total"            => $book["price_e"],
            "currency"         => "EUR",
            "description"      => "Payment for " . $book["token"] . " in fly orient",
            "custom"           => "FlyOrient" . "_" . $book["token"],
            "invoice_number"   => $book["token"],
            "soft_descriptor"  => "Fly Orient online booking site " . $book["token"],
            "item_name"        => "cip",
            "item_description" => "cip airport : " . $book["cip_airport"] . " , service : " . $book["service"],
            "item_quantity"    => 1,
            "item_currency"    => "EUR",
            "book_token"       => $book["token"],
        ];

        $result = $paypal->create_payment($create_data);

        if (!isset($result["status"]) || $result["status"] != "CREATED") {
            //error handling

            return [];
            //dd($result);

        }
        //store payment details in payment table
        $payment_insert = [
            "cip_book_id" => $book["id"],
            "payment_id"  => $result["id"],
            "status"      => $result["status"],
        ];

        Cip_payment::insert($payment_insert);


        $data["orderID"] = $result["id"];

        return $data;
    }

    public function cip_confirm_payment(request $request, $method)
    {

        ini_set('max_execution_time', 120);
        $lang = App::getLocale();


        $payment_id = $request->input('paymentId');
        $payer_id = $request->input('payerID');


        $payment = Cip_payment::where('payment_id', 'like', $payment_id)->first();

        $book_id = $payment->cip_book_id;
        $book = $payment->cip_books;

        $book_first_status = $book->status;

        $user_email = $book->users->email;

        $client_unique_id = $book->user_id . chr(rand(65, 90)) . $book->id . chr(rand(65, 90)) . $book->flight_number;


//		get cip service detail
        $cip_airport = $book->cip_airport;
        $cip_service_type = $book->service;
        $type = $book->tripe_type;
        $dir = $book->flight_type;

        $host = [];
        $transfer = [];
        $extra = [];
        foreach ($book->cip_services as $cip_service) {

            if ($cip_service->type == "host") {
                $host[] = $cip_service;
            } else if ($cip_service->type == "transfer") {
                $transfer[] = $cip_service;
            } else if ($cip_service->type == "extra") {
                $extra[] = $cip_service;
            }
        }

        $cip = \Illuminate\Support\Facades\Config::get("cip");

        $services = $cip["airport_services"][$cip_airport];

        foreach ($services["service"] as $service) {

            if ($service["type"] == $cip_service_type && $service["tripe_type"] == $type && $service["dir"] == $dir) {

                $services["service"] = [$service];
                break;
            }

        }
//		end get cip service detail


        if ($method == "paypal") {

            $paypal = new paypal();


            if ($payment->status == "CREATED") {

                $result = $paypal->order($payment_id);


                if (!isset($result["status"]) || ($result["status"] != "APPROVED" && $result["status"] != "COMPLETED")) {
                    //failed payment

                    $payment->update([
                        "status" => "FAILED",
                    ]);

                    $book->update([
                        "status" => "payment_failed",
                    ]);

                    return view('front.cip_payment_result.failed', compact('lang'));
                }

                $payment->update([
                    "payer_id" => $payer_id,
                    "status"   => $result["status"],
                ]);

            } elseif ($payment->status != "APPROVED" && $payment->status != "COMPLETED") {

                $book->update([
                    "status" => "payment_failed",
                ]);

                return view('front.cip_payment_result.failed', compact('lang'));

            }


        } else {
//			other method

            redirect(route('cip_iran') . ($lang != "de" ? "?lang=" . $lang : ""));
        }


        //payment was success , go

        if ($book->status == "booking") {


//		capture order
            if ($method == "paypal" && $payment->status != "COMPLETED") {

                $result = $paypal->capture_payment($payment_id);
                if (!isset($result["purchase_units"][0]["payments"]["captures"][0]["status"]) || $result["purchase_units"][0]["payments"]["captures"][0]["status"] != "COMPLETED") {
//				order not captured , log it
                } else {
                    $payment->update([
                        "status" => "COMPLETED",
                    ]);
                }
            }
//		/capture order


        }


        $book->update([
            "status" => "wait_for_ticket",
        ]);
        $booked = true;


        $file_name = $book->token . ".pdf";

        $pdf_download = 1;

        if ($lang != "de") {
            app()->setLocale("en");
        }

        $confirm_view = view('front.cip_payment_result.confirm', compact('lang', 'services', 'dir', 'type', 'book', 'host', 'transfer', 'extra', 'file_name', 'booked', 'pdf_download'))->render();
        $ticket_view = view('front.cip_payment_result.confirm', compact('lang', 'services', 'dir', 'type', 'book', 'host', 'transfer', 'extra', 'file_name', 'booked'))->render();


        require_once "script/xinvoice.php";

        $xinvoice = new \Xinvoice();

        $xinvoice->setSettings("filename", "../../../../../../public/tickets/cip_tickets/$file_name");
        $xinvoice->setSettings("output", "F");
        $xinvoice->setSettings("format", "A4");

        $xinvoice->htmlToPDF($ticket_view);


        if ($book_first_status == "booking") {
            //send email to user and admin

            $file_path = realpath("tickets/cip_tickets/" . $file_name);

            Mail::to($user_email)->send(new cip_ticket($lang, $file_path));


            $setting = Setting::get()->first();

            Mail::to($setting["email"])->send(new cip_ticket_sup($lang, $file_path));

////			Mail::to( "vendor email" )->send( new cip_ticket_vendor( $lang , $file_path));

        }


        return $confirm_view;


    }

    public function cip_cancel_payment(Request $request, $book_token)
    {


        $book = Cip_book::where('token', 'like', $book_token)->get();
        $book = json_decode(json_encode($book), true);
        $book = $book[0];

        Cip_payment::where('cip_book_id', '=', $book['id'])->update(["status" => "FAILED"]);

        Cip_book::where('id', '=', $book['id'])->update([
            "status" => "payment_failed",
        ]);

        return view('front.cip_payment_result.cancel', compact('lang'));

    }

}

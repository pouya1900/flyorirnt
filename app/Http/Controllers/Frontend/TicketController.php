<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\UserRequest;
use App\Mail\ticket;
use App\Mail\invoice;
use App\Mail\ticket_sup;
use App\Models\Book;
use App\Models\Country;
use App\Models\Flight;
use App\Models\Passenger;
use App\Models\Payment;
use App\Models\Session;
use App\Models\Setting;
use App\Models\Scheduler;
use App\Models\Payment_scheduler;
use App\Services\Payments\paypal;
use App\Services\Renders\amadeus;
use App\Services\Renders\parto;
use App\Services\Renders\iranAir;
use App\Services\Renders\Render;
use App\Models\Page;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Validator;
use App\Services\Log\log;
use App\Services\MyHelperFunction;
use Illuminate\Support\Facades\Event;
use App\Events\SendEmailEvent;

class TicketController extends Controller
{

    public $log;

    public function __construct()
    {
        $this->log = new log();
    }

    public function turn_title($gender, $type)
    {

        if ($gender == 0 && $type == 1) {
            $title = 0;
        } else if ($gender == 0) {
            $title = 4;
        } else if ($gender == 1 && $type == 1) {
            $title = 1;
        } else {
            $title = 3;
        }

        return $title;
    }

    public function passengers(Request $request, $id)
    {
        $lang = App::getLocale();
        $setting = Setting::find(1);


        if ($setting->offline_ticket && (!Auth::check() || Auth::user()->role != User::admin)) {
            return view('front.errors.offline_ticketing', compact('lang'));
        }


        $flight = Flight::where('id', $id)
            ->with('searches', 'airlines', 'legs', 'legs.airlines', 'legs.airports1', 'legs.airports2', 'multi_flights', 'multi_flights.airlines', 'multi_flights.legs', 'multi_flights.legs.airlines', 'multi_flights.legs.airports1', 'multi_flights.legs.airports2')->join('costs', 'costs.flight_id', '=', 'flights.id')
            ->first();


        if (empty($flight)) {
            return redirect()->back();
        }


        $research_data =
            [
                "link"             => $flight->searches->link,
                'origin'           => $flight->searches->origin_code,
                "destination"      => $flight->searches->destination_code,
                "origin_name"      => $flight->searches->origin_name,
                "destination_name" => $flight->searches->destination_name,
                "adl"              => $flight->searches->adult,
                "chl"              => $flight->searches->child,
                "inf"              => $flight->searches->infant,
                "depart_date"      => date('d.m.Y', strtotime($flight->depart_time)),
                "return_date"      => "",
            ];

        if ($flight["return_depart_time"]) {
            $research_data["return_date"] = date('d.m.Y', strtotime($flight["return_depart_time"]));
        }


//		choose render
        $render_number = $flight["render"];
        $instance_render = $this->set_render($render_number);
//		choose render

        $validate = $instance_render->revalidate($flight);
        //$validate = 1;


        $country = Country::all();
        $country = json_decode(json_encode($country), true);

        $domestic = 0;
        if ($flight->airports1->country == "IR" && $flight->airports2->country == "IR") {
            $domestic = 1;
        }


        return view('front.passenger.passenger', compact('flight', 'lang', 'country', 'validate', 'research_data', 'domestic'));


    }

    public function passengers_check(Request $request)
    {
//		convert request to array
        $request = $request->input();
        $request = $request["request"];
//		convert request to array


//		token for url
        $token = $request['token'];

//		is domestic or not
        $dom = $request['domestic'];

//		get lang
        $lang = $request['lang'];
        app()->setLocale($lang);


//		last date for birthdate
        $last_date = $request['last_date_bd'];

//		search flight with token
        $flight = Flight::where('token', 'like', $token)->join('costs', 'costs.flight_id', '=', 'flights.id')->get();

//		convert flight to array
        $flight = json_decode(json_encode($flight), true);
        $flight = $flight[0];


        $id = $flight["id"];

//		rule for request rule , passenger_insert for insert passengers , user_insert for insert user contact details
        $rule = [];
        $passenger_insert = [];
        $user_insert = [];

//		count is passengers nimber
        $count = $request["count"];
//		for , for set rule and passenger_insert
        for ($i = 1; $i <= $count; $i++) {

            $twelve = Carbon::parse($last_date)->subYears(12)->format('d.m.Y');
            $two = Carbon::parse($last_date)->subYears(2)->format('d.m.Y');
            $rule['gender' . $i] = 'required';
            $rule['f_name' . $i] = 'required|regex:/^[A-za-z\s]+$/i';
            $rule['l_name' . $i] = 'required|regex:/^[A-za-z\s]+$/i';
            $rule['country' . $i] = 'required';

            if ($request['type' . $i] == 1) {
                $rule['bd' . $i] = 'required|date|date_format:d.m.Y|before:' . $twelve;
            } else if ($request['type' . $i] == 2) {

                $rule['bd' . $i] = 'required|date|date_format:d.m.Y|before:' . $two . '|after:' . $twelve;
            } else if ($request['type' . $i] == 3) {

                $rule['bd' . $i] = 'required|date|date_format:d.m.Y|after:' . $two;
            }


            if ($flight["IsPassportMandatory"]) {
                $rule['exp' . $i] = 'required|date';
            }
            if ($flight["IsPassportIssueDateMandatory"]) {
                $rule['iss' . $i] = 'required|date';
            }

            if ($request['country' . $i] == "IR" && $dom) {
                $rule['nid' . $i] = 'required|numeric';
                $rule['exp' . $i] = 'date|nullable';
            } elseif ($flight["IsPassportNumberMandatory"]) {
                $rule['pass_number' . $i] = 'required|alpha_num';
            }

            if ($request['country' . $i] != "IR" && $flight['DirectionInd'] == 1 && $flight["ValidatingAirlineCode"] == "IR" && $flight["arrival_airport"] == "IR") {
                return response()->json(['errors' => ["country . $i" => trans('trs.iran_air_not_support_one_way_for_non_iranian')]]);
            }


            $passenger_insert[$i]["first_name"] = $request['f_name' . $i];
            $passenger_insert[$i]["last_name"] = $request['l_name' . $i];
            $passenger_insert[$i]["gender"] = $request['gender' . $i];
            $passenger_insert[$i]["type"] = $request['type' . $i];
            $passenger_insert[$i]["birthday"] = date('Y-m-d', strtotime($request['bd' . $i]));
            $passenger_insert[$i]["country"] = $request['country' . $i];
            $passenger_insert[$i]["expiry_date"] = isset($request['exp' . $i]) ? date('Y-m-d', strtotime($request['exp' . $i])) : null;
            $passenger_insert[$i]["passport_number"] = isset($request['pass_number' . $i]) ? $request['pass_number' . $i] : null;
            $passenger_insert[$i]["national_id"] = isset($request['nid' . $i]) ? $request['nid' . $i] : null;
            $passenger_insert[$i]["issue_date"] = isset($request['iss' . $i]) ? date('Y-m-d', strtotime($request['iss' . $i])) : null;
        }

        $rule['contact'] = 'required';
        $rule['email'] = 'required|email';
        $rule['phone'] = 'required|numeric';

//		contact person is arranger
        if ($request['contact'] == 0) {
            $rule['arranger_first_name'] = 'required|regex:/^[A-za-z\s]+$/i';
            $rule['arranger_last_name'] = 'required|regex:/^[A-za-z\s]+$/i';
            $arranger_first_name = $request["arranger_first_name"];
            $arranger_last_name = $request["arranger_last_name"];
        } //		contact person is one of the passengers
        else {
            $contact_person = $request['contact'];

            $arranger_first_name = $request['f_name' . $contact_person];
            $arranger_last_name = $request['l_name' . $contact_person];
        }

        $user_insert["email"] = $request["email"];
        $phone = $this->make_mobile_without_zero($request["phone"]);
        $dial_code = $request["country_dial_code"];

        //		request validator
        $validator = Validator::make($request, $rule);

        if ($validator->fails()) {

            $errors = $validator->errors();
            $errors = json_decode(json_encode($errors), true);

            return response()->json(['errors' => $errors]);

        }
//		//request validator


        if (empty($flight)) {
            return redirect()->back();
        }

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
        $book = Book::create([
            "flight_id"           => $id,
            "user_id"             => $user_id,
            "phone"               => $phone,
            "dial_code"           => $dial_code,
            "arranger_first_name" => $arranger_first_name,
            "arranger_last_name"  => $arranger_last_name,
        ]);

        $book_id = $book->id;
        $book_id_hash = chr(rand(100, 999) % 26 + 65) . chr(rand(10, 99) % 26 + 65) . chr(rand(1000, 9999) % 26 + 65) . $book_id % 1000 . rand(100, 999);
        $book->update(["token" => $book_id_hash]);
//				delete old book and insert new and get insert id


//				set book_id for passenger
        for ($i = 1; $i <= $count; $i++) {
            $passenger_insert[$i]["book_id"] = $book_id;
        }

//				insert passengers
        Passenger::insert($passenger_insert);

        $book->flights->update(["status" => "onbook"]);


//				generate next page url for redirect from js with token for book (use book token from this step)
        $x = route('payment', ['book_token' => $book_id_hash]) . ($lang != "de" ? " ? lang = " . $lang : "");


        return response()->json(['url' => $x]);

    }


    public function payment($book_token)
    {

//		token for book table

        $lang = App::getLocale();
        $setting = Setting::get()->first();
        $book = Book::with([
            'passengers.countries',
            'users',
        ])->where('token', 'like', $book_token)->get();
        $book_object = $book->first();
        $book = json_decode(json_encode($book), true);

        $book = $book[0];

        $flight_id = $book["flight_id"];

        $flight = Flight::where('id', $flight_id)
            ->with('searches', 'airlines', 'legs', 'legs.airlines', 'legs.airports1', 'legs.airports2', 'multi_flights', 'multi_flights.airlines', 'multi_flights.legs', 'multi_flights.legs.airlines', 'multi_flights.legs.airports1', 'multi_flights.legs.airports2')->join('costs', 'costs.flight_id', '=', 'flights.id')
            ->first();

        if (empty($flight)) {
            //error handling
            return redirect()->back();
        }


        if ($setting->no_payment_admin && Auth::check() && Auth::user()->role == User::admin) {

            $payment_insert = [
                "book_id"    => $book["id"],
                "payment_id" => "paymentByAdmin" . $book["id"],
                "payer_id"   => Auth::user()->id,
                "status"     => "COMPLETED",
                "method"     => "admin",
            ];
            Payment::create($payment_insert);

            return redirect()->route('confirm_payment', ['method' => 'admin', 'paymentId' => "paymentByAdmin" . $book["id"], 'payerID' => Auth::user()->id]);

        }
        $agency = [];
        if (Auth::check() && Auth::user()->role == User::agency) {

            if (!Auth::user()->active) {
                return view('front.payment_result.agency_not_active', compact('lang'));
            }

            if (!$book_object->payment) {
                $payment_insert = [
                    "book_id"        => $book["id"],
                    "payment_id"     => "paymentByAgency" . $book["id"],
                    "payer_id"       => Auth::user()->id,
                    "status"         => "CREATED",
                    "method"         => "agency",
                    "before_balance" => Auth::user()->balance->amount,
                ];
                Payment::create($payment_insert);
            } else {
                $book_object->payment->update([
                    "payment_id"     => "paymentByAgency" . $book["id"],
                    "payer_id"       => Auth::user()->id,
                    "status"         => "CREATED",
                    "method"         => "agency",
                    "before_balance" => Auth::user()->balance->amount,
                ]);
            }
            $agency = [
                'balance' => Auth::user()->balance->amount,
                'link'    => route('confirm_payment', ['method' => 'agency', 'paymentId' => "paymentByAgency" . $book["id"], 'payerID' => Auth::user()->id]),
            ];
        }

        $research_data =
            [
                "link"             => $flight->searches->link,
                'origin'           => $flight->searches->origin_code,
                "destination"      => $flight->searches->destination_code,
                "origin_name"      => $flight->searches->origin_name,
                "destination_name" => $flight->searches->destination_name,
                "adl"              => $flight->searches->adult,
                "chl"              => $flight->searches->child,
                "inf"              => $flight->searches->infant,
                "depart_date"      => date('d.m.Y', strtotime($flight->depart_time)),
                "return_date"      => "",
            ];

        return view('front.payment.payment', compact('flight', 'book', 'lang', 'agency', 'research_data'));

    }

    public function process_payment(request $request, $book_token)
    {

        ini_set('max_execution_time', 120);

        $lang = App::getLocale();

        $setting = Setting::get()->first();

        $book = Book::where('token', 'like', $book_token)->first();

        $flight_id = $book->flight_id;

        $flight = Flight::where('id', '=', $flight_id)->first();

        if (!$flight) {
            //error handling
            $data["error"] = 1;
            $data["url"] = route('home') . ($lang != "de" ? " ? lang = " . $lang : "");

            return $data;
        }

        //			revalidate call vendor


//		choose render
        $render_number = $flight["render"];

        $instance_render = $this->set_render($render_number);
//		choose render


        $validate = $instance_render->revalidate($flight);
        //$validate = 1;

        if (!$validate) {
//			error handling flight is not valid , go search result

            $data["error"] = 2;


            $research_data =
                [
                    "link"             => $flight->searches["link"],
                    'origin'           => $flight->searches["origin_code"],
                    "destination"      => $flight->searches["destination_code"],
                    "origin_name"      => $flight->searches["origin_name"],
                    "destination_name" => $flight->searches["destination_name"],
                    "adl"              => $flight->searches["adult"],
                    "chl"              => $flight->searches["child"],
                    "inf"              => $flight->searches["infant"],
                    "depart_date"      => date('d.m.Y', strtotime($flight["depart_time"])),
                    "return_date"      => "",
                ];
            if ($flight["return_depart_time"]) {
                $research_data["return_date"] = date('d.m.Y', strtotime($flight["return_depart_time"]));
            }


            $data["view"] = view('front.partials.validate_error', compact('research_data', 'lang'))->render();

            return $data;
        }

        if ($book->payments && $book->payments["status"] != "CREATED") {
            //			there is a payment for this book , go to passenger page and generate a new book

            $data["error"] = 1;

            $data["url"] = route('passengers_info', ["flight_token" => $flight["token"]]) . ($lang != "de" ? " ? lang = " . $lang : "");

            return $data;
        }


        $paypal = new paypal();

        $create_data = [
            "total"            => $flight->costs["TotalFare"],
            "currency"         => $flight->costs["Currency"],
            "description"      => "Payment for " . $book["token"] . " in fly orient",
            "custom"           => "FlyOrient" . "_" . $book["token"],
            "invoice_number"   => $book["token"],
            "soft_descriptor"  => "Fly Orient online booking site " . $book["token"],
            "item_name"        => "flight",
            "item_description" => $flight["depart_airport"] . " to " . $flight["arrival_airport"],
            "item_quantity"    => 1,
            "item_currency"    => $flight->costs["Currency"],
            "book_token"       => $book["token"],
        ];

        if (($setting->test_one_euro || $setting->test_one_euro_with_book) && Auth::check() && Auth::user()->role == User::admin) {
            $create_data["total"] = 1;
        }

        $result = $paypal->create_payment($create_data);
        if (!isset($result["status"]) || $result["status"] != "CREATED") {
            //error handling

            $this->log->payment_error(json_encode($result), 'create');

            return [];
            //dd($result);

        }
        //store payment details in payment table

        if (!$book->payments) {
            $payment_insert = [
                "book_id"    => $book["id"],
                "payment_id" => $result["id"],
                "status"     => $result["status"],
                "method"     => "paypal",
            ];
            Payment::create($payment_insert);
        } else {
            $payment_update = [
                "payment_id" => $result["id"],
                "payer_id"   => "",
                "status"     => $result["status"],
                "method"     => "paypal",
            ];
            Payment::where('book_id', $book["id"])->update($payment_update);
        }

        $data["orderID"] = $result["id"];

        return $data;

    }


    public function confirm_payment(request $request, $method)
    {
        ini_set('max_execution_time', 120);
        $lang = App::getLocale();

        $setting = Setting::get()->first();

        $payment_id = $request->input('paymentId');
        $payer_id = $request->input('payerID');
        $blocked_payer = \Illuminate\Support\Facades\Config::get("blockPayer");


        $payment = Payment::where('payment_id', 'like', $payment_id)->first();

        $book_id = $payment->book_id;
        $flight_id = $payment->books->flights->id;
        $book = $payment->books;
        $book_unique_id = $book->UniqueId;
        $user_email = $book->users->email;

        $book_first_status = $book->status;

        $flight_obj = $book->flights;
        $searches = $flight_obj->searches;

        $research_data =
            [
                "link"             => $searches->link,
                'origin'           => $searches->origin_code,
                "destination"      => $searches->destination_code,
                "origin_name"      => $searches->origin_name,
                "destination_name" => $searches->destination_name,
                "adl"              => $searches->adult,
                "chl"              => $searches->child,
                "inf"              => $searches->infant,
                "depart_date"      => date('d.m.Y', strtotime($flight_obj->depart_time)),
                "return_date"      => "",
            ];
        if ($flight_obj->return_depart_time) {
            $research_data["return_date"] = date('d.m.Y', strtotime($flight_obj->return_depart_time));
        }
        $paypal = new paypal();

        $flight = Flight::where('id', '=', $flight_id)->join('costs', 'costs.flight_id', '=', 'flights.id')->get();
        $flight = json_decode(json_encode($flight), true);
        $flight = $flight[0];
        if ($method == "paypal") {

            if (in_array($payer_id, $blocked_payer)) {
                $payment->update([
                    "status" => "BLOCKED",
                ]);

                $book->update([
                    "status" => "payment_failed",
                ]);
                return view('front.payment_result.failed', compact('lang', 'research_data'));
            }

            if ($payment->status == "CREATED") {
//				//payment is in cancel state or approved

                $result = $paypal->order($payment_id);


                if (!isset($result["status"]) || ($result["status"] != "APPROVED" && $result["status"] != "COMPLETED")) {
                    //failed payment
                    $payment->update([
                        "status" => "FAILED",
                    ]);

                    $book->update([
                        "status" => "payment_failed",
                    ]);

                    $this->log->payment_error(json_encode($result), 'orderDetails', $payment);


                    return view('front.payment_result.failed', compact('lang', 'research_data'));
                }

                $result = $paypal->authorize($payment_id);

                if (!isset($result["status"]) || ($result["status"] != "APPROVED" && $result["status"] != "COMPLETED")) {
                    //failed payment
                    $payment->update([
                        "status" => "FAILED",
                    ]);

                    $book->update([
                        "status" => "payment_failed",
                    ]);

                    $this->log->payment_error(json_encode($result), 'authorize', $payment);

                    return view('front.payment_result.failed', compact('lang', 'research_data'));
                }

                $payment->update([
                    "payer_id" => $payer_id,
                    "auth_id"  => $result["purchase_units"][0]["payments"]["authorizations"][0]["id"],
                    "status"   => "APPROVED",
                ]);

            } elseif ($payment->status != "APPROVED" && $payment->status != "COMPLETED") {
                return view('front.payment_result.failed', compact('lang', 'research_data'));
            }


        } elseif ($setting->no_payment_admin && Auth::check() && Auth::user()->role == User::admin) {

        } elseif ($method == "agency") {
            $user = Auth::user();
            if ($payment->status == "CREATED") {

                if ($user->balance->amount < $flight["TotalFare"] - $flight["TotalAgencyCommission"]) {
                    $payment->update([
                        "status" => "FAILED",
                    ]);

                    $book->update([
                        "status" => "payment_failed",
                    ]);

                    return view('front.payment_result.failed', compact('lang', 'research_data'));
                }
            } elseif ($payment->status != "APPROVED" && $payment->status != "COMPLETED") {

                return view('front.payment_result.failed', compact('lang', 'research_data'));
            }

        } else {
//			other method

            redirect(route('home') . ($lang != "de" ? " ? lang = " . $lang : ""));
        }


        //		choose render
        $render_number = $flight["render"];
        $instance_render = $this->set_book_render($render_number);
        if (!$instance_render) {
            return view('front.errors.ticket_cant_book_at_this_time', compact('lang'));
        }
//		choose render

        //payment was success , go for vendor api call

        if ($setting->test_one_euro && !$setting->test_one_euro_with_book && !$setting->no_payment_admin && Auth::check() && Auth::user()->role == User::admin) {
            $book->update([
                "status" => "vendor_failed",
            ]);

            dd("test payment was success by admin , booking not call and payment not capture");
        }


        if ($book->status == "booking") {

            //			call revalidate  vendor
            $validate = $instance_render->revalidate($flight);
            //$validate = 1;

            if (!$validate) {
//			error handling flight is not valid , go search result

                $book->update([
                    "status" => "vendor_failed",
                ]);

                $this->void_payment($method, $payment);

                return view('front.payment_result.single_validate_error', compact('research_data', 'lang'));
            }

            //call airbook


//			call all booking and issue tickets apis from vendor
            $book_response = $instance_render->book($flight, $payment);


            if ($book_response["error"] == 1) {
                $this->void_payment($method, $payment);
                return view('front.payment_result.failed', compact('lang', 'research_data'));
            }

            $book_unique_id = $book_response["book_unique_id"];

//		capture order
            if ($method == "paypal" && $payment["status"] != "COMPLETED") {

                $result = $paypal->capture_payment($payment->auth_id);
                if (!isset($result["status"]) || $result["status"] != "COMPLETED") {
                    $payment_scheduler = Payment_scheduler::create(["payment_id" => $payment_id]);
                    $this->log->payment_error(json_encode($result), 'capture', $payment);

                } else {
                    $payment->update([
                        "status" => "COMPLETED",
                    ]);
                }
            }

            if ($method == "agency" && $payment["status"] != "COMPLETED" && $payment["status"] != "APPROVED") {
                $before_balance = Auth::user()->balance->amount;
                Auth::user()->balance->update(['amount' => $before_balance - $flight["TotalFare"] + $flight["TotalAgencyCommission"]]);

                $last_payment = Payment::where('payer_id', Auth::user()->id)
                    ->where(function ($q) {
                        return $q->where('status', 'COMPLETED')->orwhere('status', 'APPROVED');
                    })->orderBy('invoice_number', 'desc')->first();

                if ($last_payment) {
                    $new_invoice_n = $last_payment->invoice_number + 1;
                } else {
                    $new_invoice_n = 0;
                }
                $payment->update([
                    "status"         => "APPROVED",
                    "before_balance" => $before_balance,
                    "after_balance"  => Auth::user()->balance->amount,
                    "invoice_number" => $new_invoice_n,
                ]);

                require_once "script / xinvoice . php";

                $xinvoice2 = new \Xinvoice();


                $number_string = MyHelperFunction::turn_4digit_format($new_invoice_n);

                $this_year = Carbon::now()->year;
                $this_year = $this_year % 100;
                $invoice_number = $book->users->code . '-' . $this_year . $number_string;

                $book = $book->fresh();

                $invoice_view = view('front.invoice.agency_invoice', compact('book', 'lang', 'invoice_number'))->render();


                $file_name = $invoice_number . '.pdf';
                $xinvoice2->setSettings("filename", " ../../../../../../public/invoices / $file_name");
                $xinvoice2->setSettings("output", "F");
                $xinvoice2->setSettings("format", "A4");
                $xinvoice2->htmlToPDF($invoice_view);

                $file_path = realpath("invoices / " . $file_name);

                Event::dispatch(new SendEmailEvent($user_email, new invoice($lang, $file_path)));

            }
//		/capture order


        }

        $response = $this->check_booking_status($instance_render, $book, $lang, $book_first_status);

        if (isset($response["error"])) {
            return view('front.payment_result.failed', compact('lang', 'research_data'));
        }

        return $response["view"];

    }

    public function cancel_payment(Request $request, $book_token)
    {
        ini_set('max_execution_time', 120);

        $lang = App::getLocale();


        $book = Book::where('token', 'like', $book_token)->first();

        $payment = Payment::where('book_id', '=', $book->id)->first();
        $research_data = [
            "link"             => $book->flights->searches->link,
            'origin'           => $book->flights->searches->origin_code,
            "destination"      => $book->flights->searches->destination_code,
            "origin_name"      => $book->flights->searches->origin_name,
            "destination_name" => $book->flights->searches->destination_name,
            "adl"              => $book->flights->searches->adult,
            "chl"              => $book->flights->searches->child,
            "inf"              => $book->flights->searches->infant,
            "depart_date"      => date('d.m.Y', strtotime($book->flights->depart_time)),
            "return_date"      => "",
        ];

        if (($book->status == "booking" || $book->status == "payment_cancelled") && ($payment->status == "CREATED" || $payment->status == "CANCELLED")) {
            if ($book->flights->depart_time) {
                $research_data["return_date"] = date('d.m.Y', strtotime($book->flights->depart_time));
            }


            $payment->update(["status" => "CANCELLED"]);

            $book->update([
                "status" => "payment_cancelled",
            ]);

            return view('front.payment_result.cancel', compact('lang', 'research_data'));
        }

        return view('front.payment_result.cancel', compact('lang', 'research_data'));

    }


    public
    function ticket_issue_scheduler()
    {

        $schedulers = Scheduler::where('status', 'active')->get();

        if (!$schedulers) {
            return ["code" => 0];
        }

        foreach ($schedulers as $scheduler) {

            $scheduler->update(["attempts" => $scheduler->attempts + 1]);

            $book = $scheduler->book;

            if ($book) {
                $render_number = $book->flights->render;
                $instance_render = $this->set_book_render($render_number);

                $this->check_booking_status($instance_render, $book, "en", $book->status);
            } else {
                $scheduler->update(["status" => "stopped"]);
            }
        }

    }

    public
    function check_booking_status($instance_render, $book, $lang, $book_first_status)
    {
        $book_unique_id = $book->UniqueId;
        $book_id = $book->id;

        $user_email = $book->users->email;
        $book_data_response = $instance_render->update_booking_status($book, $book_unique_id);

        $booked = $book_data_response["booked"];
        $book = $book_data_response["book"];

        if ($book->status != "booked" && $book->status != "wait_for_ticket") {

            if ($book->scheduler) {
                $book->scheduler->update(["status" => "stopped", "failed_response" => json_encode($book_data_response["response"])]);
            }

            return ["error" => 1];
        }

        $file_name = $book->token . " . pdf";

        $pdf_download = 1;

        if ($lang != "de") {
            app()->setLocale("en");
        }

        $condition = $instance_render->getCondition();

        $confirm_view = view('front.payment_result.confirm', compact('book', 'lang', 'file_name', 'booked', 'pdf_download', 'condition'))->render();
        $ticket_view = view('front.payment_result.confirm', compact('book', 'lang', 'file_name', 'booked', 'condition'))->render();

        require_once "script / xinvoice . php";

        $xinvoice = new \Xinvoice();

        $xinvoice->setSettings("filename", " ../../../../../../public/tickets / $file_name");
        $xinvoice->setSettings("output", "F");
        $xinvoice->setSettings("format", "A4");
        $xinvoice->htmlToPDF($ticket_view);

        if ($book_first_status == "booking" || ($book_first_status == "wait_for_ticket" && $book->status == "booked")) {
            //send email to user and admin

            $file_path = realpath("tickets / " . $file_name);


            Event::dispatch(new SendEmailEvent($user_email, new ticket($lang, $file_path)));

            $setting = Setting::get()->first();

            Event::dispatch(new SendEmailEvent($setting["email"], new ticket_sup($lang, $file_path)));

        }

        if ($book->status == "booked" && $book->scheduler) {
            $book->scheduler->update(["status" => "done"]);
        }

        return ["view" => $confirm_view];

    }

    public
    function capture_payment_scheduler()
    {
        $schedulers = Payment_scheduler::where('status', 'active')->get();

        if (!$schedulers) {
            return ["code" => 0];
        }

        $paypal = new paypal();
        foreach ($schedulers as $scheduler) {

            $scheduler->update(["attempts" => $scheduler->attempts + 1]);

            $payment = $scheduler->payment;

            $payment_id = $payment->payment_id;

            $result = $paypal->capture_payment($payment_id);
            if (!isset($result["purchase_units"][0]["payments"]["captures"][0]["status"]) || $result["purchase_units"][0]["payments"]["captures"][0]["status"] != "COMPLETED") {

                if ($scheduler->attempts > 5) {
                    $scheduler->update(["status" => "stopped", "failed_response" => json_encode($result)]);
                }

            } else {
                $payment->update([
                    "status" => "COMPLETED",
                ]);
                $schedulers->update(["status" => "done"]);
            }

        }

    }

    public
    function void_payment($method, $payment)
    {
        $paypal = new paypal();

        if ($method == "paypal") {
            $paypal->void_payment($payment->auth_id);
        }
    }

}

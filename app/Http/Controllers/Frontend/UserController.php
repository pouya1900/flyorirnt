<?php

namespace App\Http\Controllers\Frontend;

use App\Events\SendEmailEvent;
use App\Http\Requests\UserRequest;
use App\Mail\register;
use App\Mail\reset;
use App\Mail\ticket;
use App\Models\Book;
use App\Models\Cip_book;
use App\Models\Country;
use App\Models\Payment;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Validator;

class UserController extends Controller
{

    public function index()
    {

        $lang = App::getLocale();

        $user_id = Auth::user()->id;
        $user = Auth::user();
        
        $books = Book::with(['flights.costs'])->where('user_id', '=', $user_id)->where(function ($q) {
            return $q->where('status', 'booked')->orwhere('status', 'wait_for_ticket');
        })->orderBy('updated_at', 'desc')->get();
        $books = json_decode(json_encode($books), true);

        $unseccess_books = Book::with(['flights.costs'])->where('user_id', '=', $user_id)->where(function ($q) {
            return $q->where('status', '!=', 'booked')->where('status', '!=', 'booking')->where('status', '!=', 'wait_for_ticket');
        })->orderBy('updated_at', 'desc')->limit(15)->get();
        $unseccess_books = json_decode(json_encode($unseccess_books), true);

        $wallet = null;
        if ($user->role == User::agency) {
            $wallet = Payment::wherehas('books', function ($q) use ($user_id) {
                return $q->where('user_id', $user_id);
            })->where('method', 'agency')->where('status', '!=', 'CREATED')->orderBy('updated_at', 'desc')->get();


        }
        
        $cip_books = Cip_book::where('user_id', '=', $user_id)->where('status', 'booked')->get();
        $cip_books = json_decode(json_encode($cip_books), true);

        return view('front.profile.profile', compact('books', 'unseccess_books', 'lang', 'cip_books', 'wallet'));

    }


    public function login()
    {

        $lang = App::getLocale();

        if (Auth::check()) {
            return redirect(route('profile') . ($lang != "de" ? "?lang=" . $lang : ""));
        }

        return view('front.login.login', compact('lang'));

    }

    public function do_login(Request $request)
    {


        $request = $request->input();
        $request = $request["request"];
        $rule = [

            'email'    => 'required|email',
            'password' => 'required|min:8',
        ];
        //		request validator
        $validator = Validator::make($request, $rule);

        if ($validator->fails()) {

            $errors = $validator->errors();
            $errors = json_decode(json_encode($errors), true);

            return response()->json(['errors' => $errors]);

        }
//		//request validator


        $remember = false;
        if (isset($request["remember"]) && $request["remember"]) {
            $remember = true;
        }

        $password = $request['password'];


        if (Auth::attempt([
            'email'    => $request['email'],
            'password' => $password,
        ], $remember)) {

            if (Auth::user()->role == 0) {

                Auth::logout();

                return response()->json(['message' => trans('trs.email_not_verified')]);


            }


            return response()->json(['success' => true]);

        }

        return response()->json(['loginError' => trans('trs.incorrect_email_password')]);

    }

    public function logout()
    {

        Auth::logout();

        $lang = App::getLocale();

        return redirect(route('home') . ($lang != "de" ? "?lang=" . $lang : ""));

    }

    public function register()
    {

        $lang = App::getLocale();

        $country = Country::all();


        return view('front.login.register', compact('lang', 'country'));

    }

    public function do_register(UserRequest $request)
    {

        $lang = App::getLocale();

        if (Auth::check()) {
            return redirect(route('profile') . ($lang != "de" ? "?lang=" . $lang : ""));
        }


        $email = $request->input('email');
        $f_name = $request->input('user_f_name');
        $l_name = $request->input('user_l_name');
        $password = $request->input('password');
        $mobile = $request->input('country_dial_code') . $request->input('mobile');

        $user = User::where('email', $email)->first();
        //$user = json_decode( json_encode( $user ), true );

        $now = Carbon::now();
        $rand = rand(0, 1000);
        $token = bcrypt($email . $now . 'FlyOrient' . $rand);

        $token = str_replace('/', '', $token);

        if ($user) {
            //$user = $user[0];

            if ($user->role > 0) {
                return redirect()->back()->with('user_error', 'exist');
            }

            $id = $user->id;
            $user->update([
                'f_name'             => $f_name,
                'l_name'             => $l_name,
                'password'           => $password,
                'mobile'             => $mobile,
                'confirmation_token' => $token,
            ]);

        } else {

            User::create([
                'f_name'             => $f_name,
                'l_name'             => $l_name,
                'email'              => $email,
                'password'           => $password,
                'mobile'             => $mobile,
                'role'               => 0,
                'confirmation_token' => $token,
            ]);

        }

        $link = route('confirm', ['token' => $token]) . ($lang != "de" ? "?lang=" . $lang : "");

        //send mail

        Event::dispatch(new SendEmailEvent($email, new register($lang, $link)));


        $message = trans('trs.registered_successfully_activation_email_send');
        $log = true;

        return view('front.login.success_register', compact('message', 'log', 'lang'));

    }

    public function confirm($token)
    {

        $lang = App::getLocale();

        $user = User::where('confirmation_token', $token)->first();

        if (!$user) {

            $message = trans('trs.active_link_not_valid');
            $log = false;

            return view('front.login.success_register', compact('message', 'log', 'lang'));

        } else if ($user->role > 0) {

            $message = trans('trs.already_active');
            $log = false;

            return view('front.login.success_register', compact('message', 'log', 'lang'));
        }


        User::where('id', $user->id)->update(['role' => 1]);


        $message = trans('trs.confirmed_successfully');
        $log = true;

        return view('front.login.success_register', compact('message', 'log', 'lang'));

    }

    public function forgot()
    {

        $lang = App::getLocale();

        return view('front.login.forgot', compact('lang'));

    }


    public function send_reset_link(UserRequest $request)
    {

        $lang = App::getLocale();

        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $message = trans('trs.incorrect_email');

            return redirect()->route('forgot')->with('action_error', $message);

        }


        $now = Carbon::now();
        $rand = rand(0, 1000);
        $token = bcrypt($now . $email . 'FlyOrient_reset_password' . $rand);
        $token = str_replace('/', '', $token);

        $user->update(['reset_token' => $token]);

        $link = route('reset_password', ['token' => $token]) . ($lang != "de" ? "?lang=" . $lang : "");

        //send mail
        Event::dispatch(new SendEmailEvent($email, new reset($lang, $link)));

        $message = trans('trs.reset_password_link_sent');
        $log = true;

        return view('front.login.success_register', compact('message', 'log', 'lang'));

    }


    public function reset_password($token)
    {

        $lang = App::getLocale();

        $user = User::where('reset_token', $token)->first();

        if (!$user) {

            $message = trans('trs.reset_link_not_valid');
            $log = false;

            return view('front.login.success_register', compact('message', 'log', 'lang'));

        }

        $email = $user->email;

        return view('front.login.reset_password', compact('lang', 'email'));


    }

    public function do_reset(UserRequest $request)
    {

        $lang = App::getLocale();

        $email = $request->input('hide_email');
        $pass = $request->input('password');

        $user = User::where('email', $email)->first();

        if ($user instanceof User) {
            $user->update(["password" => $pass]);

            if ($request->has('us_i')) {
                return redirect(route('profile') . ($lang != "de" ? "?lang=" . $lang : ""))->with('pass_success_message', trans('trs.password_reset_message'))->with('action', 'pass');

            }

            return redirect(route('login') . ($lang != "de" ? "?lang=" . $lang : ""))->with('success_message', trans('trs.password_reset_message'));

        } else {
            if ($request->has('us_i')) {
                return redirect(route('profile') . ($lang != "de" ? "?lang=" . $lang : ""))->with('pass_error_message', trans('trs.somethings_went_wrong'))->with('action', 'pass');

            }

            return redirect(route('login') . ($lang != "de" ? "?lang=" . $lang : ""))->with('error_message', trans('trs.somethings_went_wrong'));
        }


    }


    public function update_info(Request $request)
    {

        $lang = App::getLocale();

        $id = $request->input('us_i');

        $update = [
            "mobile"   => $request->input('mobile'),
            "birthday" => date("Y/m/d", strtotime($request->input('birthday'))),
        ];

        $user = User::find($id);

        if ($user instanceof User) {

            $user->update($update);

            return redirect(route('profile') . ($lang != "de" ? "?lang=" . $lang : ""))->with('info_success_message', trans('trs.information_updated_successfully'))->with('action', 'info');
        }

        return redirect(route('profile') . ($lang != "de" ? "?lang=" . $lang : ""))->with('info_error_message', trans('trs.somethings_went_wrong'))->with('action', 'info');


    }


}

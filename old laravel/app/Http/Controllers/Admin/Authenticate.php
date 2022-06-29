<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Models\Setting;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class Authenticate extends Controller {
	public function login() {

		$lang = App::getLocale();


		if ( Auth::check() && (Auth::user()->role == User::admin || Auth::user()->role == User::staff ) ) {

			return redirect()->route( 'admin.home' ,compact('lang'));

		}

		return view( 'admin.login.login' ,compact('lang'));

	}

	public function do_login( UserRequest $request ) {
		$lang = App::getLocale();

		$remember = $request->has( 'remember' );

		$password = $request->input( 'password' );
		//hash password


		if ( Auth::attempt( [ 'email'    => $request->input( 'email' ),
		                      'password' => $password
		], $remember ) ) {
			if ( Auth::user()->role == User::staff || Auth::user()->role == User::admin ) {
				return redirect()->route( 'admin.home' );
			}

			Auth::logout();

		}

		return redirect()->back()->with( 'loginError', 'incorrect Email or password' );

	}
}

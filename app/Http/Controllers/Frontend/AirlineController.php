<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Airline;
use App\Models\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class AirlineController extends Controller {

	public function index() {


		$lang = App::getLocale();

		$airlines = Airline::where( 'agb', "!=", "" )->get();
		return view( 'front.airline.index', compact( 'airlines', 'lang' ) );

	}
	

}

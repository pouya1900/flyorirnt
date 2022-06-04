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

class HomeController extends Controller {

	public function index() {
		$lang = App::getLocale();

//		$ir_airport=\Illuminate\Support\Facades\Config::get("ir_air");

		$airlines = Airline::slide_airline();

		$cip          = \Illuminate\Support\Facades\Config::get( "cip" );
		$cip_airports = $cip["airports"];

		$posts = Post::where( 'home_page', '=', 1 )->limit( 4 )->get();
		$posts = json_decode( json_encode( $posts ), true );

		return view( 'front.home.index', compact( 'airlines', 'cip_airports', 'lang', 'posts' ) );


	}

	public function auto_complete( Request $request ) {

		$data = $request->data;
		$sec  = $request->sec;
		$lang = $request->lang;


		$airports = Airport::airport_search( $data );


		return view( 'front.home.search_result', compact( 'airports', 'sec', 'lang' ) );
	}

	public function search( Request $request ) {

		$lang = App::getLocale();


		$origin      = request()->input( 'origin' );
		$destination = request()->input( 'destination' );

		$x = strripos( $origin, '(' );
		$x ++;
		$origin_code = substr( $origin, $x, 3 );
		$x           = strripos( $destination, '(' );
		$x ++;
		$destination_code = substr( $destination, $x, 3 );


		$data = [
			'origin'      => $origin_code,
			'destination' => $destination_code,
			'class'       => request()->input( 'flight_class' ),
			'adl'         => request()->input( 'adl' ),
			'chl'         => request()->input( 'chl' ),
			'inf'         => request()->input( 'inf' ),
		];

		if ( request()->input( 'daterange_d' ) ) {

			$data['depart'] = request()->input( 'daterange_d' );
			$data['return'] = request()->input( 'daterange_r' );
		} else {
			$data['depart'] = request()->input( 'date' );
			$data['return'] = "-";
		}
		if ( request()->input( 'stop_q' ) && request()->input( 'stop_q' ) == 'on' ) {
			$data['none_stop'] = 1;
		}

		$link = route( 'flights', $data );
		if ( $lang != "de" ) {
			$link .= "?lang=" . $lang;
		}

		return redirect( $link );

	}

}


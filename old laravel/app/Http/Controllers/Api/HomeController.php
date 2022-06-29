<?php

namespace App\Http\Controllers\Api;

use App\Models\Airline;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\Post;
use ClassPreloader\Config;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\AirlineResource;
use App\Http\Resources\PostResource;
use Carbon\Carbon;

class HomeController extends Controller {

	protected $request;


	public function __construct( Request $request ) {
		$this->request = $request;

	}

	public function index() {

		$lang = $this->request->lang;

//		$ir_airport=\Illuminate\Support\Facades\Config::get("ir_air");

		$airlines = Airline::slide_airline();

		$posts = Post::where( 'home_page', '=', 1 )->limit( 4 )->get();

		return $this->sendResponse( [

			'airlines' => AirlineResource::collection( $airlines ),
			'posts'    => PostResource::collection( $posts ),
			'lang'     => $lang
		] );

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


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Airline extends Model
{
	protected $primaryKey = 'code';

	protected $guarded = ['code'];

	public $incrementing = false;

	public static function slide_airline() {

		return DB::select("select * from airlines where status=1 ");
	}

	public static function filter_airline($search_id) {

		return DB::select("SELECT  airlines.*,costs.TotalFare FROM (`airlines` INNER JOIN flights ON airlines.code=flights.ValidatingAirlineCode AND flights.search_id='$search_id' INNER JOIN costs ON flights.id=costs.flight_id) WHERE 1 GROUP BY airlines.code HAVING MIN(costs.TotalFare) order by name");

	}

	public static function filter_airline_list($search_id) {

		return DB::select("SELECT  airlines.*,costs.*,flights.stops,flights.return_stops,flights.depart_time FROM (`airlines` INNER JOIN flights ON airlines.code=flights.ValidatingAirlineCode AND flights.search_id='$search_id' AND (flights.stops=flights.return_stops OR flights.return_stops IS NULL) INNER JOIN costs ON flights.id=costs.flight_id) WHERE 1 GROUP BY airlines.code , flights.stops HAVING MIN(costs.TotalFare) order by name");

	}

	public function flights() {

		return $this->belongsToMany(Flight::class,"flight_airline","airline_code","flight_id")->withPivot('is_return');

	}

	public function legs() {

		return $this->hasMany(Leg::class,'leg_airline_code','leg_id');
	}

	public function cip_books() {

		return $this->hasMany(Cip_book::class,'airline_code','id');
	}

	public static function airline_search( $data ) {

		$search = $data . "%";

		return DB::select( "select * from airlines where code like '$search' OR name like '$search'  order by id asc " );
	}

}

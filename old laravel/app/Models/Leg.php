<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leg extends Model
{
	protected $primaryKey = 'leg_id';

	protected $guarded = ['leg_id'];

	public function flights() {

		return $this->belongsTo(Flight::class,"flight_id","leg_id");

	}

	public function airports1() {

		return $this->belongsTo(Airport::class,'leg_depart_airport','code');

	}

	public function airports2() {

		return $this->belongsTo(Airport::class,'leg_arrival_airport','code');

	}

	public function airlines() {

		return $this->belongsTo(Airline::class,'leg_airline_code','code');


	}

}

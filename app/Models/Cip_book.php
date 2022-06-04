<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Cip_book extends Model
{
	protected $primaryKey = 'id';

	protected $guarded = ['id'];

	public function cip_passengers() {

		return $this->hasMany(Cip_passenger::class,"cip_book_id","id");

	}

	public function cip_services() {

		return $this->hasMany(Cip_service::class,"cip_book_id","id");

	}

	public function users() {

		return $this->belongsTo(User::class,'user_id','id');

	}

	public function cip_payments() {

		return $this->hasMany(Cip_payment::class,"cip_book_id","id");

	}

	public function airlines() {

		return $this->belongsTo(Airline::class,'airline_code','code');

	}

	public function airports() {

		return $this->belongsTo(Airport::class,'front_airport','code');

	}

}

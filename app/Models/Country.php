<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
	protected $primaryKey = 'code';

	protected $guarded = ['code'];

	public $incrementing = false;

	public function passengers() {

		return $this->hasMany(Passenger::class,"country","code");

	}
	public function cip_passengers() {

		return $this->hasMany(Cip_passenger::class,"country","code");

	}

	public function users() {

		return $this->hasMany(User::class,"country","code");

	}
}

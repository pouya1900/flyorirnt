<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
	protected $primaryKey = 'cost_id';

	protected $guarded = ['cost_id'];

	public function flights() {

		return $this->belongsTo(Flight::class,"flight_id","cost_id");

	}
}

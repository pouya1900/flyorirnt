<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	protected $primaryKey = 'id';

	protected $guarded = ['id'];


	const parto=1;
	const amadeus=2;
	const parto_demo=3;
	const iranAir=4;
	const iranAir_demo=5;

}

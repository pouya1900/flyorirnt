<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Airport extends Model
{
    protected $primaryKey = 'code';

    protected $guarded = ['code'];

    public $incrementing = false;

    public static function airport_search($data)
    {

        $search = $data . "%";

        return DB::select("select * from airports where code like '$search' OR name like '$search' OR city_en like '$search' OR city_de like '$search' OR city_fa like '$search' order by id asc ");
    }

    public function flights()
    {

        //return $this->hasOne(Flight::class,'depart_airport','id');

    }

    public function legs()
    {


    }

    public function childAirports()
    {
        return $this->hasMany(Airport::class, 'city_id','id');
    }

}

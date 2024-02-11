<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Flight extends Model
{
    protected $primaryKey = 'id';

    protected $guarded = ['id'];


    const parto = 1;
    const amadeus = 2;

    public static function my_insert($query)
    {


        $return = DB::transaction(function () use ($query) {


            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            DB::insert($query);

            $id = DB::select("SELECT LAST_INSERT_ID();");

            $return = json_decode(json_encode($id), true);

            $id = $return[0]["LAST_INSERT_ID()"];

//            DB::update("UPDATE flights set token=md5(id) where id >= $id");

            return $id;

        });


        return $return;
    }


    public function costs()
    {

        return $this->hasOne(Cost::class, "flight_id", "id");

    }

    public function taxes()
    {

        return $this->hasMany(Tax::class, "flight_id", "id");

    }

    public function legs()
    {

        return $this->hasMany(Leg::class, "flight_id", "id");

    }


    public function airlines()
    {

        return $this->belongsToMany(Airline::class, "flight_airline", "flight_id", "airline_code")->withPivot('is_return');

    }

    public function airports1()
    {

        return $this->belongsTo(Airport::class, 'depart_airport', 'code');

    }

    public function airports2()
    {

        return $this->belongsTo(Airport::class, 'arrival_airport', 'code');

    }

    public function airports3()
    {

        return $this->belongsTo(Airport::class, 'return_depart_airport', 'code');

    }

    public function airports4()
    {

        return $this->belongsTo(Airport::class, 'return_arrival_airport', 'code');

    }

    public function books()
    {

        return $this->hasMany(Book::class, 'flight_id', 'id');

    }

    public function searches()
    {

        return $this->belongsTo(Search::class, "search_id", "id");

    }

    public function multi_flights()
    {
        return $this->hasMany(Flight::class, 'multi_flight_id');
    }

    public function multi_parent()
    {
        return $this->belongsTo(Flight::class, 'multi_flight_id');
    }

}

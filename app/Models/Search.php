<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\This;
use App\User;

class Search extends Model
{

    protected $primaryKey = 'id';

    protected $guarded = ['id'];


    public function flights()
    {

        return $this->hasMany(Flight::class, "search_id", "id");

    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }


    public static function new_search()
    {


//		$return=DB::transaction(function () {
//
//
//			DB::statement('SET FOREIGN_KEY_CHECKS=0');
//
//			DB::insert("INSERT INTO searches(link,origin_code,destination_code,origin_name,destination_name) VALUES ('','','','','')");
//
//			$id=DB::select("SELECT LAST_INSERT_ID();");
//
//			return $id;
//
//		});
//
//		$return=json_decode(json_encode($return),true);
//
//		return $return[0]["LAST_INSERT_ID()"];


//		$this->


    }


}

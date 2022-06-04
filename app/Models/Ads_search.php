<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ads_search extends Model
{

    protected $guarded = ['id'];


    public function airport()
    {
        return $this->belongsTo(Airport::class, "origin", 'code');
    }

}

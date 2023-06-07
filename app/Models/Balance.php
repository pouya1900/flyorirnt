<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Balance extends Model
{

    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany(User::class, 'balance_id');
    }

}

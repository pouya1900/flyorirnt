<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    public function passengers()
    {

        return $this->hasMany(Passenger::class, "book_id", "id");

    }

    public function users()
    {

        return $this->belongsTo(User::class, 'user_id', 'id');

    }

    public function flights()
    {

        return $this->belongsTo(Flight::class, 'flight_id', 'id');

    }

    public function payments()
    {

        return $this->hasOne(Payment::class, "book_id", "id");

    }

    public function scheduler()
    {
        return $this->hasOne(Scheduler::class, 'book_id');
    }

}

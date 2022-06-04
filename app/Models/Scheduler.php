<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scheduler extends Model
{
    protected $guarded = ['id'];

    public function book()
    {
        return $this->belongsTo(Book::class, "book_id");
    }

}

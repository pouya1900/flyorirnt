<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment_scheduler extends Model
{
    protected $guarded = ['id'];

    public function payment()
    {
        return $this->belongsTo(Payment::class, "payment_id");
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	protected $primaryKey = 'id';

	protected $guarded = ['id'];

	public function books() {

		return $this->belongsTo(Book::class,'book_id','id');

	}

}

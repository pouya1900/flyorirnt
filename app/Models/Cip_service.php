<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cip_service extends Model
{
	protected $primaryKey = 'id';

	protected $guarded = ['id'];


	public function cip_books() {

		return $this->belongsTo(Cip_book::class,"cip_book_id","id");

	}

}

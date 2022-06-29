<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

	protected $primaryKey = 'id';

	protected $guarded = ['id'];


	public function comments() {

		return $this->hasMany(Comment::class,"post_id","id");

	}


	public function getTitleAttribute() {

	}

	public function getContentAttribute() {

	}


}

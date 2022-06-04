<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

	protected $primaryKey = 'id';

	protected $guarded = ['id'];


	public function posts() {

		return $this->belongsTo(Post::class,"post_id","id");

	}

}

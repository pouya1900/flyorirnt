<?php

namespace App;

use App\Models\Book;
use App\Models\Cip_book;
use App\Models\Country;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    const guest=0;
    const user=1;
    const staff=2;
    const admin=3;


    protected $hidden = [
	    'password', 'remember_token',
    ];

	protected $guarded = ['role'];


	public function setPasswordAttribute($value) {

		$this->attributes['password'] = bcrypt($value);

	}

	public function books() {

		return $this->hasMany(Book::class,'user_id','id');

    }

	public function cip_books() {

		return $this->hasMany(Cip_book::class,'user_id','id');

	}

	public function countries() {

		return $this->belongsTo(Country::class,"country","code");

	}

}

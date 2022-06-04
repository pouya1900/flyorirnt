<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;

class UserRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */


	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		$rules= [
			'email'       => 'required|email',
			'password'    => 'required|min:8'
		];

		if (\Illuminate\Support\Facades\Route::currentRouteName()=='do_register')
		{

			$rules['password']='required|confirmed|min:8';
			$rules['user_f_name']='required';
			$rules['user_l_name']='required';

		}

		if (\Illuminate\Support\Facades\Route::currentRouteName()=='send_reset_link')
		{
			unset($rules['password']);
		}

		if (\Illuminate\Support\Facades\Route::currentRouteName()=='do_reset')
		{
			unset($rules['email']);
			$rules['password']='required|confirmed|min:8';
		}
		return $rules;
	}
}

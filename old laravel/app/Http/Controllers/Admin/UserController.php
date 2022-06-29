<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Country;

class UserController extends Controller {
	public function users() {

		$users = User::all();

		return view( 'admin.user.index', compact( 'users' ) );

	}


	public function edit( User $user ) {
		$country=Country::all();
		return view( 'admin.user.edit', compact( 'user','country' ) );

	}


	public function update( User $user, UpdateUserRequest $request ) {

		unset($request["submit"]);
		
		$user->update($request->all());


		return redirect()->route( 'admin.users' )->with( 'message', 'user updated successfully' );

	}

	public function delete( Request $request ) {

		$id = $request->id;

		$user = User::find( $id );

		if ( $user instanceof User ) {
			$user->delete();

			return redirect()->route( 'admin.users' )->with( 'message', 'user deleted successfully' );
		} else {
			return redirect()->route( 'admin.users' )->with( 'message', 'user not found' );
		}


	}

}

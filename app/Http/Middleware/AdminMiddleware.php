<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 *
	 * @return mixed
	 */
	public function handle( $request, Closure $next ) {

		if ( ! Auth::check() || (Auth::user()->role != User::admin && Auth::user()->role != User::staff )) {

			return redirect()->route( 'admin.login' );

		}

		return $next( $request );
	}
}

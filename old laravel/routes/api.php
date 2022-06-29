<?php

Route::group( [ 'prefix' => '/auth' ], function () {
	Route::post( 'login', 'AuthController@login' );

	Route::group( [ 'middleware' => 'jwtAuth' ], function () {
		Route::get( 'logout', 'AuthController@logout' );
	} );
} );

Route::group( [ 'middleware' => [ 'jwtAuth' ] ], function () {
	Route::group( [ 'prefix' => '/profile' ], function () {
		Route::get( '/', 'UsersController@showProfile' );
		Route::put( '/', 'UsersController@updateProfile' );
		Route::post( '/', 'UsersController@createProfile' );
	} );
} );


Route::group( [ 'prefix' => '/home' ], function () {

	Route::get( '/', 'HomeController@index' );
} );



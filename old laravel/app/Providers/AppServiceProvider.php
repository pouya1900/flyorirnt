<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    	$request=Request::capture();

    	$lang=$request->has('lang') ? $request->lang : 'de';

    	app()->setLocale($lang);
	    date_default_timezone_set("Europe/Berlin");
	    View::share( 'lang', $lang );

	    $setting = Setting::find( 1 );

	    View::share( 'setting', $setting );

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

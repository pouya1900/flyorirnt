<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\Renders\amadeus;
use App\Services\Renders\iranAir;
use App\Services\Renders\parto;
use App\Services\Renders\Render;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {

    }

    public function set_render($render_number)
    {
        if ($render_number == Setting::parto) {
            $instance_render = new Render(new parto(Setting::parto));
        } elseif ($render_number == Setting::parto_demo) {
            $instance_render = new Render(new parto(Setting::parto_demo));
        } elseif ($render_number == Setting::amadeus) {
            $instance_render = new Render(new amadeus());
        } elseif ($render_number == Setting::iranAir) {
            $instance_render = new Render(new iranAir(Setting::iranAir));
        } elseif ($render_number == Setting::iranAir_demo) {
            $instance_render = new Render(new iranAir(Setting::iranAir_demo));
        }

        return $instance_render;
    }

    public function set_book_render($render_number)
    {
        if ($render_number == Setting::parto_demo) {
            $instance_render = new Render(new parto(Setting::parto_demo));
        } elseif ($render_number == Setting::amadeus) {
            $instance_render = new Render(new amadeus());
        } elseif ($render_number == Setting::parto) {
            $instance_render = new Render(new parto(Setting::parto));
        } elseif ($render_number == Setting::iranAir) {
            $instance_render = new Render(new iranAir(Setting::iranAir));
        } elseif ($render_number == Setting::iranAir_demo) {
            $instance_render = new Render(new iranAir(Setting::iranAir_demo));
        }

        return $instance_render;
    }

    public function make_mobile_without_zero($mobile)
    {
        while (true) {
            $first = substr($mobile, 0, 1);
            if ($first || $mobile == "") break;
            $mobile = substr($mobile, 1);
        }
        return $mobile;
    }

}

<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\xmlFile\Irr;
use App\Services\Renders\Render;
use App\Services\Renders\iranAir;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\register;
use App\Models\Book;
use App\Models\Payment_scheduler;
use App\Services\Payments\paypal;

class TestController extends Controller
{


    public function test()
    {

        return view('front.test.test');
    }
}

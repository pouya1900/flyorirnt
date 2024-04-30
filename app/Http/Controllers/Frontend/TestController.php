<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\xmlFile\Irr;
use App\Services\Renders\Render;
use App\Services\Renders\parto;
use App\Services\Renders\iranAir;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\register;
use App\Models\Book;
use App\Models\Flight;
use App\Models\Payment_scheduler;
use App\Services\Payments\paypal;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{


    public function test()
    {
        $lang="en";
        return view('front.test.test', compact('lang', ));


    }
}

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
        $paypal = new paypal();

        $result = $paypal->order("7ST52883HR1709012");

        dd($result);

        $payment_scheduler = Payment_scheduler::create(["payment_id" => "194"]);

    }
}

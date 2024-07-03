<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Payment;
use App\Services\MyHelperFunction;
use Carbon\Carbon;
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
        require_once "script/xinvoice.php";

        $xinvoice2 = new \Xinvoice();

        $book = Book::find(992);
        $lang = "de";
        $invoice_number = "KHB-240017";
        $invoice_view = view('front.invoice.agency_invoice', compact('book', 'lang', 'invoice_number'))->render();


        $file_name = 'KHB-240017.pdf';
        $xinvoice2->setSettings("filename", "../../../../../../public/invoices/$file_name");
        $xinvoice2->setSettings("output", "F");
        $xinvoice2->setSettings("format", "A4");
        $xinvoice2->htmlToPDF($invoice_view);


    }
}

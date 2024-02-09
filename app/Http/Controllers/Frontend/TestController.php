<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Payment;
use App\Models\Tax;
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
use App\Jobs\deleteFlight;

class TestController extends Controller
{


    public function test()
    {
        $paypal = new paypal();

        $result = $paypal->capture_payment("3FL42240471627232");
        dd($result);

//        Flight::where("id", ">=", 1361227)
//            ->where("id", "<=", 18693125)
//            ->whereDoesntHave("books")
//            ->delete();


//        require_once "script/xinvoice.php";
//
//        $xinvoice2 = new \Xinvoice();
//        $book = Book::find(620);
//        $this_year = Carbon::now()->year;
//        $this_year = $this_year % 100;
//        $invoice_number = $book->users->code . '-' . $this_year . "0006";
//
//        $lang = "en";
//
//        $invoice_view = view('front.invoice.agency_invoice', compact('book', 'lang', 'invoice_number'))->render();
//
//        $file_name = $invoice_number . '.pdf';
//        $xinvoice2->setSettings("filename", "../../../../../../public/invoices/$file_name");
//        $xinvoice2->setSettings("output", "F");
//        $xinvoice2->setSettings("format", "A4");
//        $xinvoice2->htmlToPDF($invoice_view);
//
//        return $invoice_view;


//        for ($i = 86; $i < 2247; $i++) {
//            deleteFlight::dispatch($i)->onQueue('delete');
//        }

    }
}

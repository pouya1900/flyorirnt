<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Mail\reset;
use App\Mail\ticket;
use App\Events\SendEmailEvent;
use App\Mail\ticket_sup;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;


class TestController extends Controller
{


    public function test()
    {

        Event::dispatch(new SendEmailEvent("info@flyorient.de", new reset("en", "https://flyorient.de/test")));


//        $to = "info@flyorient.de";
//
//        $subject = "Subject of the Email";
//        $message = "Hello, this is a test email from php mail in flyorient.de";
//        $headers = "From: booking@flyorient.de";
//
//        if (mail($to, $subject, $message, $headers)) {
//            echo "Email sent successfully! ".$headers;
//        } else {
//            echo "Email sending failed.";
//        }

//        $a=Mail::raw('This is a test email', function ($message) {
//            $message->to('poyyarahvar@gmail.com')
//                ->subject('Test Email')
//                ->from('booking@flyorient.de');
//        });
//
//        dd($a);

//        require_once "script/xinvoice.php";
//
//        $xinvoice2 = new \Xinvoice();
//
//        $book = Book::find(992);
//        $lang = "de";
//        $invoice_number = "KHB-240017";
//        $invoice_view = view('front.invoice.agency_invoice', compact('book', 'lang', 'invoice_number'))->render();
//
//
//        $file_name = 'KHB-240017.pdf';
//        $xinvoice2->setSettings("filename", "../../../../../../public/invoices/$file_name");
//        $xinvoice2->setSettings("output", "F");
//        $xinvoice2->setSettings("format", "A4");
//        $xinvoice2->htmlToPDF($invoice_view);


    }
}

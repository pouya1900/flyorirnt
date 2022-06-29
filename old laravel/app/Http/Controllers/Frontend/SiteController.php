<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\MessageRequest;
use App\Http\Requests\UserRequest;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class SiteController extends Controller
{

    public function contact()
    {

        $lang = App::getLocale();

        $page = Page::where('name', 'contact')->first();

        $text_lang = "text_" . $lang;

        $text = $page->$text_lang;
        $rtl_ignore = $page->rtl_ignore;


        return view('front.site.contact', compact('text', 'lang', 'rtl_ignore'));

    }

    public function send_message(MessageRequest $message_request)
    {

        $setting = Setting::find(1);

        $name = $message_request->input('full_name');
        $email = $message_request->input('email');
        $phone = $message_request->input('phone');
        $subject = $message_request->input('subject');
        $contact_content = $message_request->input('contact_content');
        $lang = $message_request->input('lang');

        $to = $setting->email;
        $message = 'FROM: ' . $name . '<br>' . 'Email: ' . $email . '<br>' . 'Phone Number:' . $phone . '<br>' . 'Message: ' . $contact_content;
        $headers = "Content-Type: text/html; charset=UTF-8";

        $lan_data = [];
        if ($lang != "de") {
            $lan_data = ["lang" => $lang];
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            mail($to, $subject, $message, $headers);
            return redirect()->route('contact', $lan_data)->with('message', 'your message successfully sent');
        } else {
            return redirect()->route('contact', $lan_data)->with('error', 'Invalid Email, please provide an correct email.');

        }

    }

    public function AGB()
    {
        $lang = App::getLocale();

        $page = Page::where('name', 'AGB')->first();

        $text_lang = "text_" . $lang;

        $text = $page->$text_lang;

        $rtl_ignore = $page->rtl_ignore;

        return view('front.site.AGB', compact('lang', 'text', 'rtl_ignore'));

    }

    public function about_us()
    {

        $lang = App::getLocale();

        $page = Page::where('name', 'about_us')->first();

        $text_lang = "text_" . $lang;

        $text = $page->$text_lang;
        $rtl_ignore = $page->rtl_ignore;


        return view('front.site.about_us', compact('lang', 'text', 'rtl_ignore'));

    }

    public function faqs()
    {

        $lang = App::getLocale();

        $faqs = Faq::where("status", '1')->get();


        return view('front.site.faq', compact('lang', 'faqs'));

    }

    public function privacy()
    {

        $lang = App::getLocale();

        $page = Page::where('name', 'privacy')->first();

        $text_lang = "text_" . $lang;

        $text = $page->$text_lang;
        $rtl_ignore = $page->rtl_ignore;

        return view('front.site.privacy', compact('lang', 'text', 'rtl_ignore'));

    }

    public function imprint()
    {

        $lang = App::getLocale();

        $page = Page::where('name', 'imprint')->first();

        $text_lang = "text_" . $lang;

        $text = $page->$text_lang;
        $rtl_ignore = $page->rtl_ignore;

        return view('front.site.imprint', compact('lang', 'text', 'rtl_ignore'));

    }


}

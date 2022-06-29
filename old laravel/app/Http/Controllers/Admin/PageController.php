<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index()
    {
        $pages["about_us"] = Page::where('name', 'about_us')->first();
        $pages["privacy"] = Page::where('name', 'privacy')->first();
        $pages["AGB"] = Page::where('name', 'AGB')->first();
        $pages["imprint"] = Page::where('name', 'imprint')->first();
        $pages["cip"] = Page::where('name', 'cip')->first();
        $pages["condition"] = Page::where('name', 'condition')->first();
        $pages["contact"] = Page::where('name', 'contact')->first();

        return view('admin.pages.pages', compact('pages'));
    }


    public function store(Request $request)
    {

        $res = 0;

        $id = $request->input('id');
        $text_en = $request->input('text_en');
        $text_de = $request->input('text_de');
        $text_fa = $request->input('text_fa');
        $text_ru = $request->input('text_ru');
        $rtl_ignore = $request->input('rtl_ignore');

        $page = Page::find($id);

        if (!$page) {
            return redirect()->route('admin.pages')->with('error', 'error ! try again please');
        }

        $page->update([
            "text_en"    => $text_en,
            "text_de"    => $text_de,
            "text_fa"    => $text_fa,
            "text_ru"    => $text_ru,
            "rtl_ignore" => $rtl_ignore ? 1 : 0,
        ]);

        return redirect()->route('admin.pages')->with('success', 'Your changes have been made successfully');


    }


}

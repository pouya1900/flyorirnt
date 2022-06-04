<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cip_book;
use App\Models\Setting;
use App\Models\Session;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class CipController extends Controller
{

    public function tickets()
    {
        $books = Cip_book::where("status", "!=", "booking")->orderBy('updated_at', 'desc')->get();
        return view('admin.cip.index', compact('books'));
    }

    public function booked_tickets()
    {
        $books = Cip_book::where("status", "=", "booked")->orderBy('updated_at', 'desc')->get();
        return view('admin.cip.index', compact('books'));
    }

    public function bookings()
    {
        $books = Cip_book::where("status", "=", "booking")->orderBy('updated_at', 'desc')->get();
        return view('admin.cip.index', compact('books'));
    }

    public function search_ticket_result($id)
    {
        app()->setLocale("en");
        $lang = App::getLocale();

        $book = Cip_book::find($id);


//		get cip service detail
        $cip_airport = $book->cip_airport;
        $cip_service_type = $book->service;
        $type = $book->tripe_type;
        $dir = $book->flight_type;

        $host = [];
        $transfer = [];
        $extra = [];
        foreach ($book->cip_services as $cip_service) {

            if ($cip_service->type == "host") {
                $host[] = $cip_service;
            } else if ($cip_service->type == "transfer") {
                $transfer[] = $cip_service;
            } else if ($cip_service->type == "extra") {
                $extra[] = $cip_service;
            }
        }

        if ($book) {
            $user_id = $book->user_id;

            $user = User::find($user_id);
            $user->cip_books = [$book];


            return view('admin.cip.search_user_result', compact('user', 'book', 'dir', 'type', 'host', 'transfer', 'extra', 'lang'));
        }

    }

    public function update(Request $request, $id)
    {
        $ticket_number = $request->ticket_number;

        $book = Cip_book::find($id);

        if (!$book) {
            return redirect()->back()->withErrors("not found");
        }

        $book->update(["ticket_number" => $ticket_number]);

        return redirect()->route("admin.cip_search_ticket_result", ["id" => $id])->with(["message" => "changes made successfully"]);
    }


}

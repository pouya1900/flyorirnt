<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\Setting;
use App\Models\Session;
use App\Models\Search;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class AnalyzeController extends Controller
{
    public $g = 1;
    public $origin = 0;
    public $destination = 0;

    public function search(Request $request)
    {
        $ori = $request->origin_search;
        $des = $request->destination_search;

        $searches = Search::select('*', DB::raw('count(*) as total'))
            ->where('link', "!=", "")
            ->when($request->has("origin"), function ($q) {
                $this->g = 0;
                $this->origin = 1;
                return $q->groupBy('origin_code');
            })
            ->when($request->has("destination"), function ($q) {
                $this->g = 0;
                $this->destination = 1;
                return $q->groupBy('destination_code');
            })
            ->when($ori, function ($q) use ($ori) {
                return $q->where('origin_code', $ori);
            })
            ->when($des, function ($q) use ($des) {
                return $q->where('destination_code', $des);
            })
            ->when($this->g, function ($q) {
                return $q->groupBy('id');
            })
            ->get();

        $origin_g = $this->origin;
        $destination_g = $this->destination;

        return view('admin.analyze.index', compact('searches', 'origin_g', 'destination_g'));

    }

}

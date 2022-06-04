<?php

namespace App\Http\Controllers\Api;

use App\Models\Airline;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\Post;
use ClassPreloader\Config;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\AirlineResource;
use App\Http\Resources\PostResource;
use Carbon\Carbon;

class FlightController extends Controller {

    protected $request;


    public function __construct( Request $request ) {
        $this->request = $request;

    }


    

}


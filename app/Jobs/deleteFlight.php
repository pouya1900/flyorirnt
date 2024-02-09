<?php

namespace App\Jobs;

use App\Models\Tax;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Ads_search;
use App\Models\Flight;
use App\Models\Setting;
use function Sodium\add;
use App\Services\Renders\iranAir;
use App\Services\Renders\Render;

class deleteFlight implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//    public $queue = 'search';


    public $counter;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($counter)
    {
        $this->onQueue('delete');
        $this->counter = $counter;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $start = $this->counter * 10000;
        $end = ($this->counter + 1) * 10000;

        Tax::where("id", ">=", $start)
            ->where("id", "<=", $end)
            ->whereDoesntHave("flights")
            ->delete();

//        $x = Flight::where("id", ">=", $start)
//            ->where("id", "<=", $end)
//            ->whereDoesntHave("books")
//            ->delete();
//        dd($x);

    }
}

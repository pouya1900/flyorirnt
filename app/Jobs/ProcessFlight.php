<?php

namespace App\Jobs;

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

class ProcessFlight implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//    public $queue = 'search';


    public $airport;
    public $depart;
    public $return;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($airport, $depart, $return)
    {
        $this->onQueue('search');
        $this->airport = $airport;
        $this->depart = $depart;
        $this->return = $return;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $instance_render = new Render(new iranAir(Setting::iranAir));


            $response = $instance_render->lowfaresearch($this->airport, "IKA", date('Y-m-d', strtotime($this->depart)), date('Y-m-d', strtotime($this->return)), "economy", 1, 0, 0, 0);

            $ads_search = Ads_search::where("origin", $this->airport)->where("month", $this->depart->month)->first();

            $flights = $response["flights"];

            if (is_array($flights) && count($flights)) {
                $flight = $flights[0];
            } else {
                return;
            }

            $data = [
                'origin'      => $this->airport,
                'destination' => "IKA",
                'class'       => 'economy',
                'adl'         => 1,
                'chl'         => 0,
                'inf'         => 0,
                'depart'      => date('d.m.Y', strtotime($flight["depart_time"])),
                'return'      => date('d.m.Y', strtotime($flight["return_depart_time"])),
                'none_stop'   => 0,
            ];

            if ($ads_search) {
                if ($ads_search->price > $flight["TotalFare"]) {
                    $ads_search->update([
                        "depart"      => $flight["depart_time"],
                        "return"      => $flight["return_depart_time"],
                        "search_link" => route('flights', $data),
                        "price"       => $flight["TotalFare"],
                    ]);
                }
            } else {
                Ads_search::create([
                    "origin"      => $this->airport,
                    "destination" => "IKA",
                    "depart"      => $flight["depart_time"],
                    "return"      => $flight["return_depart_time"],
                    "month"       => $this->depart->month,
                    "search_link" => route('flights', $data),
                    "price"       => $flight["TotalFare"],
                ]);
            }
        } catch (\Exception $e) {
        }

    }
}

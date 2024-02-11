<?php


namespace App\Services\Renders;


interface render_interface
{


    public function __construct($code);

    public function redirect_lowfaresearch($flight_id);

    public function lowfaresearch($origin, $destination, $depart, $return, $class, $adl, $chl, $inf, $none_stop, $search_id);

    public function lowfaresearchMulti($origin, $destination, $depart, $origin2, $destination2, $depart2, $class, $adl, $chl, $inf, $none_stop, $search_id, $origin3, $destination3, $depart3, $origin4, $destination4, $depart4);

    public function revalidate($flight);

    public function book($flight, $payment);

    public function update_booking_status($book, $book_unique_id);

    public function airrules($flight);

    public function getCondition();

    public function bag($flight);
}

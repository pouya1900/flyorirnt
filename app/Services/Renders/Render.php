<?php


namespace App\Services\Renders;


class Render
{

    public $render;

    public function __construct(render_interface $render)
    {
        $this->render = $render;
    }

    public function lowfaresearch($origin, $destination, $depart, $return, $class, $adl, $chl, $inf, $none_stop = 0, $search_id = 0)
    {
        return $this->render->lowfaresearch($origin, $destination, $depart, $return, $class, $adl, $chl, $inf, $none_stop, $search_id);
    }

    public function lowfaresearchMulti($origin, $destination, $depart, $origin2, $destination2, $depart2, $class, $adl, $chl, $inf, $none_stop, $search_id, $origin3, $destination3, $depart3, $origin4, $destination4, $depart4)
    {
        return $this->render->lowfaresearchMulti($origin, $destination, $depart, $origin2, $destination2, $depart2, $class, $adl, $chl, $inf, $none_stop, $search_id, $origin3, $destination3, $depart3, $origin4, $destination4, $depart4);
    }

    public function revalidate($flight)
    {
        return $this->render->revalidate($flight);
    }

    public function book($flight, $payment)
    {
        return $this->render->book($flight, $payment);
    }


    public function update_booking_status($book, $book_unique_id)
    {
        return $this->render->update_booking_status($book, $book_unique_id);
    }

    public function airrules($flight)
    {
        return $this->render->airrules($flight);
    }

    public function getCondition()
    {
        return $this->render->getCondition();
    }


    public function bag($flight)
    {
        return $this->render->bag($flight);
    }

}

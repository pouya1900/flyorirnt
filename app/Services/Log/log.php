<?php


namespace App\Services\Log;


class log
{

    public function save($data)
    {

        header("Content-type: application/json; charset=utf-8");


        $filename = "log.txt";

        $myfile = fopen($filename, "w");
        fwrite($myfile, $data);
//		fwrite( $myfile,  $data['text'] );

//		fwrite( $myfile, "<br>" . "------------------------" . "<br><br>" );

        fclose($myfile);

    }

    public function api_error($req, $res, $service, $flight)
    {
        header("Content-type: application/json; charset=utf-8");


        $filename = "webServiceErrors.txt";

        $text = date("H:i Y-m-d", strtotime('now')) . " : \n"
            . "service : " . $service . "\n"
            . "flight : " . $flight["flight_number"] . "....." . $flight["depart_airport"] . "->" . $flight["arrival_airport"] . "......" . $flight["depart_time"] . "->" . $flight["arrival_time"] . "\n";

        if ($flight["DirectionInd"] == 2) {
            $text .= "return :" . $flight["return_depart_airport"] . "->" . $flight["return_arrival_airport"] . "......" . $flight["return_depart_time"] . "->" . $flight["return_arrival_time"] . "\n";
        }

        $text .= "request : \n" . $req . "\n"
            . "response : \n" . $res . "\n"
            . "--------------------------------------\n--------------------------------------\n--------------------------------------\n";

        $my_file = fopen($filename, "a");
        fwrite($my_file, $text);

        fclose($my_file);
    }

    public function payment_error($res, $service, $payment = null)
    {
        header("Content-type: application/json; charset=utf-8");


        $filename = "paymentServiceError.txt";

        $text = date("H:i Y-m-d", strtotime('now')) . " : \n"
            . "service : " . $service . "\n"
            . "payment : " . $payment->id . "\n";


        $text .= "response : \n" . $res . "\n"
            . "--------------------------------------\n--------------------------------------\n--------------------------------------\n";

        $my_file = fopen($filename, "a");
        fwrite($my_file, $text);

        fclose($my_file);

    }

}
<?php

//sunday : 0
//monday : 1
//thursday  : 2
//wednesday : 3
//tuesday : 4
//friday : 5
//saturday : 6

$array = [
    [
        "airport" => "FRA",  //Frankfurt
        "depart"  => [3, 6],
        "return"  => [3, 6],
    ],
    [
        "airport" => "HAM",  //Hamburg
        "depart"  => [1, 4],
        "return"  => [1, 4],
    ],
    [
        "airport" => "CGN",  //Köln
        "depart"  => [2,5],
        "return"  => [2,5],
    ],
    [
        "airport" => "VIE",  //Wien
        "depart"  => [6],
        "return"  => [6],
    ],
    [
        "airport" => "CDG",  //Paris
        "depart"  => [2,5],
        "return"  => [2,5],
    ],
    [
        "airport" => "LHR",  //London
        "depart"  => [2,4,0],
        "return"  => [2,4,0],
    ],

];

return $array;


?>

<?php

//monday : 0
//thursday  : 1
//wednesday : 2
//tuesday : 3
//friday : 4
//saturday : 5
//sunday : 6

$array = [
    [
        "airport" => "FRA",  //Frankfurt
        "depart"  => [2, 5],
        "return"  => [2, 5],
    ],
    [
        "airport" => "HAM",  //Hamburg
        "depart"  => [0, 3],
        "return"  => [0, 3],
    ],
    [
        "airport" => "CGN",  //Köln
        "depart"  => [1,4],
        "return"  => [1,4],
    ],
    [
        "airport" => "VIE",  //Wien
        "depart"  => [5],
        "return"  => [5],
    ],
];

return $array;


?>

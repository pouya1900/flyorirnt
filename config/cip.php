<?php
//all cars:
// prices in Tuman
$euro_rate = 28500;
$cip_tuman = 1450000;
//$cip_tuman = 1319500;
$cip_accomp_tuman = 580000;

$car_thr_toyota_tuman = 480000;
$car_thr_rav4_tuman   = 590000;
$van_thr_tuman        = 590000;

$car_krj_rav4_tuman   = 930000;
$car_krj_toyota_tuman = 890000;

//Margin in euro:
$marg_cip_adult    = 10;
$marg_cip_chld     = 5;
$marg_cip_accomp   = 3;
$marg_transfer_thr = 6;
$marg_transfer_krj = 8;

$cip_adult_euro  = round(($cip_tuman/$euro_rate) + $marg_cip_adult);
$cip_child_euro  = round(($cip_tuman/$euro_rate) + $marg_cip_chld);
$cip_accomp_euro = round(($cip_accomp_tuman/$euro_rate) + $marg_cip_accomp);

$car_thr_toyota_euro = round(($car_thr_toyota_tuman/$euro_rate) + $marg_transfer_thr);
$car_thr_rav4_euro   = round(($car_thr_rav4_tuman/$euro_rate) + $marg_transfer_thr);
$van_thr_euro        = round(($van_thr_tuman/$euro_rate) + $marg_transfer_thr);

$car_krj_rav4_euro   = round(($car_krj_rav4_tuman/$euro_rate) + $marg_transfer_krj);
$car_krj_toyota_euro = round(($car_krj_toyota_tuman/$euro_rate) + $marg_transfer_krj);

$cars = [
    "toyota_camry"    => [
        "name_en" => "Toyota Camry (Für Teheran)",
        "name_fa" => "تویوتا کمری (برای تهران)",
        "name_de" => "Toyota Camry (For Tehran)",
        "img"=>"images/cars/toyota_camry.jpg"
    ],
    "toyota_camry_KARAJ"    => [
        "name_en" => "Toyota Camry (Für Karaj/Lavasan)",
        "name_fa" => "تویوتا کمری (برای کرج / لواسان)",
        "name_de" => "Toyota Camry (Für Karaj/Lavasan)",
        "img"=>"images/cars/toyota_camry.jpg"
    ],
    "RAV4"            => [
        "name_en" => "Toyota RAV4 (Für Teheran)",
        "name_fa" => "تویوتا راوو ۴ (برای تهران)",
        "name_de" => "Toyota RAV4 (For Tehran)",
        "img"=>"images/cars/taxi.jpg"
    ],
    "RAV4_KARAJ"            => [
        "name_en" => "Toyota RAV4 (Für Karaj/Lavasan)",
        "name_fa" => "تویوتا راوو ۴ (برای کرج / لواسان )
		",
        "name_de" => "Toyota RAV4 (For Karaj/Lavasan)",
        "img"=>"images/cars/taxi.jpg"
    ],
    "maxus"           => [
        "name_en" => "Maxus Van(Für Teheran)",
        "name_fa" => "ون مکسوس (برای تهران)",
        "name_de" => "Maxus Van (Für Teheran)",
        "img"=>"images/cars/toyota_van.jpg"
    ],
    "degree3_mashhad" => [
        "name_en" => "Samand/pegu 405/pegu pars/pegu slx",
        "name_fa" => "سمند/پژو405/پژو پارس/پژو اس ال ایکس",
        "name_de" => "Samand/pegu 405/pegu pars/pegu slx",
        "img"=>"images/cars/fff.jpg"
    ],
    "degree2_mashhad" => [
        "name_en" => "elantra/cerato/camry",
        "name_fa" => " النترا/سراتو/کمری",
        "name_de" => "elantra/cerato/camry",
        "img"=>"images/cars/fff.jpg"
    ],
    "degree1_mashhad" => [
        "name_en" => "Santa fe/Haima/Sportage/tucson",
        "name_fa" => " سانتافه/هایما/اسپورتج/توسان",
        "name_de" => "Santa fe/Haima/Sportage/tucson",
        "img"=>"images/cars/fff.jpg"
    ],
    "taxi_kish"       => [
        "name_en" => "Airport Taxi",
        "name_fa" => "تاکسی ویژه فرودگاه",
        "name_de" => "Airport Taxi",
        "img"=>"images/cars/fff.jpg"
    ],

];

// all airports , status 0 means airport isn't available
$airports = [
    [
        "code"    => "DXB",
        "name"    => [
            "name_en" => "Dubai intl",
            "name_fa" => "فرودگاه بین المللی دبی",
            "name_de" => "Dubai intl"
        ],
        "country" => [
            "name_en" => "Emirates",
            "name_fa" => "امارات",
            "name_de" => "Emirates"
        ],
        "status"  => 0
    ],
    [
        "code"    => "IKA",
        "name"    => [
            "name_en" => "IKA- Tehran Airport",
            "name_fa" => "فرودگاه امام - تهران ",
            "name_de" => "IKA- Tehran Airport",
        ],
        "country" => [
            "name_en" => "iran",
            "name_fa" => "ایران",
            "name_de" => "iran"
        ],
        "status"  => 1
    ],
    [
        "code"    => "THR",
        "name"    => [
            "name_en" => "Mehrabad intl",
            "name_fa" => "مهر اباد",
            "name_de" => "Mehrabad intl"
        ],
        "country" => [
            "name_en" => "iran",
            "name_fa" => "ایران",
            "name_de" => "iran"
        ],
        "status"  => 0
    ],
    [
        "code"    => "MHD",
        "name"    => [
            "name_en" => "shahid hashemi nejad",
            "name_fa" => "فرودگاه بین المللی مشهد",
            "name_de" => "shahid hashemi nejad"
        ],
        "country" => [
            "name_en" => "iran",
            "name_fa" => "ایران",
            "name_de" => "iran"
        ],
        "status"  => 0
    ],
    [
        "code"    => "KIH",
        "name"    => [
            "name_en" => "Kish Island",
            "name_fa" => "فرودگاه بین المللی کیش",
            "name_de" => "Kish Island"
        ],
        "country" => [
            "name_en" => "iran",
            "name_fa" => "ایران",
            "name_de" => "iran"
        ],
        "status"  => 0
    ],
];

$in  = 1;
$out = 2;

$international = 1;
$domestic      = 2;


$array = [
    "IKA" => [
        "name"    => [
            "name_en" => "Imam Khomeini Airport-Tehran",
            "name_fa" => "فرودگاه امام - تهران ",
            "name_de" => "Imam Khomeini Airport-Teheran",
        ],
        "service" => [ //all services provided by this airport
            [
                "type"        => "CIP",
                "tripe_type"  => "$international",
                "dir"         => $in,
                "status"      => 1,
                "passenger"   => [
                    "adl_passenger_rial" => "$cip_tuman",
                    "adl_passenger_euro" => "$cip_adult_euro",
                    "chl_passenger_rial" => "$cip_tuman",
                    "chl_passenger_euro" => "$cip_child_euro",
                    "inf_passenger_rial" => "0",
                    "inf_passenger_euro" => "0",
                ],
                "transfer"    => [
                    [
                        "car"   => $cars["toyota_camry"],
                        "costs" => [
                            "price_rial" => "$car_thr_toyota_tuman",
                            "price_euro" => "$car_thr_toyota_euro"
                        ]
                    ],
                    [
                        "car"   => $cars["RAV4"],
                        "costs" => [
                            "price_rial" => "$car_thr_rav4_tuman",
                            "price_euro" => "$car_thr_rav4_euro",
                        ]
                    ],
                    [
                        "car"   => $cars["maxus"],
                        "costs" => [
                            "price_rial" => "$van_thr_tuman",
                            "price_euro" => "$van_thr_euro"
                        ]
                    ],
                    [
                        "car"   => $cars["toyota_camry_KARAJ"],
                        "costs" => [
                            "price_rial" => "$car_krj_toyota_tuman",
                            "price_euro" => "$car_krj_toyota_euro"
                        ]
                    ],
                    [
                        "car"   => $cars["RAV4_KARAJ"],
                        "costs" => [
                            "price_rial" => "$car_krj_rav4_tuman",
                            "price_euro" => "$car_krj_rav4_euro",
                        ]
                    ],
                ],
                "welcome"     => [
                    [
                        "name"  => [
                            "name_en" => "normal",
                            "name_de" => "normal",
                            "name_fa" => "عادی"
                        ],
                        "costs" => [
                            "price_rial" => "$cip_accomp_tuman",
                            "price_euro" => "$cip_accomp_euro"
                        ]
                    ]
                ],
                "extra"       => [
                    /*					[
                                            "name"  => [
                                                "name_en" => "6-hour suite with one bed",
                                                "name_de" => "6-hour suite with one bed",
                                                "name_fa" => "سوییت 6 ساعته یک تخته	"
                                            ],
                                            "costs" => [
                                                "price_rial" => "2760000",
                                                "price_euro" => "20"
                                            ]
                                        ],
                                        [
                                            "name"  => [
                                                "name_en" => "6-hour suite with two beds",
                                                "name_de" => "6-hour suite with two beds",
                                                "name_fa" => "سوییت 6 ساعته دو تخته	"
                                            ],
                                            "costs" => [
                                                "price_rial" => "2760000",
                                                "price_euro" => "20"
                                            ]
                                        ],
                                        [
                                            "name"  => [
                                                "name_en" => "12-hour suite with one bed",
                                                "name_de" => "12-hour suite with one bed",
                                                "name_fa" => "سوییت 12 ساعته یک تخته	"
                                            ],
                                            "costs" => [
                                                "price_rial" => "2760000",
                                                "price_euro" => "20"
                                            ]
                                        ],
                                        [
                                            "name"  => [
                                                "name_en" => "12-hour suite with two beds",
                                                "name_de" => "12-hour suite with two beds",
                                                "name_fa" => "سوییت 12 ساعته دو تخته	"
                                            ],
                                            "costs" => [
                                                "price_rial" => "2760000",
                                                "price_euro" => "20"
                                            ]
                                        ],
                                        [
                                            "name"  => [
                                                "name_en" => "24-hour suite with one bed",
                                                "name_de" => "42-hour suite with one bed",
                                                "name_fa" => "سوییت 24 ساعته یک تخته"
                                            ],
                                            "costs" => [
                                                "price_rial" => "2760000",
                                                "price_euro" => "20"
                                            ]
                                        ],
                                        [
                                            "name"  => [
                                                "name_en" => "24-hour suite with two beds",
                                                "name_de" => "24-hour suite with two beds",
                                                "name_fa" => "سوییت 24 ساعته دو تخته	"
                                            ],
                                            "costs" => [
                                                "price_rial" => "2760000",
                                                "price_euro" => "20"
                                            ]
                                        ],
                                        [
                                            "name"  => [
                                                "name_en" => "Pet",
                                                "name_de" => "Pet",
                                                "name_fa" => "حیوان خانگی"
                                            ],
                                            "costs" => [
                                                "price_rial" => "1500000",
                                                "price_euro" => "10"
                                            ]
                                        ],
                                        [
                                            "name"  => [
                                                "name_en" => "wheelchair",
                                                "name_de" => "wheelchair",
                                                "name_fa" => "صندلی چرخ دار"
                                            ],
                                            "costs" => [
                                                "price_rial" => "1200000",
                                                "price_euro" => "10"
                                            ]
                                        ],
                                        [
                                            "name"  => [
                                                "name_en" => "Visa services",
                                                "name_de" => "Visa services",
                                                "name_fa" => "خدمات ویزا"
                                            ],
                                            "costs" => [
                                                "price_rial" => "2370000",
                                                "price_euro" => "20"
                                            ]
                                        ],
                    */
                ],
                "description" => [
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "استقبال پرسنل با تابلوی اسم مسافر در پای پرواز",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترانسپورت از پای پرواز تا جایگاه تشریفات با خودروی اختصاصی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "انجام کلیه امور تشریفات ورود (تحویل چمدان، گذرنامه و...)",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "پذیرایی از مسافرین و همراهان (انواع غذاهای ایرانی و فرنگی و نوشیدنی)",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "گیت های اختصاصی پلیس و گذرنامه",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "اینترنت پر سرعت و اتاق سیگار",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "پذیرایی از استقبال کننده در سالن اختصاصی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "حمل چمدان و بار مسافر",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "خدمات جانبی:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سوئیت جهت اقامت (یک و دو تخته)",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترانسفر از فرودگاه به منزل",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سرویس ویلچر",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سرویس حیوان خانگی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سرویس ویزا برای مسافرین خارجی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "نکته :",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "استقبال کنندگان جهت ملاقات با مسافرینشان به ساختما سی آی پی واقع در روبروی برق مراقبت مراجعه کنند.",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "برای مسافرین خارجی حتما درخواست ویزا ثبت شود.",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "هزینه ی یورویی ویزا برای مسافرین خارجه با توجه به ملیت هر مسافر خارجی متفاوت است و به صورت نقدی از مسافر در فرودگاه اخذ می شود.",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "به مسافر خارجی اطلاع دهید که یک نفر با بورد اسم به محض خروج از هواپیما منتظر ایشان است در بعضی موارد مسافر به تابلو دقت نمی کند و با سایر مسافران به سالن اصلی مراجعه می کند.",
                    ],


                ]
            ],
            [
                "type"        => "CIP",
                "tripe_type"  => "$international",
                "dir"         => $out,
                "status"      => 1,
                "passenger"   => [
                    "adl_passenger_rial" => "$cip_tuman",
                    "adl_passenger_euro" => "$cip_adult_euro",
                    "chl_passenger_rial" => "$cip_tuman",
                    "chl_passenger_euro" => "$cip_child_euro",
                    "inf_passenger_rial" => "0",
                    "inf_passenger_euro" => "0",
                ],
                "transfer"    => [
                    [
                        "car"   => $cars["toyota_camry"],
                        "costs" => [
                            "price_rial" => "$car_thr_toyota_tuman",
                            "price_euro" => "$car_thr_toyota_euro"
                        ]
                    ],
                    [
                        "car"   => $cars["RAV4"],
                        "costs" => [
                            "price_rial" => "$car_thr_rav4_tuman",
                            "price_euro" => "$car_thr_rav4_euro"
                        ]
                    ],
                    [
                        "car"   => $cars["maxus"],
                        "costs" => [
                            "price_rial" => "$van_thr_tuman",
                            "price_euro" => "$van_thr_euro"
                        ]
                    ],
                    [
                        "car"   => $cars["toyota_camry_KARAJ"],
                        "costs" => [
                            "price_rial" => "$car_krj_toyota_tuman",
                            "price_euro" => "$car_krj_toyota_euro"
                        ]
                    ],
                    [
                        "car"   => $cars["RAV4_KARAJ"],
                        "costs" => [
                            "price_rial" => "$car_krj_rav4_tuman",
                            "price_euro" => "$car_krj_rav4_euro"
                        ]
                    ],
                ],
                "welcome"     => [
                    [
                        "name"  => [
                            "name_en" => "normal",
                            "name_de" => "normal",
                            "name_fa" => "عادی"
                        ],
                        "costs" => [
                            "price_rial" => "$cip_accomp_tuman",
                            "price_euro" => "$cip_accomp_euro"
                        ]
                    ]
                ],
                "extra"       => [
                    /*
                                        [
                                            "name"  => [
                                                "name_en" => "6-hour suite with one bed",
                                                "name_de" => "6-hour suite with one bed",
                                                "name_fa" => "سوییت 6 ساعته یک تخته	"
                                            ],
                                            "costs" => [
                                                "price_rial" => "2760000",
                                                "price_euro" => "20"
                                            ]
                                        ],
                                        [
                                            "name"  => [
                                                "name_en" => "6-hour suite with two beds",
                                                "name_de" => "6-hour suite with two beds",
                                                "name_fa" => "سوییت 6 ساعته دو تخته	"
                                            ],
                                            "costs" => [
                                                "price_rial" => "2760000",
                                                "price_euro" => "20"
                                            ]
                                        ],
                                        [
                                            "name"  => [
                                                "name_en" => "12-hour suite with one bed",
                                                "name_de" => "12-hour suite with one bed",
                                                "name_fa" => "سوییت 12 ساعته یک تخته	"
                                            ],
                                            "costs" => [
                                                "price_rial" => "2760000",
                                                "price_euro" => "20"
                                            ]
                                        ],
                                        [
                                            "name"  => [
                                                "name_en" => "12-hour suite with two beds",
                                                "name_de" => "12-hour suite with two beds",
                                                "name_fa" => "سوییت 12 ساعته دو تخته	"
                                            ],
                                            "costs" => [
                                                "price_rial" => "2760000",
                                                "price_euro" => "20"
                                            ]
                                        ],
                                        [
                                            "name"  => [
                                                "name_en" => "24-hour suite with one bed",
                                                "name_de" => "42-hour suite with one bed",
                                                "name_fa" => "سوییت 24 ساعته یک تخته"
                                            ],
                                            "costs" => [
                                                "price_rial" => "2760000",
                                                "price_euro" => "20"
                                            ]
                                        ],
                                        [
                                            "name"  => [
                                                "name_en" => "24-hour suite with two beds",
                                                "name_de" => "24-hour suite with two beds",
                                                "name_fa" => "سوییت 24 ساعته دو تخته	"
                                            ],
                                            "costs" => [
                                                "price_rial" => "2760000",
                                                "price_euro" => "20"
                                            ]
                                        ],
                                        [
                                            "name"  => [
                                                "name_en" => "Pet",
                                                "name_de" => "Pet",
                                                "name_fa" => "حیوان خانگی"
                                            ],
                                            "costs" => [
                                                "price_rial" => "580000",
                                                "price_euro" => "10"
                                            ]
                                        ],
                                        [
                                            "name"  => [
                                                "name_en" => "wheelchair",
                                                "name_de" => "wheelchair",
                                                "name_fa" => "صندلی چرخ دار"
                                            ],
                                            "costs" => [
                                                "price_rial" => "1200000",
                                                "price_euro" => "10"
                                            ]
                                        ],
                                        [
                                            "name"  => [
                                                "name_en" => "Visa services",
                                                "name_de" => "Visa services",
                                                "name_fa" => "خدمات ویزا"
                                            ],
                                            "costs" => [
                                                "price_rial" => "2370000",
                                                "price_euro" => "20"
                                            ]
                                        ],
                    */
                ],
                "description" => [
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "استقبال پرسنل با تابلوی اسم مسافر در پای پرواز",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترانسپورت از پای پرواز تا جایگاه تشریفات با خودروی اختصاصی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "انجام کلیه امور تشریفات ورود (تحویل چمدان، گذرنامه و...)",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "پذیرایی از مسافرین و همراهان (انواع غذاهای ایرانی و فرنگی و نوشیدنی)",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "گیت های اختصاصی پلیس و گذرنامه",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "اینترنت پر سرعت و اتاق سیگار",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "پذیرایی از استقبال کننده در سالن اختصاصی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "حمل چمدان و بار مسافر",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "خدمات جانبی:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سوئیت جهت اقامت (یک و دو تخته)",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترانسفر از فرودگاه به منزل",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سرویس ویلچر",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سرویس حیوان خانگی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سرویس ویزا برای مسافرین خارجی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "نکته :",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "استقبال کنندگان جهت ملاقات با مسافرینشان به ساختما سی آی پی واقع در روبروی برق مراقبت مراجعه کنند.",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "برای مسافرین خارجی حتما درخواست ویزا ثبت شود.",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "هزینه ی یورویی ویزا برای مسافرین خارجه با توجه به ملیت هر مسافر خارجی متفاوت است و به صورت نقدی از مسافر در فرودگاه اخذ می شود.",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "به مسافر خارجی اطلاع دهید که یک نفر با بورد اسم به محض خروج از هواپیما منتظر ایشان است در بعضی موارد مسافر به تابلو دقت نمی کند و با سایر مسافران به سالن اصلی مراجعه می کند.",
                    ],


                ]
            ],
        ],
        "email"   => ""
    ],
    "THR" => [
        "name"    => [
            "name_en" => "Mehrabad intl",
            "name_fa" => "مهر اباد",
            "name_de" => "Mehrabad intl"
        ],
        "service" => [ //all services provided by this airport
            [
                "type"        => "CIP",
                "tripe_type"  => "$domestic",
                "dir"         => $out,
                "status"      => 1,
                "passenger"   => [
                    "adl_passenger_rial" => "1500000",
                    "adl_passenger_euro" => "100",
                    "chl_passenger_rial" => "1500000",
                    "chl_passenger_euro" => "50",
                    "inf_passenger_rial" => "0",
                    "inf_passenger_euro" => "0",
                ],
                "transfer"    => [
//                    [
//                        "car"   => $cars["toyota_van_hiace"],
//                        "costs" => [
//                            "price_rial" => "3800000",
//                            "price_euro" => "30"
//                        ]
//                    ],
                    [
                        "car"   => $cars["toyota_camry"],
                        "costs" => [
                            "price_rial" => "3800000",
                            "price_euro" => "30"
                        ]
                    ],
//                    [
//                        "car"   => $cars["sonata"],
//                        "costs" => [
//                            "price_rial" => "3800000",
//                            "price_euro" => "30"
//                        ]
//                    ]
                ],
                "welcome"     => [
                    [
                        "name"  => [
                            "name_en" => "normal",
                            "name_de" => "normal",
                            "name_fa" => "عادی"
                        ],
                        "costs" => [
                            "price_rial" => "600000",
                            "price_euro" => "10"
                        ]
                    ]
                ],
                "extra"       => [
                    [
                        "name"  => [
                            "name_en" => "3-hour suite with two beds",
                            "name_de" => "3-hour suite with two beds",
                            "name_fa" => "سوییت 3 ساعته دو تخته	"
                        ],
                        "costs" => [
                            "price_rial" => "2760000",
                            "price_euro" => "20"
                        ]
                    ],
                    [
                        "name"  => [
                            "name_en" => "6-hour suite with two beds",
                            "name_de" => "6-hour suite with two beds",
                            "name_fa" => "سوییت 6 ساعته دو تخته	"
                        ],
                        "costs" => [
                            "price_rial" => "2760000",
                            "price_euro" => "20"
                        ]
                    ],
                    [
                        "name"  => [
                            "name_en" => "12-hour suite with one bed",
                            "name_de" => "12-hour suite with one bed",
                            "name_fa" => "سوییت 12 ساعته یک تخته	"
                        ],
                        "costs" => [
                            "price_rial" => "2760000",
                            "price_euro" => "20"
                        ]
                    ],
                    [
                        "name"  => [
                            "name_en" => "Pet",
                            "name_de" => "Pet",
                            "name_fa" => "حیوان خانگی"
                        ],
                        "costs" => [
                            "price_rial" => "1500000",
                            "price_euro" => "10"
                        ]
                    ],
                    [
                        "name"  => [
                            "name_en" => "wheelchair",
                            "name_de" => "wheelchair",
                            "name_fa" => "صندلی چرخ دار"
                        ],
                        "costs" => [
                            "price_rial" => "1200000",
                            "price_euro" => "10"
                        ]
                    ],
                ],
                "description" => [
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "خدمات سالن CIP شامل موارد زیر است:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "اخذ کارت پرواز , تحویل چمدان و بار مسافر , ترانسپورت تا پای پلکان پرواز با خودروی ون اختصاصی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سرو انواع نوشیدنی های گرم و سرد و انواع شیرینی ها و فینگرفود",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "استفاده از اینترنت وایرلس پرسرعت",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "اتاق مخصوص سیگار",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "گیت اختصاصی بازرسی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "استفاده از صندلی ماساژور به صورت رایگان",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "حضور مسافر یک و نیم ساعت قبل از پرواز در فرودگاه الزامیست",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "خدمات جانبی:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "امکان سرویس دهی به مشایعت کنندگان",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "امکان رزرو سرویس ویلچر",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "امکان رزرو خدمات حیوان خانگی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سوئیت یک و دو تخته جهت استراحت مسافران",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سالن جلسات با ظرفیت 25 نفر",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سالن همایش با ظرفیت 85 نفر",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "کافی شاپ اختصاصی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "امکان رزرو خدماتCIP برای پروازهای اختصاصی داخلی و خارجی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "مهم:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "مسافر گرامی توجه داشته باشید سالن CIP فرودگاه مهرآباد در ترمینال یک طبقه ی فوقانی قرار دارد.",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سی آی پی فاقد پارکینگ اختصاصی است.",
                    ],

                ]
            ],
            [
                "type"        => "CIP",
                "tripe_type"  => "$domestic",
                "dir"         => $in,
                "status"      => 1,
                "passenger"   => [
                    "adl_passenger_rial" => "1500000",
                    "adl_passenger_euro" => "10",
                    "chl_passenger_rial" => "1500000",
                    "chl_passenger_euro" => "10",
                    "inf_passenger_rial" => "0",
                    "inf_passenger_euro" => "0",
                ],
                "transfer"    => [
//                    [
//                        "car"   => $cars["toyota_van_hiace"],
//                        "costs" => [
//                            "price_rial" => "3800000",
//                            "price_euro" => "30"
//                        ]
//                    ],
                    [
                        "car"   => $cars["toyota_camry"],
                        "costs" => [
                            "price_rial" => "3800000",
                            "price_euro" => "30"
                        ]
                    ],
//                    [
//                        "car"   => $cars["sonata"],
//                        "costs" => [
//                            "price_rial" => "3800000",
//                            "price_euro" => "30"
//                        ]
//                    ]
                ],
                "welcome"     => [
                    [
                        "name"  => [
                            "name_en" => "normal",
                            "name_de" => "normal",
                            "name_fa" => "عادی"
                        ],
                        "costs" => [
                            "price_rial" => "600000",
                            "price_euro" => "10"
                        ]
                    ]
                ],
                "extra"       => [
                    [
                        "name"  => [
                            "name_en" => "3-hour suite with two beds",
                            "name_de" => "3-hour suite with two beds",
                            "name_fa" => "سوییت 3 ساعته دو تخته	"
                        ],
                        "costs" => [
                            "price_rial" => "2760000",
                            "price_euro" => "20"
                        ]
                    ],
                    [
                        "name"  => [
                            "name_en" => "6-hour suite with two beds",
                            "name_de" => "6-hour suite with two beds",
                            "name_fa" => "سوییت 6 ساعته دو تخته	"
                        ],
                        "costs" => [
                            "price_rial" => "2760000",
                            "price_euro" => "20"
                        ]
                    ],
                    [
                        "name"  => [
                            "name_en" => "12-hour suite with one bed",
                            "name_de" => "12-hour suite with one bed",
                            "name_fa" => "سوییت 12 ساعته یک تخته	"
                        ],
                        "costs" => [
                            "price_rial" => "2760000",
                            "price_euro" => "20"
                        ]
                    ],
                    [
                        "name"  => [
                            "name_en" => "Pet",
                            "name_de" => "Pet",
                            "name_fa" => "حیوان خانگی"
                        ],
                        "costs" => [
                            "price_rial" => "1500000",
                            "price_euro" => "10"
                        ]
                    ],
                    [
                        "name"  => [
                            "name_en" => "wheelchair",
                            "name_de" => "wheelchair",
                            "name_fa" => "صندلی چرخ دار"
                        ],
                        "costs" => [
                            "price_rial" => "1200000",
                            "price_euro" => "10"
                        ]
                    ],
                ],
                "description" => [
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "توجه داشته باشید پرسنل CIP در به محض فرود هواپیما با شماره همراه مسافر تماس می گیرند و در پای پرواز با خودروی CIP منتظر مسافر هستند.",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترانسپورت از پای پلکان تا جایگاه تشریفات با خودروی اختصاصی‬",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "گیت اختصاصی سپاه و بازرسی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "انجام کلیه امور تشریفات و تحویل چمدان توسط متصدیان تشریفات",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "پذیرایی سلف سرویس در مدت انتظار (انواع نوشیدنی و میان وعده سرد و گرم)",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "استفاده از اینترنت پرسرعت",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "استفاده از صندلی ماساژور",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "خدمات جانبی شامل:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "امکان سرویس دهی به استقبال کنندگان",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "امکان رزرو سرویس ویلچر",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "امکان رزرو خدمات حیوان خانگی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سوئیت یک و دو تخته جهت استراحت مسافران",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سالن جلسات با ظرفیت 25 نفر",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سالن همایش با ظرفیت 85 نفر",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "کافی شاپ اختصاصی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "امکان رزرو خدماتCIP برای پروازهای اختصاصی داخلی و خارجی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "مهم:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "مسافر گرامی توجه داشته باشید سالن CIP فرودگاه مهرآباد در ترمینال یک طبقه ی فوقانی قرار دارد.",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سی آی پی فاقد پارکینگ اختصاصی است.",
                    ],

                ]
            ],
        ],
        "email"   => ""
    ],
    "MHD" => [
        "name"    => [
            "name_en" => "shahid hashemi nejad",
            "name_fa" => "فرودگاه بین المللی مشهد",
            "name_de" => "shahid hashemi nejad"
        ],
        "service" => [ //all services provided by this airport
            [
                "type"        => "CIP",
                "tripe_type"  => "$domestic",
                "dir"         => $in,
                "status"      => 1,
                "passenger"   => [
                    "adl_passenger_rial" => "1500000",
                    "adl_passenger_euro" => "10",
                    "chl_passenger_rial" => "1500000",
                    "chl_passenger_euro" => "10",
                    "inf_passenger_rial" => "0",
                    "inf_passenger_euro" => "0",
                ],
                "transfer"    => [
                    [
                        "car"   => $cars["degree3_mashhad"],
                        "costs" => [
                            "price_rial" => "3800000",
                            "price_euro" => "30"
                        ]
                    ],
                    [
                        "car"   => $cars["degree1_mashhad"],
                        "costs" => [
                            "price_rial" => "3800000",
                            "price_euro" => "30"
                        ]
                    ],
                    [
                        "car"   => $cars["degree2_mashhad"],
                        "costs" => [
                            "price_rial" => "3800000",
                            "price_euro" => "30"
                        ]
                    ]
                ],
                "welcome"     => [
                    [
                        "name"  => [
                            "name_en" => "normal",
                            "name_de" => "normal",
                            "name_fa" => "عادی"
                        ],
                        "costs" => [
                            "price_rial" => "600000",
                            "price_euro" => "5"
                        ]
                    ]
                ],
                "extra"       => [

                ],
                "description" => [
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترانسپورت از پای پلکان پرواز تا سالن تشریفات با خودروی اختصاصی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "گیت اختصاصی بازرسی ورود",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "دریافت چمدان مسافر",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "انجام تشریفات گمرکی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "پذیرایی با انواع نوشیدنی و خوراکی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "اینترنت پرسرعت رایگان",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "فضای باز جهت استراحت",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سرویس دهی به مستقبلین و مشایعین",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "خدمات جانبی:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترنسفر شهری",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ویلچر",
                    ],


                ]
            ],
            [
                "type"        => "CIP",
                "tripe_type"  => "$domestic",
                "dir"         => $out,
                "status"      => 1,
                "passenger"   => [
                    "adl_passenger_rial" => "1500000",
                    "adl_passenger_euro" => "10",
                    "chl_passenger_rial" => "1500000",
                    "chl_passenger_euro" => "10",
                    "inf_passenger_rial" => "0",
                    "inf_passenger_euro" => "0",
                ],
                "transfer"    => [
                    [
                        "car"   => $cars["degree3_mashhad"],
                        "costs" => [
                            "price_rial" => "3800000",
                            "price_euro" => "30"
                        ]
                    ],
                    [
                        "car"   => $cars["degree1_mashhad"],
                        "costs" => [
                            "price_rial" => "3800000",
                            "price_euro" => "30"
                        ]
                    ],
                    [
                        "car"   => $cars["degree2_mashhad"],
                        "costs" => [
                            "price_rial" => "3800000",
                            "price_euro" => "30"
                        ]
                    ]
                ],
                "welcome"     => [
                    [
                        "name"  => [
                            "name_en" => "normal",
                            "name_de" => "normal",
                            "name_fa" => "عادی"
                        ],
                        "costs" => [
                            "price_rial" => "600000",
                            "price_euro" => "5"
                        ]
                    ]
                ],
                "extra"       => [
                ],
                "description" => [
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترانسپورت از جایگاه تشریفاتی تا پای پلکان پرواز با خودروی اختصاصی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "گیت اختصاصی بازرسی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "تحویل چمدان و اخذ کارت پرواز",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "پذیرایی با انواع نوشیدنی و خوراکی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "اینترنت پرسرعت رایگان",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "فضای باز جهت استراحت",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سرویس دهی به مستقبلین و مشایعین",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "خدمات جانبی:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترنسفر شهری",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ویلچر",
                    ],


                ]
            ],
            [
                "type"        => "CIP",
                "tripe_type"  => "$international",
                "dir"         => $in,
                "status"      => 1,
                "passenger"   => [
                    "adl_passenger_rial" => "1500000",
                    "adl_passenger_euro" => "10",
                    "chl_passenger_rial" => "1500000",
                    "chl_passenger_euro" => "10",
                    "inf_passenger_rial" => "0",
                    "inf_passenger_euro" => "0",
                ],
                "transfer"    => [
                    [
                        "car"   => $cars["degree3_mashhad"],
                        "costs" => [
                            "price_rial" => "3800000",
                            "price_euro" => "30"
                        ]
                    ],
                    [
                        "car"   => $cars["degree1_mashhad"],
                        "costs" => [
                            "price_rial" => "3800000",
                            "price_euro" => "30"
                        ]
                    ],
                    [
                        "car"   => $cars["degree2_mashhad"],
                        "costs" => [
                            "price_rial" => "3800000",
                            "price_euro" => "30"
                        ]
                    ]
                ],
                "welcome"     => [
                    [
                        "name"  => [
                            "name_en" => "normal",
                            "name_de" => "normal",
                            "name_fa" => "عادی"
                        ],
                        "costs" => [
                            "price_rial" => "600000",
                            "price_euro" => "5"
                        ]
                    ]
                ],
                "extra"       => [
                ],
                "description" => [
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترانسپورت از پای پلکان پرواز تا سالن تشریفات با خودروی اختصاصی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "گیت ورودی اختصاصی بازرسی و گذرنامه",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "دریافت چمدان مسافر",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "انجام تشریفات گمرکی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "پذیرایی با انواع نوشیدنی و خوراکی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "اینترنت پرسرعت رایگان",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "فضای باز جهت استراحت",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سرویس دهی به مستقبلین و مشایعین",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "خدمات جانبی:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترنسفر شهری",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ویلچر",
                    ],


                ]
            ],
            [
                "type"        => "CIP",
                "tripe_type"  => "$international",
                "dir"         => $out,
                "status"      => 1,
                "passenger"   => [
                    "adl_passenger_rial" => "1500000",
                    "adl_passenger_euro" => "10",
                    "chl_passenger_rial" => "1500000",
                    "chl_passenger_euro" => "10",
                    "inf_passenger_rial" => "0",
                    "inf_passenger_euro" => "0",
                ],
                "transfer"    => [
                    [
                        "car"   => $cars["degree3_mashhad"],
                        "costs" => [
                            "price_rial" => "3800000",
                            "price_euro" => "30"
                        ]
                    ],
                    [
                        "car"   => $cars["degree1_mashhad"],
                        "costs" => [
                            "price_rial" => "3800000",
                            "price_euro" => "30"
                        ]
                    ],
                    [
                        "car"   => $cars["degree2_mashhad"],
                        "costs" => [
                            "price_rial" => "3800000",
                            "price_euro" => "30"
                        ]
                    ]
                ],
                "welcome"     => [
                    [
                        "name"  => [
                            "name_en" => "normal",
                            "name_de" => "normal",
                            "name_fa" => "عادی"
                        ],
                        "costs" => [
                            "price_rial" => "600000",
                            "price_euro" => "5"
                        ]
                    ]
                ],
                "extra"       => [
                ],
                "description" => [
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترانسپورت از جایگاه تشریفاتی تا پای پلکان پرواز با خودروی اختصاصی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "گیت اختصاصی بازرسی و گذرنامه",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "تحویل چمدان و اخذ کارت پرواز",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "انجام تشریفات گمرکی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "پذیرایی با انواع نوشیدنی و خوراکی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "اینترنت پرسرعت رایگان",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "فضای باز جهت استراحت",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سرویس دهی به مستقبلین و مشایعین",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "خدمات جانبی:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترنسفر شهری",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ویلچر",
                    ],


                ]
            ],
        ],
        "email"   => ""
    ],
    "KIH" => [
        "name"    => [
            "name_en" => "Kish Island",
            "name_fa" => "فرودگاه بین المللی کیش",
            "name_de" => "Kish Island"
        ],
        "service" => [ //all services provided by this airport
            [
                "type"        => "CIP",
                "tripe_type"  => "$domestic",
                "dir"         => $in,
                "status"      => 1,
                "passenger"   => [
                    "adl_passenger_rial" => "1500000",
                    "adl_passenger_euro" => "10",
                    "chl_passenger_rial" => "1500000",
                    "chl_passenger_euro" => "10",
                    "inf_passenger_rial" => "0",
                    "inf_passenger_euro" => "0",
                ],
                "transfer"    => [
                    [
                        "car"   => $cars["taxi_kish"],
                        "costs" => [
                            "price_rial" => "500000",
                            "price_euro" => "5"
                        ]
                    ],
                ],
                "welcome"     => [
                    [
                        "name"  => [
                            "name_en" => "normal",
                            "name_de" => "normal",
                            "name_fa" => "عادی"
                        ],
                        "costs" => [
                            "price_rial" => "600000",
                            "price_euro" => "5"
                        ]
                    ]
                ],
                "extra"       => [

                ],
                "description" => [
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترانسپورت از پای پلکان پرواز تا سالن تشریفات با خودروی اختصاصی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "گیت اختصاصی ورود",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "دریافت چمدان مسافر",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "دریافت چمدان مسافر و سایر امور پروازی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "پذیرایی با انواع نوشیدنی و خوراکی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "اینترنت پرسرعت",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سرویس دهی به مستقبلین و مشایعین",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "خدمات جانبی:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترنسفر شهری",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "مهم:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "با توجه به اینکه سالن CIP و VIP فرودگاه کیش به صورت همزمان در یک ساختمان واقع شده اند در زمان حضور مسافران پاویون دولت امکان سرویس دهی به سایر مسافرین فراهم نیست لذا حتما قبل از رزرو این سرویس با شماره پشتیبانی جهت تایید تماس حاصل فرمائید.",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "امکان سرویس دهی برای پروازهای بعد از ساعت 22 وجود ندارد.",
                    ],

                ]
            ],
            [
                "type"        => "CIP",
                "tripe_type"  => "$domestic",
                "dir"         => $out,
                "status"      => 1,
                "passenger"   => [
                    "adl_passenger_rial" => "1500000",
                    "adl_passenger_euro" => "10",
                    "chl_passenger_rial" => "1500000",
                    "chl_passenger_euro" => "10",
                    "inf_passenger_rial" => "0",
                    "inf_passenger_euro" => "0",
                ],
                "transfer"    => [
                    [
                        "car"   => $cars["taxi_kish"],
                        "costs" => [
                            "price_rial" => "500000",
                            "price_euro" => "5"
                        ]
                    ],
                ],
                "welcome"     => [
                    [
                        "name"  => [
                            "name_en" => "normal",
                            "name_de" => "normal",
                            "name_fa" => "عادی"
                        ],
                        "costs" => [
                            "price_rial" => "600000",
                            "price_euro" => "5"
                        ]
                    ]
                ],
                "extra"       => [
                ],
                "description" => [
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "همراهی و مشایعت پرسنل تشریفات از محل جایگاه تا پای پرواز با خودروی اختصاصی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "گیت اختصاصی سپاه و گذرنامه",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "تحویل چمدان و بار مسافر",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "اخذ کارت پرواز و سیت مناسب",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "انجام تشریفات گمرکی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "بوفه باز پذیرایی انواع نوشیدنی و کیک",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "اینترنت رایگان",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "اسرویس دهی به مشایعت کننده و استقبال کننده",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "خدمات جانبی:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترنسفر شهری",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "مهم:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "با توجه به اینکه سالن CIP و VIP فرودگاه کیش به صورت همزمان در یک ساختمان واقع شده اند در زمان حضور مسافران پاویون دولت امکان سرویس دهی به سایر مسافرین فراهم نیست لذا حتما قبل از رزرو این سرویس با شماره پشتیبانی جهت تایید تماس حاصل فرمائید.",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "امکان سرویس دهی برای پروازهای بعد از ساعت 22 وجود ندارد.",
                    ],


                ]
            ],
            [
                "type"        => "CIP",
                "tripe_type"  => "$international",
                "dir"         => $in,
                "status"      => 1,
                "passenger"   => [
                    "adl_passenger_rial" => "1500000",
                    "adl_passenger_euro" => "10",
                    "chl_passenger_rial" => "1500000",
                    "chl_passenger_euro" => "10",
                    "inf_passenger_rial" => "0",
                    "inf_passenger_euro" => "0",
                ],
                "transfer"    => [
                    [
                        "car"   => $cars["taxi_kish"],
                        "costs" => [
                            "price_rial" => "500000",
                            "price_euro" => "5"
                        ]
                    ],
                ],
                "welcome"     => [
                    [
                        "name"  => [
                            "name_en" => "normal",
                            "name_de" => "normal",
                            "name_fa" => "عادی"
                        ],
                        "costs" => [
                            "price_rial" => "600000",
                            "price_euro" => "5"
                        ]
                    ]
                ],
                "extra"       => [
                ],
                "description" => [
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترانسپورت از پای پلکان پرواز تا سالن تشریفات با خودروی اختصاصی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "گیت اختصاصی بازرسی و گیت اختصاصی گذرنامه",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "انجام مراحل ویزا",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "دریافت چمدان مسافر و سایر امور پروازی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "انجام تشریفات گمرکی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "پذیرایی با انواع نوشیدنی و خوراکی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سرویس دهی به مستقبلین و مشایعین",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "خدمات جانبی:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترنسفر شهری",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "مهم:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "با توجه به اینکه سالن CIP و VIP فرودگاه کیش به صورت همزمان در یک ساختمان واقع شده اند در زمان حضور مسافران پاویون دولت امکان سرویس دهی به سایر مسافرین فراهم نیست لذا حتما قبل از رزرو این سرویس با شماره پشتیبانی جهت تایید تماس حاصل فرمائید.",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "امکان سرویس دهی برای پروازهای بعد از ساعت 22 وجود ندارد.",
                    ],


                ]
            ],
            [
                "type"        => "CIP",
                "tripe_type"  => "$international",
                "dir"         => $out,
                "status"      => 1,
                "passenger"   => [
                    "adl_passenger_rial" => "1500000",
                    "adl_passenger_euro" => "10",
                    "chl_passenger_rial" => "1500000",
                    "chl_passenger_euro" => "10",
                    "inf_passenger_rial" => "0",
                    "inf_passenger_euro" => "0",
                ],
                "transfer"    => [
                    [
                        "car"   => $cars["taxi_kish"],
                        "costs" => [
                            "price_rial" => "500000",
                            "price_euro" => "5"
                        ]
                    ],
                ],
                "welcome"     => [
                    [
                        "name"  => [
                            "name_en" => "normal",
                            "name_de" => "normal",
                            "name_fa" => "عادی"
                        ],
                        "costs" => [
                            "price_rial" => "600000",
                            "price_euro" => "5"
                        ]
                    ]
                ],
                "extra"       => [
                ],
                "description" => [
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "همراهی و مشایعت پرسنل تشریفات از محل جایگاه تا پای پرواز با خودروی اختصاصی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "گیت اختصاصی سپاه و گذرنامه",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "تحویل چمدان و بار مسافر",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "اخذ کارت پرواز و سیت مناسب",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "انجام تشریفات گمرکی",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "بوفه باز پذیرایی انواع نوشیدنی و کیک",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "اینترنت رایگان",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "سرویس دهی به مستقبلین و مشایعین",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "خدمات جانبی:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "ترنسفر شهری",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "مهم:",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "با توجه به اینکه سالن CIP و VIP فرودگاه کیش به صورت همزمان در یک ساختمان واقع شده اند در زمان حضور مسافران پاویون دولت امکان سرویس دهی به سایر مسافرین فراهم نیست لذا حتما قبل از رزرو این سرویس با شماره پشتیبانی جهت تایید تماس حاصل فرمائید.",
                    ],
                    [
                        "en" => "",
                        "de" => "",
                        "fa" => "امکان سرویس دهی برای پروازهای بعد از ساعت 22 وجود ندارد.",
                    ],
                ]
            ],
        ],
        "email"   => ""
    ],
];

$response = [
    "airports"         => $airports,
    "airport_services" => $array
];

return $response;


?>


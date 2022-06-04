<?php


namespace App\Services;

use Carbon\Carbon;


class MyHelperFunction
{

    public static function turn_class($class)
    {

        switch ($class) {
            case 1 :
                $cabin_class = trans('trs.economy');
                break;
            case 2 :
                $cabin_class = trans('trs.premium_economy');
                break;
            case 3 :
                $cabin_class = trans('trs.business');
                break;
            case 4 :
                $cabin_class = trans('trs.premium_business');
                break;
            case 5 :
                $cabin_class = trans('trs.first');
                break;
            case 6 :
                $cabin_class = trans('trs.premium_first');
                break;
            default :
                $cabin_class = trans('trs.default');
                break;
        }

        return $cabin_class;

    }

    public static function turn_class_en($class)
    {

        switch ($class) {
            case 1 :
                $cabin_class = 'economy';
                break;
            case 2 :
                $cabin_class = 'premium';
                break;
            case 3 :
                $cabin_class = 'business';
                break;
            case 4 :
                $cabin_class = 'premium_business';
                break;
            case 5 :
                $cabin_class = 'first';
                break;
            case 6 :
                $cabin_class = 'premium_first';
                break;
            default :
                $cabin_class = 'economy';
                break;
        }

        return $cabin_class;

    }

    public static function turn_title($gender, $type)
    {

        if ($gender == 0 && $type == 1) {
            $title = trans('trs.mr');
        } else if ($gender == 0) {
            $title = trans('trs.mstr');
        } else if ($gender == 1 && $type == 1) {
            $title = trans('trs.mrs');
        } else {
            $title = trans('trs.miss');
        }

        return $title;

    }

    public static function turn_gender($gender)
    {

        if ($gender == 0) {
            return trans('trs.male');
        } else {
            return trans('trs.female');
        }
    }

    public static function turn_type($type_code)
    {

        switch ($type_code) {
            case 1 :
                $type = trans('trs.adult');
                break;
            case 2 :
                $type = trans('trs.child');
                break;
            case 3 :
                $type = trans('trs.infant');
                break;
            default :
                $type = trans('trs.adult');
                break;
        }

        return $type;

    }

    public static function turn_role($code)
    {

        switch ($code) {

            case 0:
                $role = "guest";
                break;
            case 2:
                $role = "staff";
                break;
            case 3:
                $role = "admin";
                break;
            case 1:
            default:
                $role = "user";
                break;
        }

        return $role;
    }

    public static function turn_cip_type($type)
    {

        if ($type == 1) {
            $res = "arrival";
        } else {
            $res = "Outgoing";
        }

        return $res;
    }

    public static function turn_cip_tripe_type($type)
    {

        if ($type == 1) {
            $res = "international";
        } else {
            $res = "domestic";
        }

        return $res;
    }


    public static function ISO8601ToMin($ISO8601)
    {
        preg_match('/\d{1,2}[H]/', $ISO8601, $hours);
        preg_match('/\d{1,2}[M]/', $ISO8601, $minutes);
        preg_match('/\d{1,2}[S]/', $ISO8601, $seconds);

        $duration = [
            'hours'   => $hours ? $hours[0] : 0,
            'minutes' => $minutes ? $minutes[0] : 0,
            'seconds' => $seconds ? $seconds[0] : 0,
        ];

        $hours = intval(substr($duration['hours'], 0, -1));
        $minutes = intval(substr($duration['minutes'], 0, -1));
        $seconds = intval(substr($duration['seconds'], 0, -1));

        $toltalMin = $hours * 60 + $minutes;

        return $toltalMin;
    }


    public static function turn_class_to_code($class)
    {

        switch (strtolower($class)) {
            case "economy" :
                $cabin_class = 1;
                break;
            case "premium_economy" :
                $cabin_class = 2;
                break;
            case "business" :
                $cabin_class = 3;
                break;
            case "first" :
                $cabin_class = 5;
                break;
            default :
                $cabin_class = 1;
                break;
        }

        return $cabin_class;
    }

    public static function turn_class_to_code_database($class)
    {

        switch (strtolower($class)) {
            case "economy" :
                $cabin_class = 1;
                break;
            case "premium" :
                $cabin_class = 2;
                break;
            case "business" :
                $cabin_class = 3;
                break;
            case "first" :
                $cabin_class = 5;
                break;
            default :
                $cabin_class = 1;
                break;
        }

        return $cabin_class;
    }


    public static function turn_fare_type_to_code($type)
    {

        switch ($type) {
            case "PUBLISHED" :
                $fare_type = 1;
                break;
            case "NEGOTIATED" :
                $fare_type = 2;
                break;
            case "CORPORATE " :
                $fare_type = 3;
                break;
            default :
                $fare_type = 1;
                break;

        }

        return $fare_type;

    }

    public static function turn_day_of_week($code)
    {

        switch ($code) {

            case 0:
                $day = trans('trs.sunday_short');
                break;
            case 1:
                $day = trans('trs.monday_short');
                break;
            case 2:
                $day = trans('trs.Tuesday_short');
                break;
            case 3:
                $day = trans('trs.Wednesday_short');
                break;
            case 4:
                $day = trans('trs.Thursday_short');
                break;
            case 5:
                $day = trans('trs.Friday_short');
                break;
            case 6:
                $day = trans('trs.saturday_short');
                break;
            default :
                $day = "";
        }

        return $day;

    }

    public static function turn_min_to_time($min)
    {

        $h = intval($min / 60);
        $m = $min % 60;

        $time = Carbon::createFromTime($h, $m, 0, 'UTC')->format('H:i');

        return $time;
    }


    public static function turn_title_code($gender, $type)
    {

        if ($gender == 0 && $type == 1) {
            $title = 'Mr';
        } else if ($gender == 0) {
            $title = 'Master';
        } else if ($gender == 1 && $type == 1) {
            $title = 'Mrs';
        } else {
            $title = 'Miss';
        }

        return $title;

    }

    public static function turn_title_code2($gender, $type)
    {

        if ($gender == 0 && $type == 1) {
            $title = 'Mr';
        } else if ($gender == 0) {
            $title = 'Mstr';
        } else if ($gender == 1 && $type == 1) {
            $title = 'Mrs';
        } else {
            $title = 'Miss';
        }

        return $title;

    }

    public static function turn_OTA_code_to_class($code)
    {

        $e = ["B", "E", "G", "H", "K", "L", "M", "N", "O", "Q", "S", "T", "U", "V", "W", "X", "Y"];
        $b = ["C", "D", "I", "J", "Z"];
        $f = ["A", "F", "P", "R"];
        if (in_array($code, $e)) {
            $class = 1;
        } elseif (in_array($code, $b)) {
            $class = 3;
        } elseif (in_array($code, $b)) {
            $class = 5;
        } else {
            $class = 1;
        }

        return $class;

    }

    public static function turn_type_code($type_code)
    {

        switch ($type_code) {
            case 1 :
                $type = "ADT";
                break;
            case 2 :
                $type = "CHD";
                break;
            case 3 :
                $type = "INF";
                break;
            default :
                $type = "ADT";
                break;
        }

        return $type;

    }


}
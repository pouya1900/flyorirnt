<?php
#app/Services/SetPriceFunction.php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class SetPriceFunction
{

    public $adult;
    public $child;
    public $infant;
    public $ad_count;
    public $ch_count;
    public $in_count;

//	type 0 for adult 1 for child 2 for inf

    public function index($price, $type, $airline = "", $vendor = "")
    {

        $setting = Setting::find(1);

        $config = \Illuminate\Support\Facades\Config::get("PriceInfo");

        $payPal_rate = $config["payPal_rate"];
        $payPal_fix = $config["payPal_fix"];

        $min_margin_Child = $config["min_margin_Child"];
        $min_percent_Child = $config["min_percent_Child"];
        $min_margin_Adult = $config["min_margin_Adult"];
        $min_percent_Adult = $config["min_percent_Adult"];
        $vendorPrice = $price;

        if ($type == 0) {
            $min_margin = $min_margin_Adult;
            $margin_percent = $min_percent_Adult;
        } else {
            $min_margin = $min_margin_Child;
            $margin_percent = $min_percent_Child;
        }
        $margin = $margin_percent * $vendorPrice;
        if ($margin < $min_margin) {
            $margin = $min_margin;
        }
        //SRA: Fix margin: ----------------------
		$margin = ($type == 0)? 15:8;
		//---------------------------------------
        $EndPrice = ($vendorPrice + $payPal_fix + 1.19 * $margin) / (1 - $payPal_rate);

        $EndPrice = round($EndPrice);
        $paypal_fee = $EndPrice * $payPal_rate + $payPal_fix;

        $margin = ($EndPrice - $vendorPrice - $paypal_fee) / 1.19;
        $tax = $margin * 0.19;

        $EndPrice = round($EndPrice, 2);
        $paypal_fee = round($paypal_fee, 2);
        $margin = round($margin, 2);
        $tax = round($tax, 2);

        if ($config["no_change"] == 1 || ($setting->pure_price && Auth::user() && Auth::user()->role == 3)) $EndPrice = $price;

        $this->setPrice($EndPrice, $type);

        return $EndPrice;
    }

    public function setCount($count, $type)
    {

        switch ($type) {
            case 0 :
                $this->ad_count = $count;
                break;
            case 1 :
                $this->ch_count = $count;
                break;
            case 2:
                $this->in_count = $count;
                break;
        }

    }

    public function setPrice($price, $type)
    {

        switch ($type) {
            case 0 :
                $this->adult = $price;
                break;
            case 1 :
                $this->child = $price;
                break;
            case 2:
                $this->infant = $price;
                break;
        }

    }

    public function getTotal()
    {
        return $this->adult * $this->ad_count + $this->child * $this->ch_count + $this->infant * $this->in_count;
    }
}
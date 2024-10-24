<?php
#app/Services/SetPriceFunction.php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use App\User;

class SetPriceFunction
{

    public $adult;
    public $child;
    public $infant;
    public $ad_count;
    public $ch_count;
    public $in_count;
    public $commission_adult = 0;
    public $commission_child = 0;
    public $commission_infant = 0;

//	type 0 for adult 1 for child 2 for inf

//vendor parto and iran_air

    public function index($price, $type, $airline = "", $vendor = "", $depart_airport = null, $arrival_airport = null)
    {

        $price_addition_adult = 0;
        $price_addition_child = 0;
        $price_addition_infant = 0;

        $mwst = 0.19;
        if (Auth::check() && Auth::user()->role == User::agency) {
            $user = Auth::user();
            $price_addition_adult = $user->balance->commission_adult - $user->balance->discount_adult;
            $this->commission_adult = $user->balance->commission_adult;
            $price_addition_child = $user->balance->commission_child - $user->balance->discount_child;
            $this->commission_child = $user->balance->commission_child;
            $price_addition_infant = $user->balance->commission_infant - $user->balance->discount_infant;
            $this->commission_infant = $user->balance->commission_infant;
        }

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
        $mwst = 0;
		/*
        if  ($vendor=="parto")
		{
			if ($depart_airport == "IKA") 
			{
				$margin = ($type == 0) ? 120: 110;
            }
			else 
			{
				if ($airline == "QR") $margin = ($type == 0) ? 70 : 50;
				if ($airline == "EK") $margin = ($type == 0) ? 60 : 50;
            }
    	    if ($type > 0) $payPal_fix = 0; // no fix paypal fee for children
        	$EndPrice = ($vendorPrice + $payPal_fix + (1 + $mwst) * $margin) / (1 - $payPal_rate);
		}
		*/
    //*************************************************
        if ($vendor=="iran_air")
        {
            $EndPrice = $vendorPrice;
        }
        else if ($vendor=="parto")
        {
			/*
			$EndPrice = $vendorPrice + $margin;
            $EndPrice = round($EndPrice + 0.2);
            $paypal_fee = $EndPrice * $payPal_rate + $payPal_fix;
            $margin = ($EndPrice - $vendorPrice - $paypal_fee) / (1 + $mwst);
            $tax = $margin * $mwst;
            if ($type == 0)
            {
                $EndPrice += $price_addition_adult;
            }
            elseif ($type == 1)
            {
                $EndPrice += $price_addition_child;
            }
            else
            {
                $EndPrice += $price_addition_infant;
            }
			*/
			//$EndPrice = round($vendorPrice + 120);
			if ($depart_airport == "IKA" || $depart_airport == "SYZ" || $depart_airport == "TBZ" || 
				$depart_airport == "MHD" || $depart_airport == "IFN") 
			{
				$EndPrice = $vendorPrice + 125;
				if ($airline == "TK") $EndPrice += ($type == 0) ? 30 : 30;
				if ($airline == "FZ" ||  $airline == "EK") $EndPrice += ($type == 0) ? 74 : 30;
			}
			else
			{
				$EndPrice = $vendorPrice;
				if ($airline == "LH") $EndPrice += ($type == 0) ? 50 : 45;
				else if ($airline == "OS") $EndPrice += ($type == 0) ? 60 : 55;
				else $EndPrice +=60;
			}
			$EndPrice = round($EndPrice);
        }
		if ($type == 0)
        {
            $EndPrice += $price_addition_adult;
        }
        elseif ($type == 1)
        {
            $EndPrice += $price_addition_child;
        }
        else
        {
            $EndPrice += $price_addition_infant;
        }
		
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

    public function getTotalAgencyCommission()
    {
        return $this->commission_adult * $this->ad_count + $this->commission_child * $this->ch_count + $this->commission_infant * $this->in_count;
    }
}

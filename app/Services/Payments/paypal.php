<?php

namespace App\Services\Payments;

use App\Models\Setting;

class paypal
{

    private $token;

    public $base;

    public function __construct()
    {

        $ch = curl_init();

        $setting = Setting::find(1);

        if ($setting->payment) {
            $clientId = env('PAYPAL_CLIENT_ID');
            $secret = env('PAYPAL_SECRET');
            $this->base = "https://api.paypal.com";
        } else {
            $clientId = env('PAYPAL_TEST_CLIENT_ID');
            $secret = env('PAYPAL_TEST_SECRET');
            $this->base = "https://api.sandbox.paypal.com";
        }


        curl_setopt($ch, CURLOPT_URL, $this->base . "/v1/oauth2/token");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" . $secret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

        $result = curl_exec($ch);

        if (empty($result)) {
            //error handling code
            dd("Error: No response.");
        } else {
            $result = json_decode($result, true);
            $token = $result["access_token"];
        }

        curl_close($ch);

        $this->token = $token;

    }

    public function create_payment($create_data)
    {


        $ch = curl_init();
//		$data = [
//			"intent"        => "sale",
//			"payer"         => [
//				"payment_method" => "paypal"
//			],
//			"transactions"  => [
//				[
//					"amount"          => [
//						"total"    => $create_data["total"],
//						"currency" => $create_data["currency"],
//						"details"  => [
//							"subtotal" => $create_data["total"],
//						]
//					],
//					"description"     => $create_data["description"],
//					"custom"          => $create_data["custom"],
//					"invoice_number"  => $create_data["invoice_number"],
//					"payment_options" => [
//						"allowed_payment_method" => "INSTANT_FUNDING_SOURCE"
//					],
//					"soft_descriptor" => $create_data["soft_descriptor"],
//					"item_list"       => [
//						"items"            => [
//							[
//								"name"        => $create_data["item_name"],
//								"description" => $create_data["item_description"],
//								"quantity"    => $create_data["item_quantity"],
//								"price"       => $create_data["total"],
//								"sku"         => "1",
//								"currency"    => $create_data["item_currency"]
//							]
//						],
//
//					]
//				]
//			],
//			"note_to_payer" => "Contact us for any questions on your order.",
//			"redirect_urls" => [
//				"return_url" => route( 'confirm_payment',["method"=>"paypal"] ),
//				"cancel_url" => route( 'cancel_payment',["token"=>$create_data["book_token"]])
//			]
//		];

        $data = [
            "intent"              => "CAPTURE",
            "application_context" => [
                'brand_name'           => 'fly orient',
                'shipping_preferences' => 'NO_SHIPPING',
                'user_action'          => 'PAY_NOW',
            ],
            "purchase_units"      => [
                [
                    "amount"      => [
                        'currency_code' => "EUR",
                        'value'         => $create_data["total"],
                    ],
                    "description" => $create_data["description"],

                ],
            ],
        ];


        curl_setopt($ch, CURLOPT_URL, $this->base . "/v2/checkout/orders");
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $this->token",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($ch);
        $result = json_decode($result, true);
        curl_close($ch);


        return $result;

    }

    public function capture_payment($payment_id)
    {

        $ch = curl_init();


        $req_uri = $this->base . "/v2/checkout/orders/" . $payment_id . "/capture";

        curl_setopt($ch, CURLOPT_URL, $req_uri);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $this->token",
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        $result = json_decode($result, true);
        curl_close($ch);

        return $result;
    }


    public function order($payment_id)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->base . "/v2/checkout/orders/$payment_id");
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $this->token",
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $result = json_decode($result, true);
        curl_close($ch);

        return $result;

    }

}
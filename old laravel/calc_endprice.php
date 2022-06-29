<body style="font-family: Courier New">
<?php
  $min_margin_Adult = 15;
  $min_margin_Child = 8;
  $min_percent_Adult = 0.03;
  $min_percent_Child = 0.015;
function claculate_endprice($Passanger_type, $vendorPrice, &$EndPrice, &$margin, &$paypal_fee, &$tax) 
{
  global $min_margin_Adult;
  global $min_margin_Child;
  global $min_percent_Adult;
  global $min_percent_Child;

  # Passanger_type : "A" Adult  "C": Child
 # EndPrice = vendorPrice  +        paypal_fee                     +      tax     +  min_margin
 # EndPrice = vendorPrice  +  (EndPrice*payPal_rate + payPal_fix)  +  0,19*min_margin +  min_margin
 # EndPrice*(1-payPal_rate) = vendorPrice + payPal_fix + 1,19*min_margin
 #
 #             vendorPrice + payPal_fix + 1,19*min_margins
 # EndPrice = -----------------------------------------
 #                        (1-payPal_rate)
 $payPal_rate = 0.025;
 #$payPal_fix  = 0.35;
 $payPal_fix  = 0;
 if ($Passanger_type=="C")
 {
  $min_margin     = $min_margin_Child;
  $margin_precent = $min_percent_Child;
 }
 else
 {
  $min_margin     = $min_margin_Adult;
  $margin_precent = $min_percent_Adult;
 }
 $margin = $margin_precent * $vendorPrice;
 if ($margin < $min_margin)  $margin = $min_margin;
 
 $EndPrice = ($vendorPrice + $payPal_fix + 1.19*$margin) / (1-$payPal_rate);
 #echo "EndPrice_1 : ".$EndPrice_1."<br>";
  
 $EndPrice   = round($EndPrice);
 $paypal_fee = $EndPrice * $payPal_rate + $payPal_fix;
 # EndPrice = vendorPrice + paypal_fee + min_margin + 0,19*min_margin
 #
 #           EndPrice - vendorPrice - paypal_fee 
 # min_margin = -------------------------------------
 #                         1,19
 $margin =($EndPrice - $vendorPrice - $paypal_fee)/1.19;
 $tax    = $margin * 0.19;

 $EndPrice   = round( $EndPrice, 2);
 $paypal_fee = round( $paypal_fee, 2);
 $margin = round( $margin, 2);
 $tax        = round( $tax, 2);
}
#------TEST: ----------------------------  
for ($i=0; $i<26; $i++)
{
  $vendorPrice = 50+$i*50;
  if ($margin<15) $margin = 15;
  claculate_endprice("A", $vendorPrice, $EndPrice, $margin, $payPal_fee, $tax);
  $d = $EndPrice - $vendorPrice;
  echo ("V:".$vendorPrice." + P:".$payPal_fee. " + Tx:".$tax. " + M:". $margin." ==> ".$EndPrice. " ) Del:".$d."<br>");
}
?>
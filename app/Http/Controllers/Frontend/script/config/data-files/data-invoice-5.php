<?php
global $xData;
/**************** Data settings ********************/
$xData["company"]["logo"]["data"] = "http://xinvoice.biz/script/images/xinvoice-logo-5.png";
$xData["company"]["name"]["data"] = "Company Name, Inc";
$xData["company"]["tagline"]["data"] = "dummy tagline of company";
$xData["document"]["title"]["data"] = "INVOICE";
$xData["invoice"]["no"]["data"] = "DY-13123";
$xData["invoice"]["date"]["data"] = "01-08-2018";
//$xData["invoice"]["total_due"]["data"] = 56890.23;
//$xData["invoice"]["due_date"]["data"] = "01-12-2018";
//$xData["from"]["name"]["data"] = "Company Name, Inc";
$xData["from"]["address1"]["data"] = "123 Sunny Road, Sunnyville, CA 31321";
//$xData["from"]["address2"]["data"] = "Sunnyville, CA 12345";
$xData["from"]["city"]["data"] = "San Francisco, California";
//$xData["from"]["state"]["data"] = "";
$xData["from"]["country"]["data"] = "USA - 452005";
//$xData["from"]["postalcode"]["data"] = "";
$xData["from"]["email"]["data"] = "info@companyname.com";
$xData["from"]["website"]["data"] = "http://xinvoice.biz";
$xData["to"]["name"]["data"] = "American Option";
$xData["to"]["address1"]["data"] = "El Monte Road Los Altos Hills";
//$xData["to"]["address2"]["data"] = "Opp. YM, Saratoga Rd";
//$xData["to"]["city"]["data"] = "Sunnyvale";
//$xData["to"]["state"]["data"] = "CA";
//$xData["to"]["country"]["data"] = "USA";
//$xData["to"]["postalcode"]["data"] = "452005";
$xData["to"]["email"]["data"] = "info@digitaldreamstech.com";
$xData["to"]["website"]["data"] = "http://digitaldreamstech.com/";
$xData["payment"]["method1"]["data"] = "<br/>Paypal <br/> dummy@gmail.com";
//$xData["payment"]["method2"]["data"] = "<br/>Skrills <br/> dummyskril@gmail.com";
//$xData["payment"]["method3"]["data"] = "<br/>Bank Account <br/> Acc No.: 12341234";
//$xData["payment"]["method4"]["data"] = "Director<br/> <img src='http://xinvoice.biz/script/images/sign.png' /> ";
$xData["message"]["thankyou"]["data"] = "Thank you for your business";
//$xData["message"]["remark"]["data"] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry";
$xData["footer"]["note"]["data"] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.";
$xData["item"][0]["name"]["data"] = "Logo Design";
$xData["item"][0]["desc"]["data"] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry";
$xData["item"][0]["qty"]["data"] = 100;
$xData["item"][0]["rate"]["data"] = 2500;
$xData["item"][0]["total"]["data"] = 25000;
$xData["item"][1]["name"]["data"] = "Brochure Design";
$xData["item"][1]["desc"]["data"] = "Lorem Ipsum has been the industry's standard dummy text.";
$xData["item"][1]["qty"]["data"] = 200;
$xData["item"][1]["rate"]["data"] = 20;
$xData["item"][1]["total"]["data"] = 4000;
$xData["item"][2]["name"]["data"] = "Website Design";
$xData["item"][2]["desc"]["data"] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.";
$xData["item"][2]["qty"]["data"] = 100;
$xData["item"][2]["rate"]["data"] = 2500;
$xData["item"][2]["total"]["data"] = 25000;
$xData["item"][3]["name"]["data"] = "Invoice Design";
$xData["item"][3]["desc"]["data"] = "Lorem Ipsum has been the industry's standard dummy text.";
$xData["item"][3]["qty"]["data"] = 200;
$xData["item"][3]["rate"]["data"] = 20;
$xData["item"][3]["total"]["data"] = 4000;
$xData["total"]["subtotal"]["data"] = 4000;
//$xData["total"]["discount"]["data"] = -1000;
$xData["total"]["tax"]["data"] = 400;
//$xData["total"]["shipping"]["data"] = 400;
$xData["total"]["grandtotal"]["data"] = 4400;

/**************** label settings ********************/
$xData["invoice"]["no"]["label"] = "INVOICE NO: ";
$xData["invoice"]["date"]["label"] = "DATE: ";
//$xData["invoice"]["total_due"]["label"] = "TOTAL AMOUNT <br/>";
//$xData["invoice"]["due_date"]["label"] = "Due Date: ";
//$xData["from"]["address"]["label"] = "";
$xData["to"]["name"]["label"] = "CLIENT: ";
$xData["to"]["address1"]["label"] = "ADDRESS: ";
$xData["to"]["email"]["label"] = "EMAIL: ";
$xData["to"]["website"]["label"] = "WEBSITE: ";
$xData["total"]["subtotal"]["label"] = "Subtotal: ";
//$xData["total"]["discount"]["label"] = "Discount: ";
$xData["total"]["tax"]["label"] = "Tax @10%: ";
//$xData["total"]["shipping"]["label"] = "Shipping Charges: ";
$xData["total"]["grandtotal"]["label"] = "<strong>Grand Total:</strong> ";
$xData["payment"]["method1"]["label"] = "<strong>Payment Methods</strong>";
$xData["payment"]["note"]["label"] = "";
$xData["footer"]["note"]["label"] = "<strong>TERMS: </strong>";
$xData["itemcount"]["count"]["label"] = "Sno.";
$xData["item"][0]["name"]["label"] = "Service";
$xData["item"][0]["desc"]["label"] = "Description";
$xData["item"][0]["qty"]["label"] = "Quantity";
$xData["item"][0]["rate"]["label"] = "Price";
$xData["item"][0]["total"]["label"] = "Total";

/**************** style settings ********************/
$xData["invoice"]["no"]["style"] = "font-size:16px; font-weight:bold";
$xData["invoice"]["date"]["style"] = "font-size:16px; font-weight:bold";
$xData["invoice"]["total_due"]["style"] = "color:#88b267; font-size: 24px; font-weight:bold";
$xData["header"]["style"] = "color: #cfcfcf; font-size:16px; padding-bottom:10px";
$xData["sender_receiver"]["style"] = "margin-top:20px; margin-bottom: 20px";
//$xData["to"]["name"]["style"] = "color:#88b267; font-size: 24px;font-weight:bold";
$xData["company"]["logo"]["style"] = "max-width:300px";
$xData["payment"]["style"] = "margin-top:10px; margin-bottom: 10px";
$xData["message"]["thankyou"]["style"] = "";
$xData["footer"]["style"] = "font-size:14px";

/**************** display settings ********************/
$xData["header"]["display"] = true;
$xData["invoice"]["total_due"]["display"] = true;
$xData["sender_receiver"]["display"] = true;
$xData["from"]["display"] = true;
$xData["from"]["name"]["display"] = true;
$xData["to"]["display"] = true;
$xData["to"]["name"]["display"] = true;
$xData["items"]["display"] = true;
$xData["item"][0]["qty"]["display"] = true;
$xData["item"][0]["rate"]["display"] = true;
$xData["itemcount"]["display"] = false;
$xData["message"]["display"] = true;
$xData["footer"]["display"] = true;

/****************data formatting settings ********************/
$xData["invoice"]["date"]["format"] = array("date","Y-m-d");
$xData["invoice"]["due_date"]["format"] = array("date","Y-m-d");
$xData["invoice"]["total_due"]["format"] = array("currency","$");
$xData["item"][0]["qty"]["format"] = array("suffix"," pcs.");
$xData["item"][0]["total"]["format"] = array("currency","$");
$xData["total"]["subtotal"]["format"] = array("currency","$");
//$xData["total"]["discount"]["format"] = array("currency","$");
$xData["total"]["tax"]["format"] = array("currency","$");
//$xData["total"]["shipping"]["format"] = array("currency","$");
$xData["total"]["grandtotal"]["format"] = array("currency","$");
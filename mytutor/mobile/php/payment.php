<?php
$email = $_GET['user_email'];
$phone = $_GET['user_phone']; 
$name = $_GET['user_name']; 
$amount = $_GET['amount']; 


$api_key  = '3443b726-1c20-4fc7-b98a-59f55d9cf03d';
$collection_id = 'z4qdnnow';
 
$host = 'https://www.billplz-sandbox.com/api/v3/bills';


$data = array(
          'collection_id' => $collection_id,
          'user_email' => $email,
          'user_phone' => $phone,
          'user_name' => $name,
          'amount' => ($amount + 1) * 100,
		  'description' => 'Payment for order by '.$name,
          'callback_url' => "http://ibtihal.com/mytutor/mobile/php/return_url",
          'redirect_url' => "http://ibtihal.com/mytutor/mobile/php/payment_update.php?email=$email&phone=$phone&amount=$amount&name=$name" 
);


$process = curl_init($host );
curl_setopt($process, CURLOPT_HEADER, 0);
curl_setopt($process, CURLOPT_USERPWD, $api_key . ":");
curl_setopt($process, CURLOPT_TIMEOUT, 30);
curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($data) ); 

$return = curl_exec($process);
curl_close($process);

$bill = json_decode($return, true);
header("Location: {$bill['url']}");












?>
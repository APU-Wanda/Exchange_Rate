<?php
$curl = curl_init();

$symbol = 'GBP';
$base = 'EUR';

curl_setopt_array($curl, array(
CURLOPT_URL => "https://api.apilayer.com/fixer/latest?symbols=$symbol&base=$base",
CURLOPT_HTTPHEADER => array(
"Content-Type: text/plain",
"apikey: QB6rJctM1pQsva6dThlfHyb3gJZQk6Fo"
),
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "GET"
));

$response = curl_exec($curl);
$arr_result = json_decode($response, JSON_PRETTY_PRINT);
print_r($arr_result['date']);
//curl_close($curl);
//echo $response;

//$object = new AddCalculator();
//$result = $object->calculator(5,4);
<?php

class ApiRate
{
    public function rate(string $symbol, string $base, int $money)
    {
        $curl = curl_init();

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
        $arr_result = json_decode($response, true);
        echo '<pre>';
        echo 'The exchange rate for the the target country which is '.$symbol . ' ';
        print_r($arr_result['rates'][$symbol]);

        echo '<pre>';
        echo 'The amount for the target country according to the today\'s exchange rate : ';
        print_r(($arr_result['rates'][$symbol]) * $money);
//curl_close($curl);
//echo $response;
    }

    public function __construct()
    {
        //      self::rate('GBP','EUR');
        //   print var_dump($var);
//        echo 'The amount for the target country according to the todays exchange rate ';
//     //   $var = self::rate('GBP','EUR');
//        $amount = (self::rate('GBP','EUR')) * 100;
//        print $amount * 100000;
    }
}

$object = new ApiRate();
$result = $object->rate('GBP','EUR', 200);
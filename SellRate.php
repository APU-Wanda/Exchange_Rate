<?php

class SellRate
{
//    var $localhost, $port, $dbname, $user, $password;

    public function rate(string $symbol, string $base, int $money)
    {
        $conn = pg_connect("host=localhost port=5432 dbname=exchange_rate user=root password=123456");

        //      $conn = new PDO("pgsql:host=localhost;dbname=exchange_rate","postgres","123456");

        $margin= "SELECT flat_margin, parcent_margin FROM exchange_rate_feeder_rules WHERE from_currency = $symbol and to_currency = $base";
        $result = pg_query($conn, $margin);
        // $conn->query($margin);

        while ($row = pg_fetch_row($result)) {
            $flat_margin = $row[0];
            $percent_margin = $row[1];
        }
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
        /**
         * buy rate from API
         */
        $buy_rate = $arr_result['rates'][$symbol];
        /**
         * calculated sell rate
         */
        $sell_rate = ($buy_rate - ($flat_margin)) - ($percent_margin / 100);

        $sql = "INSERT INTO exchange_rates(id,from_currency,to_currency,sell_rate,buy_rate,created)VALUES(NULL,$symbol,$base,$buy_rate,$sell_rate,NULL)";
//curl_close($curl);
//echo $response;
    }
}

$object = new SellRate();
$result = $object->rate('GBP','EUR', 200);
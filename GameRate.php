<?php

class GameRates extends ActiveRecord
{

    public static function calcGameRate()
    {
        // Find rates percents config from DB
        $rates = static::find()->asArray()->all();
        if ($rates) {
            $rates_data = [];

            //Build the array of possible configurations relative to the percentage probability of their appearance
            foreach ($rates as $rate) {
                for ($i = 1; $i <= $rate['percent']; $i++) {
                    $rates_data[] = [
                        'coefficient_min' => $rate['coefficient_min'],
                        'coefficient_max' => $rate['coefficient_max'],
                        'speed' => $rate['speed'],
                    ];
                }
            }
            $rate_id = array_rand($rates_data);

            // find random rate config rom DB
            $rates_data = $rates_data[$rate_id];

            $min_rate = $rates_data['coefficient_min'] * 100;
            $max_rate = $rates_data['coefficient_max'] * 100;

            // generate rate from selected config
            $rates_data['rate'] = rand($min_rate, $max_rate) / 100;
            return $rates_data;
        }

        $init = [
            'coefficient_min' => 0,
            'coefficient_max' => 0,
            'speed' => 0,
            'rate' => 0,
        ];
        return $init;
    }

}

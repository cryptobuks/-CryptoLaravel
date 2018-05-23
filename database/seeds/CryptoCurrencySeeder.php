<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class CryptoCurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      DB::table('cryptocurrency')->insert([ //str_random(10)
        'id' => 1,
        'name' => 'Bitcoin',
        'symbol' => 'BTC',
        'rank' => 1,
        'available_supply' => 1000000,
        'total_supply' => 1000000,
        'price_usd' => 11111.11,
        '24h_volume_usd' => 1111111,
        'market_cap_usd' => 1111111,
        'percent_change_1h' => 11111,
        'percent_change_24h' => 11111,
        'percent_change_7d' => 11111,
        'last_updated' => 111212,
        'created_at' => Carbon::now()
      ]);
      DB::table('cryptocurrency')->insert([ //str_random(10)
        'id' => 2,
        'name' => 'Ethereum',
        'symbol' => 'ETH',
        'rank' => 2,
        'available_supply' => 2000000,
        'total_supply' => 2000000,
        'price_usd' => 2222.11,
        '24h_volume_usd' => 2222222,
        'market_cap_usd' => 2222222,
        'percent_change_1h' => 2222222,
        'percent_change_24h' => 2222222,
        'percent_change_7d' => 2222222,
        'last_updated' => 2222222,
        'created_at' => Carbon::now()
      ]);
    }
}

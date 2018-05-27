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
      $json = Storage::get("/json/CryptoCurrencyData.json");
      $data = json_decode($json, true);
      foreach ($data as $array) {
          DB::table('cryptocurrency')->insert(array(
              'id' => $array['id'],
              'name' => $array['name'],
              'symbol' => $array['symbol'],
              'rank' => $array['rank'],
              'available_supply' => $array['available_supply'],
              'total_supply' => $array['total_supply'],
              'price_usd' => $array['price_usd'],
              '24h_volume_usd' => $array['24h_volume_usd'],
              'market_cap_usd' => $array['market_cap_usd'],
              'percent_change_1h' => $array['percent_change_1h'],
              'percent_change_24h' => $array['percent_change_24h'],
              'percent_change_7d' => $array['percent_change_7d'],
              'last_updated' => $array['last_updated'],
              'created_at' => Carbon::now(),
              'updated_at' => Carbon::now(),
          ));
      }

      // DB::table('cryptocurrency')->insert([ //str_random(10)
      //   'id' => 1,
      //   'name' => 'Bitcoin',
      //   'symbol' => 'BTC',
      //   'rank' => 1,
      //   'available_supply' => 1000000,
      //   'total_supply' => 1000000,
      //   'price_usd' => 11111.11,
      //   '24h_volume_usd' => 1111111,
      //   'market_cap_usd' => 1111111,
      //   'percent_change_1h' => 11111,
      //   'percent_change_24h' => 11111,
      //   'percent_change_7d' => 11111,
      //   'last_updated' => 111212,
      //   'created_at' => Carbon::now()
      // ]);
      // DB::table('cryptocurrency')->insert([ //str_random(10)
      //   'id' => 2,
      //   'name' => 'Ethereum',
      //   'symbol' => 'ETH',
      //   'rank' => 2,
      //   'available_supply' => 2000000,
      //   'total_supply' => 2000000,
      //   'price_usd' => 2222.11,
      //   '24h_volume_usd' => 2222222,
      //   'market_cap_usd' => 2222222,
      //   'percent_change_1h' => 2222222,
      //   'percent_change_24h' => 2222222,
      //   'percent_change_7d' => 2222222,
      //   'last_updated' => 2222222,
      //   'created_at' => Carbon::now()
      // ]);
    }
}

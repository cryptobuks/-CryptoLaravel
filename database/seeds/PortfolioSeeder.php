<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Portfolio;
use App\CryptoCurrency;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // DB::table('portfolio')->insert([ //str_random(10)
      //   'id' => 1,
      //   'coin_id' => 1,
      //   'user_id' => 1,
      //   'buy_price' => 100,
      //   'amount' => 1,
      //   'created_at' => $timestamp,
      //   'updated_at' => $timestamp,
      // ]);

      $holdings = [];
      foreach (range(1, 10) as $index)
      {
          $timestamp = Carbon::now();
          $coinPrice = CryptoCurrency::where('id', $index)->pluck('price_usd')->first();
          $holdings[] = [
            'id' => $index,
            'coin_id' => Rand(1,10),
            'user_id' => 1,
            'buy_price' => mt_rand(0 * 10, $coinPrice * 10) / 10 + $coinPrice,
            'amount' => Rand(1,30),
            'date_purchased' => Carbon::now()->subDays(rand(0, 26))->format('Y-m-d'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
          ];
      }
      Portfolio::insert($holdings);

    }
}

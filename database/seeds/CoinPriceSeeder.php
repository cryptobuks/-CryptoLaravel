<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\CoinPrice;
use App\CryptoCurrency;

class CoinPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $data = [];
      foreach (range(1, 10) as $index) { // 10 Coins
        $coinPrice = CryptoCurrency::where('id', $index)->pluck('price_usd')->first();
        $begin = new DateTime('2018-04-1');
        $end = new DateTime("now");
        for($i = $begin; $i <= $end; $i->modify('+1 day')) {
          $data[] = [
            'coin_id' => $index,
            'date' => $i->format('Y-m-d'),
            'price' => mt_rand(0 * 10, $coinPrice * 10) / 10 + $coinPrice,
          ];
        }
      }
      CoinPrice::insert($data);
    }
}

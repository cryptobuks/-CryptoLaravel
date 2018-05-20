<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Portfolio;

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
      foreach (range(1, 5) as $index)
      {
          $timestamp = Carbon::now();
          $holdings[] = [
            'id' => $index,
            'coin_id' => $index % 2 ? 1 : 2,
            'user_id' => 1,
            'buy_price' => $index * 100,
            'amount' => $index * 3,
            'date_purchased' => "2018-05-20",
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
          ];
      }
      Portfolio::insert($holdings);

    }
}

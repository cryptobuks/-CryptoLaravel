<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $this->call(UsersTableSeeder::class);
      $this->call(CryptoCurrencySeeder::class);
      $this->call(PortfolioSeeder::class);
      $this->call(CoinPriceSeeder::class);

    }
}

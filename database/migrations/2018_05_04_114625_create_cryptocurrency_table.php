<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptocurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cryptocurrency', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('symbol', 5)->unique();
            $table->integer('rank');
            $table->decimal('price_usd', 11, 2);
            $table->bigInteger('24h_volume_usd');
            $table->bigInteger('market_cap_usd');
            $table->bigInteger('available_supply');
            $table->bigInteger('total_supply');
            $table->decimal('percent_change_1h', 11, 2);
            $table->decimal('percent_change_24h', 11, 2);
            $table->decimal('percent_change_7d', 11, 2);
            $table->bigInteger('last_updated');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cryptocurrency');
    }
}

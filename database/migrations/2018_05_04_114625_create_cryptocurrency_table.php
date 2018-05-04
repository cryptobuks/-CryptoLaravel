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
            $table->bigInteger('circulating_supply');
            $table->bigInteger('total_supply');
            $table->decimal('price', 11, 2);
            $table->bigInteger('volume_24h');
            $table->bigInteger('market_cap');
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

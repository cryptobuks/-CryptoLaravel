<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfolioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('portfolio', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('coin_id')->unsigned();
          $table->foreign('coin_id')->references('id')->on('cryptocurrency');
          $table->integer('user_id')->unsigned();
          $table->foreign('user_id')->references('id')->on('users');
          $table->decimal('buy_price', 11, 2);
          $table->integer('amount');
          $table->date('date_purchased');
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
        Schema::dropIfExists('portfolio');
    }
}

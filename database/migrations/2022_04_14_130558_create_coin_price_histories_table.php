<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinPriceHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin_price_histories', function (Blueprint $table) {
            $table->id();
            
            $table->string('coingeecko_id');
            $table->string('symbol');
            $table->string('name');
            $table->string('thumb_url');
            $table->string('current_price');
            
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
        Schema::dropIfExists('coin_price_histories');
    }
}

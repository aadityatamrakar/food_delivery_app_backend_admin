<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Wallet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('capture');
            $table->string('mode');
            $table->string('reason');
            $table->float('amount');
            $table->integer('order_id');
            $table->integer('user_id');
            $table->integer('restaurant_id');
            $table->string('device');
            $table->string('uuid');
            $table->string('imei');
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
         Schema::drop('wallet');
    }
}

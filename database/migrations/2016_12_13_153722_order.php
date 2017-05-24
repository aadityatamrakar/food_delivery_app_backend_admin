<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Order extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('restaurant_id');
            $table->string('address')->nullable();
            $table->string('city');
            $table->float('gtotal');
            $table->text('cart');
            $table->string('status');
            $table->string('deliver');
            $table->string('payment_mode');
            $table->string('coupon')->nullable();
            $table->string('packing_fee')->nullable();
            $table->string('delivery_fee')->nullable();
            $table->string('mobile2')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::drop('order');
    }
}

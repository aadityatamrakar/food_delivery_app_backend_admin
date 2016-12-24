<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Coupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('percent');
            $table->string('max_amount');
            $table->string('min_amt');
            $table->string('return_type');
            $table->timestamp('valid_from');
            $table->timestamp('valid_till');
            $table->string('times');
            $table->string('new_only');
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
        Schema::drop('coupon');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Restaurant extends Migration
{
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('logo')->nullable();
            $table->string('name');
            $table->text('address');
            $table->integer('city_id');
            $table->string('pincode');
            $table->string('owner_name');
            $table->string('contact_no');
            $table->string('contact_no_2');
            $table->string('telephone')->nullable();
            $table->string('email');
            $table->string('speciality');
            $table->string('comm_percent');
            $table->string('cuisines');
            $table->string('type');
            $table->string('vat_tax');
            $table->string('svc_tax');
            $table->string('delivery_time')->nullable();
            $table->string('pickup_time')->nullable();
            $table->string('dinein_time')->nullable();
            $table->string('train_time')->nullable();
            $table->string('delivery_fee')->nullable();
            $table->string('min_delivery_amt')->nullable();
            $table->string('packing_fee')->nullable();
            $table->string('payment_modes');
            $table->text('tax_details')->nullable();
            $table->text('delivery_hours')->nullable();
            $table->text('pickup_hours')->nullable();
            $table->text('dinein_hours')->nullable();
            $table->text('train_hours')->nullable();
            $table->string('tin')->nullable();
            $table->string('pan')->nullable();
            $table->string('account_holder')->nullable();
            $table->string('account_no')->nullable();
            $table->string('account_bank')->nullable();
            $table->string('account_ifsc')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('restaurants');
    }
}

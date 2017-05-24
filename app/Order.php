<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    protected $fillable = ['user_id', 'restaurant_id', 'address', 'city', 'gtotal', 'cart', 'status', 'deliver', 'payment_modes', 'coupon', 'delivery_fee', 'packing_fee', 'mobile2', 'remarks', 'discount', 'cashback'];

    public function user()
    {
        return $this->belongsTo('App\Customer');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

    public function transactions()
    {
        return $this->hasMany('App\wallet', 'order_id');
    }

    public function coupon()
    {
        return $this->hasOne('App\Coupon', 'coupon');
    }
}

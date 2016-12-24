<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $table = 'restaurants';

    protected $fillable = [
        'logo', 'name', 'address', 'city_id', 'pincode',
        'owner_name', 'contact_no', 'contact_no_2',
        'telephone', 'email', 'speciality', 'comm_percent', 'cuisines', 'type',
        'delivery_time', 'pickup_time', 'dinein_time', 'delivery_fee', 'min_delivery_amt',
        'packing_fee', 'payment_modes', 'account_holder',
        'account_no', 'account_bank', 'account_ifsc', 'dinein_hours'
    ];

    public function categories()
    {
        return $this->hasMany('App\Category');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}

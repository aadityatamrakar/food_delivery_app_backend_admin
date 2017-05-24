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
        'account_no', 'account_bank', 'account_ifsc', 'dinein_hours',
        'vat_tax', 'svc_tax', 'train_time', 'train_hours'
    ];

    public function categories()
    {
        return $this->hasMany('App\Category');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

//    public function outstanding(){
//        $orders = $this->hasMany('App\Order');
//        $payments = $this->hasMany('App\Payment');
//        $this->total_transaction = $orders->sum('gtotal');
//        $this->total_payment = $payments->sum('amount');
//        $this->comm = ($this->total_transaction-$this->total_payment)*($this->comm_percent/100);
//        return $this;
//    }
}

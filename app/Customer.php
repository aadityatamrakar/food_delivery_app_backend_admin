<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';

    protected $fillable = ['name', 'email', 'mobile',
        'address', 'city', 'pincode',
        'device', 'uuid', 'imei'];

    public function orders()
    {
        return $this->hasMany('App\Order', 'user_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';

    protected $fillable = ['restaurant_id', 'amount', 'mode', 'status', 'transaction_details', 'transaction_time'];

    public function restaurant(){
        return $this->belongsTo('App\Restaurant');
    }
}

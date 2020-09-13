<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'status', 'notification',
    ];

    public function orderProducts()
    {
        return $this->hasMany('App\OrderProduct');
    }
}

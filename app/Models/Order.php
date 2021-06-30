<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $appends = [
        'created'
    ];

    public function orderdetails()
    {
        return $this->hasMany('App\Models\OrderDetail', 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function getCreatedAttribute()
    {
        return date("Y/m/d", strtotime($this->attributes['created_at']));
    }
}

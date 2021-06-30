<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'customer_product')->withPivot('order_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'customer_id');
    }
}

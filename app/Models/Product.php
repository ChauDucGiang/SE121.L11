<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function customers()
    {
        return $this->belongsToMany('App\Models\Customer', 'customer_product')->withPivot('order_id');
    }

    public function orderdetails()
    {
        return $this->hasMany('App\Models\OrderDetail', 'product_id');
    }

//    protected $appends = [
//        'images'
//    ];

    public function getWeavingAttribute()
    {
        if ($this->attributes['weaving'] === null) {
            return '';
        }
        return $this->attributes['weaving'];

    }

    public function getInfoAttribute()
    {
        if ($this->attributes['info'] === null) {
            return '';
        }
        return $this->attributes['info'];
    }

    public function getImagesAttribute()
    {
        if (isset($this->attributes['images'])) {
            return json_decode($this->attributes['images']);
        }
    }

    public function package()
    {
        return $this->belongsTo('App\Models\Package', 'package_id');
    }
}

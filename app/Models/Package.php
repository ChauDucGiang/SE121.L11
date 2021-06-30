<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'package_id');
    }

    protected $appends = [
        'created'
    ];

    public function getCreatedAttribute()
    {
        return date("Y/m/d", strtotime($this->attributes['created_at']));
    }
}

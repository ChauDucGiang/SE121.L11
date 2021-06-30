<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use  SoftDeletes;

    public function subcategories()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'category_id');
    }

    protected $appends = [
        'created'
    ];

    public function getCreatedAttribute()
    {
        return date("Y/m/d", strtotime($this->attributes['created_at']));
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            //remove related rows
            if (!$category->parent_id) {
                $category->subcategories->each(function ($subcategory) {
                    $subcategory->products()->delete();
                });
                $category->subcategories()->delete();
            } else {
                $category->products()->delete();
            }
            return true;
        });
    }
}

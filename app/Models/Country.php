<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function customers()
    {
        return $this->hasMany('App\Models\Customer', 'country_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends  Model
{
    public function getPriceAttribute()
    {
        return $this->attributes['price'] / 100;
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 100;
    }

    public function  customers()
    {
        return $this->hasOne('App\ customer', ' customers_id');
    }

    

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transactions";
    public function customer()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getAmountAttribute()
    {
        return $this->attributes['amount'] / 100;
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = $value * 100;
    }

    public function getTaxAttribute()
    {
        return $this->attributes['tax'] / 100;
    }

    public function setTaxAttribute($value)
    {
        $this->attributes['tax'] = $value * 100;
    }

    public function getTotalAmountAttribute()
    {
        return $this->attributes['total_amount'] / 100;
    }

    public function setTotalAmountAttribute($value)
    {
        $this->attributes['total_amount'] = $value * 100;
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerDetail extends  Model
{
    protected $table = "customer_details";

    protected $fillable = ['customer_id', 'address', 'address_opt', 'business_category_id', 'product_category_id', 'requirements', 'services', 'store_name', 'state', 'city', 'pincode', 'verification', 'payment_status', 'package_id', 'gstin', 'pos'];

    public function customer()
    {
        return $this->belongsTo('App\User', 'customer_id');
    }

    public function package()
    {
        return $this->belongsTo('App\Package', 'package_id');
    }

    public function business_category()
    {
        return $this->belongsTo('App\Category', 'business_category_id');
    }

    public function product_category()
    {
        return $this->belongsTo('App\Category', 'product_category_id');
    }
}

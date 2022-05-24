<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class PaymentReciept extends Model
{
    public function customer()
    {
        return $this->belongsTo('App\User', 'customer_id');
    }

    public function employee()
    {
        return $this->belongsTo('App\User', 'employee_id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\User', 'receiver_id');
    }
}

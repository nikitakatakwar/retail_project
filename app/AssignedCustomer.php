<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignedCustomer extends Model
{
    public function customers()
    {
        return $this->belongsTo('App/User', 'customer_id');
    }

    public function employee()
    {
        return $this->belongsTo('App/User', 'employee_id');
    }
}

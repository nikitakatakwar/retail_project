<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee_detail extends Model
{
    public function superior()
    {
        return $this->belongsTo('App\User', 'superior_id');
    }
}

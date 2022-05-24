<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function created_by()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $fillable = ['user_id', 'target', 'target_date_from', 'target_date', 'green_value'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

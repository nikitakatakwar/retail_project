<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class phone_number extends Model
{
    protected $fillable = ['type', 'number', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

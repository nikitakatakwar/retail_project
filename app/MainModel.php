<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MainModel extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at ',
    ];

    public function getCreatedAtAttribute($value)
    {

        $timezone_timestamp = Carbon::parse($value)->timezone('Asia/Kolkata')->format('d-m-Y, h:i:s A');
        return $timezone_timestamp;
        // return $value->timezone('Asia/Kolkata')->format('d-m-Y, h:i:s a');
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}

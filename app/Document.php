<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['user_id', 'document', 'document_type'];
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}

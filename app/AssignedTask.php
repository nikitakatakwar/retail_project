<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignedTask extends Model
{
    protected $fillable = ['customer_id', 'employee_id', 'task_id', 'start_date', 'end_date', 'status', 'assignee_id'];

    public function task()
    {
        return $this->belongsTo('App\Task', 'task_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\User', 'customer_id');
    }

    public function employee()
    {
        return $this->belongsTo('App\User', 'employee_id');
    }

    public function assignee()
    {
        return $this->belongsTo('App\User', 'assignee_id');
    }
}

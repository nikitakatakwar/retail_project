<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function phone_number()
    {
        return $this->hasMany('App\phone_number');
    }

    public function employee_detail()
    {
        return $this->hasOne('App\employee_detail', 'user_id');
    }

    public function customer_details()
    {
        return $this->hasOne('App\CustomerDetail', 'customer_id');
    }

    public function employees()
    {
        return $this->belongsToMany('App\User', 'customer_employee', 'customer_id', 'employee_id')->withPivot('employee_type');
    }

    public function customers()
    {
        return $this->belongsToMany('App\User', 'customer_employee', 'employee_id', 'customer_id')->withPivot('employee_type');
    }

    public function customerRelatedTasks()
    {
        return $this->hasMany('App\AssignedTask', 'customer_id');
    }

    public function package()
    {
        return $this->hasOne('App\Package', 'id');
    }


    public function moving_status()
    {
        return $this->hasOne('App\AssignedCustomer', 'customer_id');
    }


    public function transactions()
    {
        return $this->hasMany('App\Transaction', 'user_id');
    }

    public function documents()
    {
        return $this->hasMany('App\Document', 'user_id');
    }

}

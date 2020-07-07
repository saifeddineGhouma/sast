<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminResetPasswordNotification;
use Zizaco\Entrust\Traits\EntrustUserTrait;


class Admin extends Authenticatable
{
	use Notifiable,EntrustUserTrait;
	
	protected $guard="admins";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
	
    protected $fillable = [
        'username','email', 'password','remember'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }
}

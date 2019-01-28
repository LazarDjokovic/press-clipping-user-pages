<?php

namespace App;

use App\CommunicationsPrinted;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'last_name', 'company_id', 'role_id', 'username','mobile_phone', 'register_ip_address', 'last_login_ip_address','note','last_login_timestamp'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public function role(){
        return $this->belongsTo(\App\Model\Role::class);
    }

    public function company(){
        return $this->belongsTo(\App\Model\Company::class);
    }

}

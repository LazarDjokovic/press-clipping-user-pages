<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    public function keywords(){
        return $this->hasMany(Keyword::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function printeds(){
        return $this->hasMany(Printed::class);
    }

    public function digitals(){
        return $this->hasMany(Digital::class);
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'type','authorized_person','email','phone', 'address','city', 'state','pib','ziro_racun','mobile_phone','pdv','note'
    ];
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function synonym(){
        return $this->hasMany(Synonym::class,'keyword_name', 'name');
    }
    

    protected $fillable = [
        'name', 'slug','company_id'
    ];
}

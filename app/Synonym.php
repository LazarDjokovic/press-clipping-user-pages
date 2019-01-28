<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Keyword;

class Synonym extends Model
{
    public function keywords(){
        return $this->hasMany(Keyword::class);
    }

    protected $fillable = [
        'keyword_name', 'name' 
    ];
}

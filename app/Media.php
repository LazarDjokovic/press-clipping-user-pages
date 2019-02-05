<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'name', 'slug'
    ];

    public function printeds()
    {
        return  $this->belongsTo(Printed::class,'media_slug','slug');
    }

}

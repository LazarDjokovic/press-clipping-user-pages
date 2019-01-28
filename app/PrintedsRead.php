<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrintedsRead extends Model
{
    protected $table = 'printeds_read';

    protected $fillable = [
        'user_id', 'media_slug', 'company_id', 'printed_id', 'broj_izdanja', 'created_at'
    ];
}

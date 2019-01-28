<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DigitalsRead extends Model
{
    protected $table = 'digitals_read';

    protected $fillable = [
        'user_id', 'media_slug', 'company_id', 'printed_id', 'created_at'
    ];
}

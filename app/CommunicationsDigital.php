<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Digital;

class CommunicationsDigital extends Model
{

    protected $table = "communications_digital";

    public function digitals(){
        return  $this->belongsTo(Digital::class, 'media_id');
    }

    protected $fillable = [
        'operator_id', 'editor_id', 'media_id','message', 'operator_email', 'editor_email'
    ];
}

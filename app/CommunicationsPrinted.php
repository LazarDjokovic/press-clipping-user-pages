<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Printed;

class CommunicationsPrinted extends Model
{

    protected $table = "communications_printed";
    public function printeds(){
        return $this->belongsTo(Printed::class, 'media_id');
    }

    protected $fillable = [
        'operator_id', 'editor_id', 'media_id','message', 'operator_email', 'editor_email'
    ];
}

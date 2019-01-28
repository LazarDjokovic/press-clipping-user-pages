<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditorApprovedPrinted extends Model
{
    protected $table = "editor_approved_printed";

    public function printeds(){
        return  $this->belongsTo(Printed::class);
    }

    protected $fillable = [
        'editor_id', 'media_id'
    ];
}

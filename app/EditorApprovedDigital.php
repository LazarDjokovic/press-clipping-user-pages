<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditorApprovedDigital extends Model
{
    protected $table = "editor_approved_digital";

    public function digitals(){
        return  $this->belongsTo(Digital::class);
    }

    protected $fillable = [
        'editor_id', 'media_id'
    ];
}

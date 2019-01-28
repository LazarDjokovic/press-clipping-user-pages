<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Press extends Model
{
    //

    public static function pressValidator($request)
    {
        $validator = Validator::make($request->all(), [
            'id'=>'required',
            'role_name'=>'required',
            'press_type'=>'required',
            'press_id'=>'required'
        ]);

        return $validator;
    }
}

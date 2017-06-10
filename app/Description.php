<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;



class Description extends Model
{
    //


public static function idDescription($dec){
    return Description::where('description', $dec)->orderBy('id', 'desc')->first();
    }
}

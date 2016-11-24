<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Task extends Model
{
    public function distribution()
    {
        return $this->belongsTo('App\Distribution');
    }
}

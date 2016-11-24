<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    //
    public function programmer()
    {
        return $this->hasMany('App\Programmer','id', 'idProg');
    }
    public function task()
    {
        return $this->hasMany('App\Task','id', 'idTask');
    }

}

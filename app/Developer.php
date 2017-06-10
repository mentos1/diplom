<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    //
    public function getLvl(){
        return $this->hasOne('App\level', 'id', 'idLevel');
    }
    public function getSpeciality(){
        return $this->hasOne('App\Speciality', 'id', "idSpeciality");
    }
    public function getTagSpeciality(){
        return $this->hasMany('App\TagSpeciality', 'id', 'TagSpeciality');
    }
}

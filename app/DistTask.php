<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DistTask extends Model
{
    //

    public function getDescription()
    {
        return 0;
    }

    public function getPriority(){
        return $this->hasOne('App\PriorityTask', 'id', 'priority');
    }

    public function getStatus(){
        return $this->hasOne('App\StatusTask', 'id', 'status');
    }

    public function getTechnologies(){
        return $this->hasOne('App\TagSpeciality', 'id', 'technologies');
    }

    public static function getTimeWhenTaskBeFree($id){
            return DB::table('distributions')
                ->where('idProg', $id)
                ->get();
    }
    public static function getActiveProg($id){
            return DB::table('dist_tasks')
                ->where('id', $id)
                ->get();
    }

}

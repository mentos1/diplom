<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Distribution extends Model
{
    //
    public static function getIdSpeciality($id){
        return DB::table('specialities')
            ->where('id', $id)
            ->get();
    }

    public static function getIdLevel($id){
        return DB::table('levels')
            ->where('id', $id)
            ->get();
    }


    public static function getDevelopers($id){
        return DB::table('link_id_dev_id_tas')
            ->join('tag_specialities', 'link_id_dev_id_tas.idTag', '=', 'tag_specialities.id')
            ->where('idDev', $id)
            ->get();
    }

    public static function getDistTasksIdDescription($id){
        return DB::table('link_id_task_id_descriptions')
            ->join('descriptions', 'link_id_task_id_descriptions.idDescription', '=', 'descriptions.id')
            ->where('idTask', $id)
            ->get();
    }//mb first or last

    public static function getDistTasksIdTeches($id){
        return DB::table('link_id_dist_id_teches')
            ->join('tag_specialities', 'link_id_dist_id_teches.idTag', '=', 'tag_specialities.id')
            ->where('idDist', $id)
            ->get();
    }//mb first or last




 /*   public static function getJoin(){
      return  $users = DB::table('distributions')
            ->LeftJoin('dist_tasks', 'distributions.idTask', '=', 'dist_tasks.id')
            ->LeftJoin('developers', 'distributions.idProg', '=', 'developers.id')
            ->get();
    }

    public static function getIdTaskIdDescriptions($id){
        return  $users = DB::table('link_id_task_id_descriptions')
            ->join('dist_tasks', 'link_id_task_id_descriptions.idTask', '=', 'dist_tasks.id')
            ->join('descriptions', 'link_id_task_id_descriptions.idDescription', '=', 'descriptions.id')
            ->where('idTask', '=', $id)
            ->get();
    }

    public static function getIdDevIdTag($id){
        return  $users = DB::table('link_id_dev_id_tas')
            ->join('developers', 'link_id_dev_id_tas.idDev', '=', 'developers.id')
            ->join('tag_specialities', 'link_id_dev_id_tas.idTag', '=', 'tag_specialities.id')
            ->where('idDev', '=', $id)
            ->get();
    }

    public static function getIdDisIdTag($id){
        return  $users = DB::table('link_id_dist_id_teches')
            ->join('dist_tasks', 'link_id_dist_id_teches.idDist', '=', 'dist_tasks.id')
            ->join('tag_specialities', 'link_id_dist_id_teches.idTag', '=', 'tag_specialities.id')
            ->where('idDist', '=', $id)
            ->get();
    }*/

}

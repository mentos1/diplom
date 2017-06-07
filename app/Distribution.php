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

    public static function updateTaskStatus($id,$status){
        DB::table('dist_tasks')
            ->where('id', $id)
            ->update(['status' => $status]);
        return true;
    }

    public static function updateDev($id,$busy){
        DB::table('developers')
            ->where('id', $id)
            ->update(['busy' => $busy]);
        return true;
    }

    public static function getCreate_at_by_TagProject($TagProject){
        return DB::table('dist_tasks')
            ->where('TagProject', $TagProject)
            ->get();
    }





    public static function getPriority($id){
        return DB::table('priority_tasks')
            ->where('id', $id)
            ->get();
    }

    public static function getStatus($id){
        return DB::table('status_tasks')
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


    ///////////////////////////////
    public static function getDev($id){
        return DB::table('distributions')
            //->LeftJoin('developers', 'distributions.idProg', '=', 'developers.id')
            ->where('idTask', $id)
            ->get();
    }
    public static function getWeek(){
        return DB::table('week')
            ->where('id', 1)
            ->get();
    }

    public static function setWeek($week, $year){
        return  DB::table('week')
                ->where('id', 1)
                ->update(['CountWeek' => $week,'CountYears' => $year]);
    }

    public static function AddWeek($week, $year){
        return  DB::table('week')
            ->where('id', 1)
            ->insert(['CountWeek' => $week,'CountYears' => $year]);
    }

    public static function ClearBusy(){
        return DB::table('developers')->update(['busy' => 0]);
    }

    public static function ClearAvailablePerWeek(){
        return  DB::table('developers')
            ->update(['AvailablePerWeek' => 0]);
    }

    public static function setAvailablePerWeek($id, $time){
        return DB::table('developers')
            ->where('id', $id)
            ->update(['AvailablePerWeek' => $time]);
    }
    public static function getAvailablePerWeek($id){
        return DB::table('developers')
            ->where('id', $id)
            ->get();
    }
    public static function getDevFromDistribution($id){
        return DB::table('distributions')
            //->LeftJoin('developers', 'distributions.idProg', '=', 'developers.id')
            ->where('idProg', $id)
            ->get();
    }






    ///////////////////////////////
    public static function getTaskById($id){
        return DB::table('dist_tasks')
            ->where('id', $id)
            ->get();
    }

    ///////////////////////////////
    public static function getDevelopersById($id){
        return DB::table('developers')
            ->where('id', $id)
            ->get();
    }

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

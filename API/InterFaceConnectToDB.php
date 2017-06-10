<?php
use App\Description;
use App\Developer;
use App\DistTask;
use App\level;
use App\LinkIdDevIdTas;
use App\LinkIdDistIdTech;
use App\LinkIdTaskIdDescription;
use App\PriorityTask;
use App\Speciality;
use App\StatusTask;
use App\TagSpeciality;

/**
 * Created by PhpStorm.
 * User: mentos1
 * Date: 10.06.17
 * Time: 1:32
 */
class InterFaceConnectToDB
{

    /*******************Task******************/
    private function addTask($description, $subject, $priority, $status, $TagProject, $estimate, $tagSpeciality){


        if(!empty($description)){
            $msg = new  Description();
            $msg->description = $description;
            $msg->save();
            $idDescription = Description::idDescription($description)->id; // input id description
        }

        $idDistTask = 0;

        $msg = new DistTask();
        $msg->subject = $subject;
        $msg->description = 0;
        $msg->priority = $priority;
        $msg->status = $status;
        $msg->TagProject = $TagProject;
        $msg->estimate = $estimate;
        $msg->technologies = 0;
        $msg->save();

        $dev = DistTask::where('subject', $subject)->get();
        foreach ($dev as $d){
            $idDistTask = $d->id; //находим id DistTask
        }


        $dev = DistTask::where('subject', $subject)->get();
        foreach ($dev as $d){
            $idDistTask = $d->id; //находим id DistTask
        }

        $msg = DistTask::find($idDistTask);
        $msg->technologies = $idDistTask;
        $msg->description = $idDistTask;
        $msg->save();



        foreach($tagSpeciality as $key =>$val){
            if(gettype($key) == "integer"){
                $msg = new LinkIdDistIdTech();
                $msg->idDist = $idDistTask;
                $msg->idTag = $val;
                $msg->save();
            }
        }

        //add описние + всять id и сделать связь по id
        $msg = new LinkIdTaskIdDescription();
        $msg->idTask = $idDistTask;
        $msg->idDescription = $idDescription;
        $msg->save();
    }

    private function getStatusTask(){
        return StatusTask::all();

    }

    private function getPriorityTask(){
        return PriorityTask::all();
    }

    private function getTagSpeciality(){
        return TagSpeciality::all();
    }

    private function getTask($id){
        return DistTask::where('id', $id)->get();
    }

    private function getAllTask(){
        return DistTask::all();
    }

    private function dropTask($id){
        DistTask::where('id', $id)->delete();
    }



/*******************Developer******************/

    private function addDev($firstName, $email, $speciality, $lvl, $tagSpeciality){
        $idDeveloper = 0;

        $msg = new Developer();
        $msg->FirstName = $firstName;
        $msg->LastName = $email;
        $msg->idSpeciality = $speciality;
        $msg->idLevel = $lvl;
        $msg->AvailablePerWeek = 0;
        $msg->TagSpeciality = 0;
        $msg->busy = 0;
        $msg->save();

        $dev = Developer::where('FirstName', $firstName)->where('LastName', $email)->get();
        foreach ($dev as $d){
            $idDeveloper = $d->id;
        }

        $flight = Developer::find($idDeveloper);
        $flight->TagSpeciality = $idDeveloper;
        $flight->save();

        if(empty($tagSpeciality)){
            $msg = new LinkIdDevIdTas();
            $msg->idDev = $idDeveloper;
            $msg->idTag = 6;
            $msg->save();
        }else {
            foreach ($tagSpeciality as $key => $val) {
                if (gettype($key) == "integer") {
                    $msg = new LinkIdDevIdTas();
                    $msg->idDev = $idDeveloper;
                    $msg->idTag = $val;
                    $msg->save();
                }
            }
        }
    }

    private function getLevel(){
        return level::all();
    }

    private function getSpeciality(){
        return Speciality::all();
    }


    private function getDev($id){
        return Developer::where('id', $id)->get();
    }

    private function dropDev($id){
        Developer::where('id', $id)->delete();
    }

    private function getAllDev(){
        return Developer::all();
    }

}
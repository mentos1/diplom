<?php

namespace App\Http\Controllers;

use App\Developer;
use App\Distribution;
use App\DistTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistributionController extends Controller
{
    public function index()
    {
        /////////////////Tag Full Developer////////
        $data_dist = 0;
        $data_dev = 0;
        $Dis = Developer::all();
        $Distribution = Distribution::all();
        $result_Developer = array();
            foreach($Dis as $d){
                foreach ($Distribution as $item){
                    if($item->idProg == $d->id){
                        $dd = new class
                        {
                        };
                        $result_stc = array();
                        $dd->id = $d->id;
                        $dd->FirstName = $d->FirstName;
                        $dd->LastName = $d->LastName;
                        $dd->idSpeciality = Distribution::getIdSpeciality($d->idSpeciality)[0]->speciality;
                        $dd->idLevel = Distribution::getIdLevel($d->idLevel)[0]->lvl;
                        $dd->AvailablePerWeek = $d->AvailablePerWeek;
                        foreach (Distribution::getDevelopers($d->id) as $dist) {
                            array_push($result_stc, $dist->tag);
                        }
                        $dd->TagSpeciality = $result_stc;
                        array_push($result_Developer, $dd);
                    }
                }
            }

        $no_repiat_dev = $result_Developer;

        foreach($Dis as $d) {
            $dd = new class
            {
            };
            $result_stc = array();
            $dd->id = $d->id;
            $dd->FirstName = $d->FirstName;
            $dd->LastName = $d->LastName;
            $dd->idSpeciality = Distribution::getIdSpeciality($d->idSpeciality)[0]->speciality;
            $dd->idLevel = Distribution::getIdLevel($d->idLevel)[0]->lvl;
            $dd->AvailablePerWeek = $d->AvailablePerWeek;
            foreach (Distribution::getDevelopers($d->id) as $dist) {
                array_push($result_stc, $dist->tag);
            }
            $dd->TagSpeciality = $result_stc;
            array_push($result_Developer, $dd);
        }

        foreach ($no_repiat_dev as $elementKey => $element) {
            foreach ($result_Developer as $valueKey => $value) {
                if($element->id == $value->id){
                    unset($result_Developer[$valueKey]);
                }
            }
        }

        $data_dev = $result_Developer;

        /////////////////////////////////////////////////////////////
        $Dis = DistTask::all();
        $result_DistTask = array();
        foreach($Dis as $d){
                $dd = new class
                {
                };
                $result_des = array();
                $result_tech = array();
                $dd->id = $d->id;
                $dd->subject = $d->subject;
                $dd->priority = $d->priority;
                $dd->status = $d->status;
                $dd->estimate = $d->estimate;
                foreach (Distribution::getDistTasksIdDescription($d->description) as $dist) {
                    array_push($result_des, $dist->description);
                }
                foreach (Distribution::getDistTasksIdTeches($d->technologies) as $dist) {
                    array_push($result_tech, $dist->tag);
                }
                $dd->description = $result_des;
                $dd->technologies = $result_tech;
                array_push($result_DistTask, $dd);
        }

        $no_repiat_dev = $result_DistTask;

        $result_DistTask = array();
            foreach($Dis as $d){
                foreach ($Distribution as $item) {
                    if ($item->idTask == $d->id) {
                        $dd = new class
                        {
                        };
                        $result_des = array();
                        $result_tech = array();
                        $dd->id = $d->id;
                        $dd->subject = $d->subject;
                        $dd->priority = $d->priority;
                        $dd->status = $d->status;
                        $dd->estimate = $d->estimate;
                        foreach (Distribution::getDistTasksIdDescription($d->description) as $dist) {
                            array_push($result_des, $dist->description);
                        }
                        foreach (Distribution::getDistTasksIdTeches($d->technologies) as $dist) {
                            array_push($result_tech, $dist->tag);
                        }
                        $dd->description = $result_des;
                        $dd->technologies = $result_tech;
                        array_push($result_DistTask, $dd);
                    }
                }
            }
        //dd($result_DistTask);

        foreach ($no_repiat_dev as $elementKey => $element) {
            foreach ($result_DistTask as $valueKey => $value) {
                if($element->id == $value->id){
                    unset($no_repiat_dev[$elementKey]);
                }
            }
        }

        $data_dist = $no_repiat_dev;

    //dd(Distribution::getDevelopers());
    //dd(Distribution::getJoin());
    //dd(Distribution::getIdTaskIdDescriptions(16));
    //dd(Distribution::getIdDevIdTag(25));
    //dd(Distribution::getIdDisIdTag(19));


        $task = DistTask::all();
        $result = array();
        $result_Prog = array();
        $result_hhh = array();
        $iterator = 0;

        foreach($task as $tsk)
        {
            var_dump($tsk->getPriority());

        }
    dd($task);


    $data = [
        'distTask' => $data_dist,
        'developer' => $data_dev,
    ];
        return view("distribution",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $answer = $request->all();
        //dd($request->all());
        $result = array();
        $i = 0;
        foreach( $answer as $key => $val ) {
            if ($key === "_token" || $key === "task_id") {

            } else {
                $result[$i] = $val;
                $i++;
            }
        }
     for($i = 0; $i < count($result); $i++){
            $msg = new Distribution();
            $msg->idTask = $request->task_id;
            $msg->idProg = $result[$i];
            $msg->save();
        }



        /* $arr = array();
        for()
        array_push($arr,);
               $post = new Mymodel;
                $post = $model->create($request-all());
                $post->save();
        $msg = new Mymodel;
        $msg->name = $request->name;
        $msg->email = $request->email;
        $msg->message = $request->message;
        $msg->save();*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd($id);
        return view('messages.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

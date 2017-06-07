<?php

namespace App\Http\Controllers;

use App\Developer;
use App\Distribution;
use Carbon\Carbon;
use App\DistTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistributionController extends Controller
{
    public function getDaysFormTime($date){
        return floor($date/8);
    }
    public function getHoursFormTime($date){
        return $date % 8;
    }
    public function dateFinishWorks($date_Create,$item){
        if($date_Create->hour >= 18 || $date_Create->hour < 10){
            $date_Create->hour =  10;
        }
        $addDays = $this->getDaysFormTime($item->estimate);
        $addHours = $this->getHoursFormTime($item->estimate);
        if($date_Create->hour + $addHours > 18){
            $date_Create->hour =  10;
            $addHours = ($date_Create->hour + $addHours) - 18;
            $addDays++;
        }

        $date_Create->addDays($addDays)->addHours($addHours);
        $week_day_of_week = $date_Create->dayOfWeek;
        $week_day_of_week = $date_Create->dayOfWeek;
        while($week_day_of_week == 6 || $week_day_of_week == 7){
            $week_day_of_week = $date_Create->dayOfWeek;
            $date_Create->addDays(1);
        }

        return $date_Create;
    }

    function findAllAvailablePerWeek($lastweek){
        $Distribution = Distribution::all();
        foreach($Distribution as $d) {
            $data_create_at = Carbon::parse($d->created_at);
            if($data_create_at->weekOfYear == $lastweek) {
                $task = Distribution::getTaskById($d->idTask);
                Distribution::updateDev($d->idProg,1);
                $dev_AvailablePerWeek = Distribution::getAvailablePerWeek($d->idProg)[0]->AvailablePerWeek;
                Distribution::setAvailablePerWeek($d->idProg,$task[0]->estimate + $dev_AvailablePerWeek );
            }
        }
    }

    function weekGet(){
        $date_from_DB  = Distribution::getWeek();
        if($date_from_DB[0]->CountYears < (Carbon::now()->addHours(3)->year)){
            Distribution::setWeek(Carbon::now()->addHours(3)->weekOfYear, Carbon::now()->addHours(3)->year);
            Distribution::ClearAvailablePerWeek();
            Distribution::ClearBusy();
            $this->findAllAvailablePerWeek((Carbon::now()->addHours(3)->weekOfYear));
        }else{
            if($date_from_DB[0]->CountWeek < (Carbon::now()->addHours(3)->weekOfYear)){
                Distribution::ClearAvailablePerWeek();
                Distribution::ClearBusy();
                $this->findAllAvailablePerWeek((Carbon::now()->addHours(3)->weekOfYear));
                Distribution::setWeek(Carbon::now()->addHours(3)->weekOfYear, Carbon::now()->addHours(3)->year);

            }
        }
        //if($date_from_DB->CountWeek <= (Carbon::now()->addHours(3)->weekOfYear))


    }


    public function index()
    {
        $this->weekGet();
        /////////////////Tag Full Developer////////

        $result = [];
        $result_last = [];

        //dd($data['distribution']);

        // distributions
        $distribution = DistTask::all();
        if(count($distribution) !== 0) {
            foreach ($distribution as $item) {
                if (sizeof(Distribution::getDev($item->id)) > 0)
                    array_push($result, Distribution::getDev($item->id));
            }
        }


        $data_dist = 0;
        $data_dev = 0;
        $result_Developer = [];
        $Dis = Developer::all();
        $Distribution = Distribution::all();

        if(count($Dis) !== 0)
        foreach($Dis as $d) {
            if($d->AvailablePerWeek < 40){
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
                $dd->DaysBeforeStart = 0;
                $dd->HoursBeforeStart = 0;
                $val_dist_task = DistTask::getTimeWhenTaskBeFree($d->id);
                if(count($val_dist_task) !== 0)
                foreach($val_dist_task as $dist){ //перебортасков  с массива распределения
                    $date_Create = Carbon::parse($dist->created_at);
                    $date_Create_T = Carbon::parse($dist->created_at);
                    $date_now = Carbon::now()->addHours(3);
                    $items = DistTask::getActiveProg($dist->idTask); // получения по Тасков по айди
                    if(count($items) !== 0)
                    foreach ($items as $item) {
                            if ($item->status != 4 ){
                                $date = $this->dateFinishWorks($date_Create, $item);
                                /*var_dump($date ." < ". $date_now);
                                var_dump($date->timestamp < $date_now->timestamp);

                                dd($date->dayOfWeek);*/
                                if($date_Create_T->dayOfWeek < $date->dayOfWeek)
                                    $date->addWeekdays(1);

                                if($date->dayOfWeek == 6 || $date->dayOfWeek == 0)
                                    $date->addDays(2);

                                    if($date_Create_T->timestamp < $date_now->timestamp && $date->timestamp > $date_now->timestamp) {
                                        $dd->DaysBeforeStart = $date->dayOfYear - $date_now->dayOfYear;
                                        $dd->HoursBeforeStart = $date->hour - 10;
                                    }
                            }
                        }
                }
                $dd->TagSpeciality = $result_stc;
                array_push($result_Developer, $dd);
            }
        }
        $data_dev = $result_Developer;

        /////////////////////////////////////////////////////////////
        $Dis = DistTask::all();
        $result_DistTask = array();
        if(count($Dis) !== 0)
        foreach($Dis as $d){
            if ($d->status != 4 && count(Distribution::getDev($d->id)) == 0) {
                $dd = new class
                {
                };
                $result_des = array();
                $result_tech = array();
                $dd->id = $d->id;
                $dd->subject = $d->subject;
                $dd->priority = $d->getPriority["priority"];
                $dd->status = $d->getStatus["status"];
                foreach (Distribution::getDistTasksIdDescription($d->description) as $dist) {
                    array_push($result_des, $dist->description);
                }
                foreach (Distribution::getDistTasksIdTeches($d->technologies) as $dist) {
                    array_push($result_tech, $dist->tag);
                }
                $dd->TagProject = $d->TagProject;
                $dd->description = $result_des;
                $dd->technologies = $result_tech;
                $dd->estimate = $d->estimate;
                array_push($result_DistTask, $dd);
            }
        }

        $data_dist = $result_DistTask;

    //dd(Distribution::getDevelopers());
    //dd(Distribution::getJoin());
    //dd(Distribution::getIdTaskIdDescriptions(16));
    //dd(Distribution::getIdDevIdTag(25));
    //dd(Distribution::getIdDisIdTag(19));

        $distTaskController = new DistTaskController();



    $data = [
        'distTask' => $data_dist,
        'developer' => $data_dev,
        'distTaskController' => $distTaskController->index()->getData()
    ];
        return view("distribution", $data);
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

    public  function  checkTask(Request $request){
        if ($request->isMethod('post')) {
            $idTask = DistTask::find($request->idTask);
            $arrDev = $request->dev;
            $dataTime =  $request->dataTime;
            $hoursTime =  $request->hoursTime;
            $pieces_date = explode("/", $dataTime);
            $pieces_time = explode(":", $hoursTime);

            $date_Create = Carbon::create($pieces_date[2], $pieces_date[0], $pieces_date[1], $pieces_time[0], $pieces_time[1]);
            $date_Create_T = Carbon::create($pieces_date[2], $pieces_date[0], $pieces_date[1], $pieces_time[0], $pieces_time[1]);
            $before = $this->dateFinishWorks($date_Create, $idTask); // тут

            $answer_AvailablePerWeek = true;
            $answer_created_at = true;
            $answer_weeked = true;
            for($i = 0; $i < count($arrDev); $i++){
                if(count(Distribution::getDevelopersById($arrDev[$i])) != 0) {
                    $dev = Distribution::getDevelopersById($arrDev[$i]);
                    $availablePerWeek = $dev[0]->AvailablePerWeek;
                    if ($availablePerWeek + ($idTask->estimate) / count($arrDev) <= 40) {
                        $answer_AvailablePerWeek = true;
                    } else {
                        $answer_AvailablePerWeek = false;
                    }
                }
            }
            for($i = 0; $i < count($arrDev); $i++){
                if(count(Distribution::getDevFromDistribution($arrDev[$i])) != 0) {
                    $dev = Distribution::getDevFromDistribution($arrDev[$i]);
                    for ($j = 0; $j < count($dev); $j++) {
                        $createdAt = $dev[$j]->created_at;
                        $data_created_at_T = Carbon::parse($createdAt);
                        $data_created_at = Carbon::parse($createdAt);
                        $before_T = $this->dateFinishWorks($data_created_at, DistTask::find($dev[$j]->idTask));
                        if ($date_Create_T > $before_T || $before < $data_created_at_T) {
                            $answer_created_at = true;
                        } else {
                            $answer_created_at = false;
                        }
                    }
                }
            }
            $week_day_of_week = $date_Create_T->dayOfWeek;
            if($week_day_of_week == 6 || $week_day_of_week == 0){
                $answer_weeked = false;
            }

            return response()->json(['answer_AvailablePerWeek' => $answer_AvailablePerWeek, 'answer_created_at' => $answer_created_at, 'weeked' => $answer_weeked]);
        }
        return response()->json(['response' => false]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //добавть проверить

            $answer = $request->all();
            $result = array();
            $i = 0;
            $b = false;
            foreach ($answer as $key => $val) {
                if ($key === "_token" || $key === "task_id" || $key === "check" || $key === "data_send" || $key === "data_time") {
                    $b = true;
                } else {
                    if ($b) {
                        Distribution::updateDev($val, 1);
                        $result[$i] = $val;
                        $i++;
                    }
                }
            }
            $Dist_task_estimate = DistTask::find($request->task_id)->estimate;
            //Distribution::where('idTask', $request->task_id)->delete();
            $AvailibelPerWeek = $Dist_task_estimate / count($result);

/*
            $msg = DistTask::find($request->task_id);
            if ($msg->status < 4)
                $msg->status = $msg->status + 1;
            $msg->save();*/
             for($i = 0; $i < count($result); $i++){
                    $msg = new Distribution();
                    $msg->idTask = $request->task_id;
                    $msg->idProg = $result[$i];
                    $pieces_date = explode("/", $request->data_send);
                    $pieces_time = explode(":", $request->data_time);
                    $msg->created_at = Carbon::create($pieces_date[2], $pieces_date[0], $pieces_date[1], $pieces_time[0], $pieces_time[1]);
                    $msg->save();

             }

            for($i = 0; $i < count($result); $i++){
                $msg = Developer::find($result[$i]);
                $msg->AvailablePerWeek += $AvailibelPerWeek;
                $msg->save();
            }


        $this->index()->getData();
        return view("distribution",$this->index()->getData());
        /*
                $arr = array();
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


    public function adviceTask(Request $request){
        if ($request->isMethod('post')){
            $msg = DistTask::find($request->id);
            $result_tech = [];
            $result_DistTask = [];
            foreach (Distribution::getDistTasksIdTeches($msg->technologies) as $dist) {
                array_push($result_tech, $dist->tag);
            }
            $msg = Developer::all();
            foreach ($msg as $item) {
                $result_stc = [];
                $dd = new class
                {
                };
                $dd->id = $item->id;
                foreach (Distribution::getDevelopers($item->id) as $dist) {
                    array_push($result_stc, $dist->tag);
                }
                $dd->tag = $result_stc;
                array_push($result_DistTask, $dd);
            }
            $gCounter = 0;
            foreach($result_DistTask as $it_Dev){
                foreach ($result_tech as $it_Task){
                    if (in_array($it_Task, $it_Dev->tag)) {
                        $gCounter++;
                    }
                }
                $it_Dev->counter = $gCounter;
                $gCounter = 0;
            }

            for ($j = 0; $j < count($result_DistTask) - 1; $j++){
                for ($i = 0; $i < count($result_DistTask) - $j - 1; $i++){
                    // если текущий элемент больше следующего
                    if ($result_DistTask[$i]->counter > $result_DistTask[$i + 1]->counter){
                        // меняем местами элементы
                        $tmp_var = $result_DistTask[$i + 1];
                        $result_DistTask[$i + 1] = $result_DistTask[$i];
                        $result_DistTask[$i] = $tmp_var;
                    }
                }
            }


            return response()->json(['response' => $result_DistTask]);
        }
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

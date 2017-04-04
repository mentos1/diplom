<?php

namespace App\Http\Controllers;

use App\LinkIdDistIdTech;
use Illuminate\Http\Request;
use App\LinkIdTaskIdDescription;
use App\Description;
use App\Distribution;
use App\Developer;
use App\DistTask;
use Carbon\Carbon;
use App\PriorityTask;
use App\Speciality;
use App\StatusTask;
use App\TagSpeciality;

class HomeController extends Controller
{
    public function index()
    {
//orderBy('created_at','desc')->get()
        /*        $date = [
                    'title' => 'Гостевая книга Laravel 5.3',
                    'page_title' => 'Гостевая книга',
                    'messages' => Mymodel::latest()->paginate(1),
                    'count' => Mymodel::count()
                ];*/
        $time_now = Carbon::now();
        //dd($time_now);
        $result = [];
        $result_last = [];

        //dd($data['distribution']);

        // distributions
        $distribution = DistTask::all();
        foreach ($distribution as $item){
            if(sizeof(Distribution::getDev($item->id)) > 0)
            array_push($result, Distribution::getDev($item->id));
        }

        foreach ($result as $it) {
            foreach ($it as $item) {
                $task = Distribution::getTaskById($item->idTask)[0];
                $dev = Distribution::getDevelopersById($item->idProg)[0];
                if($task->estimate <= 8){
                    $time_estime = ceil($task->estimate) * 60 * 60;
                }else{
                    $time_estime = ceil($task->estimate / 8) * 24 * 60 *60;
                }
                $time_create = Carbon::parse($item->created_at);
                if(($time_create->timestamp + $time_estime) >= $time_now->timestamp){
                    Distribution::updateDev($dev->id,1);
                }else{
                    if(Distribution::getStatus($task->status)[0]->status == "inqa" || Distribution::getStatus($task->status)[0]->status == "complete"){
                        Distribution::updateTaskStatus($task->id,4); //incomplite
                        Distribution::updateDev($dev->id,0);
                    }else{
                        // Distribution::updateTaskStatus($task->id,5); //inexpect
                        Distribution::updateDev($dev->id,0);
                    }
                }
            }
        }



        $b = true;
        foreach ($result as $it) {
            $b = true;
            $result_dev = [];
            $dd = new class
            {
            };
            foreach ($it as $item) {
                    $task = Distribution::getTaskById($item->idTask)[0];
                    $dev = Distribution::getDevelopersById($item->idProg)[0];
                    $d = new class
                    {
                    };
                    $result_des = array();
                    $result_tech = array();
                    $result_stc = array();
                    $time_now = Carbon::now();

                    ///////////////////////////task////////////
                    if($b) {
                        //dd($task);
                        $time_create = Carbon::parse($item->created_at);
                        if($task->estimate <= 8){
                            $time_estime = ceil($task->estimate) * 60 * 60;
                        }else{
                            $time_estime = ceil($task->estimate / 8) * 24 * 60 *60;
                        }
                        $dd->id = $task->id;
                        $dd->subject = $task->subject;
                        $dd->created_at = $item->created_at;
                        $dd->updated_at = $item->updated_at;
                        $dd->priority = Distribution::getPriority($task->priority)[0]->priority;
                        $dd->status = Distribution::getStatus($task->status)[0]->status;
                        $dd->case = "active";
                        if(($time_create->timestamp + $time_estime) <= $time_now->timestamp){
                            $dd->case = "inexpect";
                        }
                        if(Distribution::getStatus($task->status)[0]->status === "complete"){
                            $dd->case = "complete";
                        }
                        $dd->technologies = $task->technologies;
                        $dd->estimate = $task->estimate;
                        foreach (Distribution::getDistTasksIdDescription($task->description) as $dist) {
                            array_push($result_des, $dist->description);
                        }
                        foreach (Distribution::getDistTasksIdTeches($task->technologies) as $dist) {
                            array_push($result_tech, $dist->tag);
                        }
                        $dd->description = $result_des;
                        $dd->technologies = $result_tech;
                        $b = false;
                    }
                    /////////////////////////////dev////////////
                    $d->id= $dev->id;
                    $d->FirstName = $dev->FirstName;
                    $d->LastName = $dev->LastName;
                    $d->idSpeciality = Distribution::getIdSpeciality($dev->idSpeciality)[0]->speciality;
                    $d->idLevel = Distribution::getIdLevel($dev->idLevel)[0]->lvl;
                    $d->AvailablePerWeek = $dev->AvailablePerWeek;
                    foreach (Distribution::getDevelopers($dev->id) as $dist) {
                        array_push($result_stc, $dist->tag);
                    }
                    $d->TagSpeciality = $result_stc;
                array_push($result_dev, $d);
            }
            $dd->developers = $result_dev;
            array_push($result_last, $dd);
        }
        //dd($result_last);

        $data = [
            'distribution' => $result_last
        ];

        //dd($data);

        return view("home",$data);
    }

    public function drop(Request $request){
        if ($request->isMethod('post')){
            Distribution::where("updated_at" , $request->time_created_at)->where("idTask", $request->id)->delete();
            DistTask::find($request->id)->delete();
            foreach ($request->dev as $item){
                Distribution::updateDev($item,0);
            }
            return response()->json(['response' => 'This is post method']);
        }
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
        //dd($id);
        /////////////////////////////////////////////////////////////
        $Dis = DistTask::all();
        $Distribution = Distribution::all();
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
        $d = DistTask::find($id);
        $task = new class{};
        $result_des = array();
        $result_tech = array();
        $task->id = $d->id;
        $task->subject = $d->subject;
        $task->priority = Distribution::getPriority($d->priority)[0]->priority;
        $task->status = Distribution::getStatus($d->status)[0]->status;
        $task->estimate = $d->estimate;
        foreach (Distribution::getDistTasksIdDescription($d->description) as $dist) {
            $objDescrip = new class{};
            $objDescrip->id = $dist->id;
            $objDescrip->description = $dist->description;
            array_push($result_des, $objDescrip);
        }
        foreach (Distribution::getDistTasksIdTeches($d->technologies) as $dist) {
            $objDescrip = new class{};
            $objDescrip->id = $dist->id;
            $objDescrip->tag = $dist->tag;
            array_push($result_tech, $objDescrip);
        }
        $task->description = $result_des;
        $task->technologies = $result_tech;
        $data = [
            'newTask' => $task,
            'priority' => PriorityTask::all(),
            'status' => StatusTask::all(),
            'tag1' => TagSpeciality::all(),
            'speciality' => Speciality::all(),
        ];
        //dd($data);

        return view("updateTask",$data);
    }

    public function replace(Request $request){
        if ($request->isMethod('post')){
 /*           Distribution::where("updated_at" , $request->time_created_at)->where("idTask", $request->id)->delete();
            DistTask::find($request->id)->delete();
            foreach ($request->dev as $item){
                Distribution::updateDev($item,0);
            }*/
            $msg = DistTask::find($request->id);
            $msg->subject = $request->subject;
            $msg->priority = $request->priority;
            $msg->status = $request->status;
            $msg->estimate = $request->estimate;
            $msg->save();
            if(count($request->descriptions_drop) != 0) {
                foreach ($request->descriptions_drop as $item) {
                    Description::find($item)->delete();
                }
            }
            if(count($request->tags_drop) != 0) {
                foreach ($request->tags_drop as $item) {
                    LinkIdDistIdTech::where('idDist' , $request->id)->where("idTag" , $item)->delete();
                }
            }
            if($request->descriptions != "") {
                if ($request->actionDiscrip == "AddNew") {
                    $des = new  Description();
                    $des->description = $request->descriptions;
                    $des->save();
                    $idDescription = Description::idDescription($request->descriptions)->id;
                    $des = new LinkIdTaskIdDescription();
                    $des->idTask = $request->id;
                    $des->idDescription = $idDescription;
                    $des->save();
                } else {
                    $des = Description::find($request->descriptions_first_id);
                    $des->description = $request->descriptions;
                    $des->save();
                }
            }

            if(count($request->tags) != 0) {
                foreach ($request->tags as $item) {
                    LinkIdDistIdTech::where('idDist' , $request->id)->where("idTag" , $item)->delete();
                    $itm = new LinkIdDistIdTech();
                    $itm->idDist = $msg->id;
                    $itm->idTag = $item;
                    $itm->save();
                }
            }
            return response()->json(['response' => $request->tags, 'response1' => $request->tags_drop, 'descriptions_drop' => $request->descriptions_drop]);
        }
    }

    public function continueTask(Request $request, $id){
        /////////////////Tag Full Developer////////
        $time_now = Carbon::now();
        $result = [];
        $result_last = [];

        //dd($data['distribution']);

        // distributions
        $distTask = DistTask::all();
        foreach ($distTask  as $item){
            if(sizeof(Distribution::getDev($item->id)) > 0)
                array_push($result, Distribution::getDev($item->id));
        }

        foreach ($result as $it) {
            foreach ($it as $item) {
                $task = Distribution::getTaskById($item->idTask)[0];
                $dev = Distribution::getDevelopersById($item->idProg)[0];
                $time_estime = ceil($task->estimate / 8) * 24 * 60 *60;
                $time_create = Carbon::parse($item->created_at);
                if(($time_create->timestamp + $time_estime) >= $time_now->timestamp){
                    Distribution::updateDev($dev->id,1);
                }else{
                    if(Distribution::getStatus($task->status)[0]->status == "inqa" || Distribution::getStatus($task->status)[0]->status == "complete"){
                        Distribution::updateTaskStatus($task->id,4); //incomplite
                        Distribution::updateDev($dev->id,0);
                    }else{
                        Distribution::updateTaskStatus($task->id,5); //inexpect
                        Distribution::updateDev($dev->id,0);
                    }
                }
            }
        }

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
                    if($d->busy != 0) {
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
            $dd->priority = $d->getPriority["priority"];
            $dd->status = $d->getStatus["status"];
            foreach (Distribution::getDistTasksIdDescription($d->description) as $dist) {
                array_push($result_des, $dist->description);
            }
            foreach (Distribution::getDistTasksIdTeches($d->technologies) as $dist) {
                array_push($result_tech, $dist->tag);
            }
            $dd->description = $result_des;
            $dd->technologies = $result_tech;
            $dd->estimate = $d->estimate;
            array_push($result_DistTask, $dd);
        }

        $no_repiat_dev = $result_DistTask;

        $result_DistTask = array();
        foreach($Dis as $d){
            foreach ($Distribution as $item) {
                if ($item->idTask == $d->id) {
                    if($d->status != 5 || $d->id != $id) {
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
        }


        foreach ($no_repiat_dev as $elementKey => $element) {
            foreach ($result_DistTask as $valueKey => $value) {
                if($element->id == $value->id){
                    unset($no_repiat_dev[$elementKey]);
                }
            }
        }

        //dd($no_repiat_dev);

        $data_dist = $no_repiat_dev;
        $data_week = [];
        $dt = Carbon::now();
        for ($i=0; $i < 7; $i++){
            array_push($data_week,$dt->format('l'));
            $dt = $dt->addDay();
        }

        //dd($data_week);

        //dd(Distribution::getDevelopers());
        //dd(Distribution::getJoin());
        //dd(Distribution::getIdTaskIdDescriptions(16));
        //dd(Distribution::getIdDevIdTag(25));
        //dd(Distribution::getIdDisIdTag(19));



        $data = [
            'dataWeek' => $data_week,
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
    public function store(Mymodel $model, Request $request)
    {
        //dd($request->all());
        /*        $post = new Mymodel;
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
        dd("dd");
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

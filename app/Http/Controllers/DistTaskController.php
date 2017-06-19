<?php

namespace App\Http\Controllers;

use App\Developer;
use App\DistTask;
use App\LinkIdDistIdTech;
use App\Distribution;
use App\LinkIdTaskIdDescription;
use App\PriorityTask;
use App\Speciality;
use App\StatusTask;
use App\TagSpeciality;
use Illuminate\Http\Request;
use App\Description;
use Illuminate\Support\Facades\DB;


class DistTaskController extends Controller
{
    public function index()
    {

        $status = StatusTask::all();
        $arr_status = [];
        foreach ($status as $item) {
            if($item->status !== "complete"){
                array_push($arr_status,$item);
            }
        }


        $data = [
            'distTask' => DistTask::all(),
            'priority' => PriorityTask::all(),
            'status' => $arr_status,
            'tag' => TagSpeciality::all(),
            'speciality' => Speciality::all(),
        ];

        return view("dist_tasks",$data);
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
        $request->description;

        $msg = new  Description();
        $msg->description = $request->description;
        $msg->save();


        //dd(Description::idDescription($request->description)->id); // input id description
        $idDescription = Description::idDescription($request->description)->id; // input id description



        $answer = $request->all();
        $result = [];
        $count = 0;
        $idDistTask = 0;

        foreach($answer as $key =>$val){
            if(gettype($key) == "integer"){
                $result[$count] = $val;
                $count++;
            }
        }
        //  dd($resulte);
        $msg = new DistTask();
        $msg->subject = $request->subject;
        $msg->description = 0;
        $msg->priority = $request->priority;
        $msg->status = $request->status;
        $msg->TagProject = $request->TagProject;
        $msg->estimate = (int)$request->estimate;
        $msg->technologies = 0;
        $msg->save();



        $dev = DistTask::where('subject', $request->subject)->get();
        foreach ($dev as $d){
            $idDistTask = $d->id; //находим id DistTask
        }


        $msg = DistTask::find($idDistTask);
        $msg->technologies = $idDistTask;
        $msg->description = $idDistTask;
        $msg->save();



        foreach($answer as $key =>$val){
            if(gettype($key) == "integer"){
                $msg = new LinkIdDistIdTech();
                $msg->idDist = $idDistTask;
                $msg->idTag = $val;
                $msg->save();
            }
        }



        //add описние + всять id и сделать связб по id
        $msg = new LinkIdTaskIdDescription();
        $msg->idTask = $idDistTask;
        $msg->idDescription = $idDescription;
        $msg->save();

        return $this->index();





        /*      $contents = Storage::get("t1234567");
                dd($contents);*/

        /*$answer = $request->all();
        $result = [];
        $count = 0;
        foreach($answer as $key =>$val){
            if(gettype($key) == "integer"){
                $result[$count] = $val;
                $count++;
            }
        }
        //  dd($resulte);
        for($i = 0; $i < count($result); $i++) {
            $msg = new Developer();
            $msg->FirstName = $request->firstName;
            $msg->LastName = $request->lastName;
            $msg->idSpeciality = $request->speciality;
            $msg->idLevel = $request->lvl;
            $msg->AvailablePerWeek = $request->AvailablePerWeek;
            $msg->TagSpeciality = $result[$i];
            $msg->save();
        }

                $arr = array();
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

    public function drop(Request $request)
    {
        $dev = Distribution::getDevelopersById($request->DropTaskId);
        $task = DistTask::where('id', $request->DropTaskId)->get();
        foreach ($dev as $it){
            Developer::where("id", $it->id)->get()[0]->AvailablePerWeek  = Developer::where("id", $it->id)->get()[0]->AvailablePerWeek - $task[0]->estimate / count($dev);
        }
        DistTask::where('id', $request->DropTaskId)->delete();
        DB::table('link_id_dist_id_teches')->where('idDist', $request->DropTaskId)->delete();
        DB::table('link_id_task_id_descriptions')->where('idTask', $request->DropTaskId)->delete();
        DB::table('distributions')->where('idTask', $request->DropTaskId)->delete();
        return redirect('distTask');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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

    public function destroy($id)
    {
        //
    }
}

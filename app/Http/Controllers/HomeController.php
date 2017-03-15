<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Developer;
use App\Distribution;
use App\DistTask;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
                    ///////////////////////////task////////////
                    if($b) {
                        $dd->id = $task->id;
                        $dd->subject = $task->subject;
                        $dd->created_at = $item->created_at;
                        $dd->updated_at = $item->updated_at;
                        $dd->priority = Distribution::getPriority($task->priority)[0]->priority;
                        $dd->status = Distribution::getStatus($task->status)[0]->status;
                        $dd->case = "active";
                        if(Distribution::getStatus($task->status)[0]->status === "complete"){
                            $dd->case = "complete";
                        }
                        if(Distribution::getStatus($task->status)[0]->status === "inexpect"){
                            $dd->case = "inexpect";
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

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

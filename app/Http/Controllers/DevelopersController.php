<?php

namespace App\Http\Controllers;

use App\Developer;
use App\DistTask;
use App\LinkIdDevIdTas;
use App\Distribution;
use App\Speciality;
use App\TagSpeciality;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\level;
use Illuminate\Support\Facades\DB;

class DevelopersController extends Controller
{
    public function index()
    {

        $data = [
            'data_dev'=> Developer::all(),
            'level' => level::all(),
            'developer' => Developer::all(),
            'speciality' => Speciality::all(),
            'tag' => TagSpeciality::all(),
        ];

        return view("developers",$data);
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
    //dd($request->all());
    $answer = $request->all();
    $result = [];
    $count = 0;

    //dd($result);

    // need update
    $idDeveloper = 0;

    $msg = new Developer();
    $msg->FirstName = $request->firstName;
    $msg->LastName = $request->lastName;
    $msg->idSpeciality = $request->speciality;
    $msg->idLevel = $request->lvl;
    $msg->AvailablePerWeek = $request->AvailablePerWeek;
    $msg->TagSpeciality = 0;
    $msg->busy = 0;
    $msg->save();

    $dev = Developer::where('FirstName', $request->firstName)->where('LastName', $request->lastName)->get();
    foreach ($dev as $d){
        $idDeveloper = $d->id;
    }

    $flight = Developer::find($idDeveloper);
    $flight->TagSpeciality = $idDeveloper;
    $flight->save();

    if(empty($answer)){
        $msg = new LinkIdDevIdTas();
        $msg->idDev = $idDeveloper;
        $msg->idTag = 6;
        $msg->save();
    }else{
        foreach($answer as $key =>$val){
            if(gettype($key) == "integer"){
                $msg = new LinkIdDevIdTas();
                $msg->idDev = $idDeveloper;
                $msg->idTag = $val;
                $msg->save();
            }
        }
    }

    return $this->index();




/*
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }


    public function drop(Request $request)
    {
        Developer::where('id', $request->DropDevId)->delete();
        DB::table('link_id_dev_id_tas')->where('idDev', $request->DropDevId)->delete();
        DB::table('distributions')->where('idProg', $request->DropDevId)->delete();
        return redirect('distTask');
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

        $result_stc = [];
        $dev = Developer::where('id', $id)->get();
        $dev[0]->idSpeciality = Distribution::getIdSpeciality($dev[0]->idSpeciality)[0]->speciality;
        $dev[0]->idLevel = Distribution::getIdLevel($dev[0]->idLevel)[0]->lvl;
        foreach (Distribution::getDevelopers($dev[0]->id) as $dist) {
            array_push($result_stc, $dist->tag);
        }
        $dev[0]->TagSpeciality = $result_stc;

        $data = [
            'dev'=> $dev[0],
            //'data_dev'=> $data_dev,
            'level' => level::all(),
            //'developer' => Developer::all(),
            'speciality' => Speciality::all(),
            'tag1' => TagSpeciality::all(),
        ];


        return view("developerUpdate",$data);
    }

    public function replace(Request $request)
    {
        if ($request->isMethod('post')) {
            /*           Distribution::where("updated_at" , $request->time_created_at)->where("idTask", $request->id)->delete();
                       DistTask::find($request->id)->delete();
                       foreach ($request->dev as $item){
                           Distribution::updateDev($item,0);
                       }*/
            $msg = Developer::find($request->id);
            $msg->FirstName = $request->FirstName;
            $msg->LastName = $request->LastName;
            $msg->idSpeciality = $request->speciality;
            $msg->idLevel = $request->lvl;
            $msg->AvailablePerWeek = $request->AvailablePerWeek;
            $msg->save();

            $tag = $request->tags_drop;
            if (count($request->tags_drop) != 0) {
                foreach ($request->tags_drop as $item) {
                    $tag = DB::table("tag_specialities")->where("tag", $item)->get();
                    $tag = $tag[0]->id;
                    LinkIdDevIdTas::where('idDev', $request->id)->where("idTag", $tag)->delete();
                }
            }

            if (count($request->tags) != 0) {
               foreach ($request->tags as $item) {
                    LinkIdDevIdTas::where('idDev', $request->id)->where("idTag", $item)->delete();
                    $itm = new LinkIdDevIdTas();
                    $itm->idDev = $msg->id;
                    $itm->idTag = $item;
                    $itm->save();
                }
            }
            return response()->json(['response' => "true"]);
        }
        return response()->json(['response' => "GET"]);
    }

}

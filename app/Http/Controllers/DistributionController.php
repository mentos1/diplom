<?php

namespace App\Http\Controllers;

use App\Distribution;
use App\Programmer;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistributionController extends Controller
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

       //$msr =$ms[0]->id;
        //dd(empty($ms));

        $mas = Task::all();
        $result = array();
        $iterator = 0;
        foreach( $mas as $key => $val )
        {
            $ms = DB::select('select * from distributions where idTask = ?', [$mas[$iterator]->getAttributes()["id"]]);
            if(empty($ms)){
                $result[$key] = $val;
            }
            $iterator++;
        }
        //dd($result); // добавить в массив
        $tasks = $result;

        $mas = Programmer::all();
        //dd($mas);
        $result = array();
        $iterator = 0;
        foreach( $mas as $key => $val )
        {
            $ms = DB::select('select * from distributions where idProg = ?', [$mas[$iterator]->getAttributes()["id"]]);
            if(empty($ms)){
                $result[$key] = $val;
            }
            $iterator++;
        }
        $progs = $result;
        $ms = DB::select('select * from distributions');
        //dd($tasks);
        //dd($arr_P);

        $date = [
            'programmer' => $progs,
            'tasks' => $tasks,
            'count' => Programmer::count()
        ];

        return view("distribution",$date);
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

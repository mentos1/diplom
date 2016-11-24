<?php

namespace App\Http\Controllers;

use App\Distribution;
use App\Task;
use App\Programmer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StatisticsController extends Controller
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

//        $mas = Programmer::all();
//        $result = array();
//        $iterator = 0;
//        foreach( $mas as $key => $val )
//        {
//            $ms = DB::select('select * from distributions where idProg = ?', [$mas[$iterator]->getAttributes()["id"]]);
//            if(!empty($ms)){
//                $result[$key] = $val;
//            }
//            $iterator++;
//        }
//        $progs = $result;
//        $ms = DB::select('select * from distributions');
//        //dd($ms[0]);


        $task = Task::all();
        $result = array();
        $result_Prog = array();
        $result_hhh = array();
        $iterator = 0;

        foreach($task as $key => $val )
        {
            $ms = DB::select('select * from distributions where idTask = ?', [$task[$iterator]->getAttributes()["id"]]);
            if(!empty($ms)){
                $result[$key] = $val;

                $rA = DB::select('select idProg from distributions where idTask = ?', [$val->getAttributes()["id"]]);
                //dd($val->getAttributes()["id"]);
                $key_id = $val->getAttributes()["id"];
                foreach($rA as $key => $val ){
                    $result_Prog[$key] = DB::select('select name from programmers where id = ?', [$rA[$key]->idProg]);
                }
                $val_prog = $result_Prog;
                //dd($result_Prog);

                $result_hhh[$key_id] = $result_Prog;
            }
            $iterator++;

        }
        //dd($result_hhh);
        //dd($result);


        $distribution = Distribution::all();




        $date = [
            'distribution' => $distribution,
            'result_hhh' =>$result_hhh,
        ];




        return view("statistics",$date);
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
    public function store( Request $request)
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

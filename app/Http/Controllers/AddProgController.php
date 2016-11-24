<?php

namespace App\Http\Controllers;

use App\Programmer;
use Illuminate\Http\Request;


class AddProgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//orderBy('created_at','desc')->get()
/*        $date = [
            'title' => 'Гостевая книга Laravel 5.3',
            'page_title' => 'Гостевая книга',
            'messages' => Mymodel::latest()->paginate(1),
            'count' => Mymodel::count()
        ];*/

        return view("index");
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
        /*        $post = new Mymodel;
                $post = $model->create($request-all());
                $post->save();*/
        $msg = new Programmer();
        $msg->name = $request->Name;
        $msg->level = $request->Level;
        $msg->Directions = $request->Directions;
        $msg->img = $request->File;
        $msg->save();
        return view("index");
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

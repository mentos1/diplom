<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/*Route::get('/', function () {
    return view('index');
});*/

//тоже что и prog
Route::get('/developer',['uses' => "DevelopersController@index", "as" => "AddDevCont"]);
Route::post('/developer/post',['uses' => "DevelopersController@index", "as" => "PostDevCont"]);


Route::get('/programmer',['uses' => "AddProgController@index", "as" => "AddProg"]);
Route::post('programmer/post',['uses' => "AddProgController@index", "as" => "PostProg"]);
///////////////////////////////////

///////////////////home////////////////
Route::get('/',['uses' => "HomeController@index", "as" => "home"]);
Route::post('/',['uses' => "HomeController@drop", "as" => "homeDrop"]);
Route::post('/update/{id}',['uses' => "HomeController@update", "as" => "homeDrop"]);
Route::post('/distribution/send/{id}',['uses' => "HomeController@continueTask", "as" => "continueTask"]);
Route::post('/replace',['uses' => "HomeController@replace", "as" => "homeDrop"]);
/////////////////////

/////////////////////

Route::get('/distribution',['uses' => "DistributionController@index", "as" => "distribution"]);
Route::post('/distribution/edit',['uses' => "DistributionController@edit", "as" => "PostDistribution"]);
Route::post('/distribution/post',['uses' => "DistributionController@store", "as" => "StoreDistribution"]);
Route::post('/distribution/advice/{id}',['uses' => "DistributionController@adviceTask", "as" => "AdviceTask"]);
Route::post('/distribution/checkTask',['uses' => "DistributionController@checkTask", "as" => "CheckTask"]);


Route::get('/statistics',['uses' => "StatisticsController@index", "as" => "statistics"]);
Route::get('/distTask',['uses' => "DistTaskController@index", "as" => "DistTaskCont"]);
Route::post('/distTask/drop',['uses' => "DistTaskController@drop", "as" => "PostDistTaskDrop"]);
Route::post('distTask/post',['uses' => "DistTaskController@index", "as" => "PostDistTaskCont"]);

$router->resource('programmer/post','AddProgController');
$router->resource('/distTask/post','DistTaskController');
$router->resource('/developer/post','DevelopersController');
$router->resource('task/post','AddTaskController');


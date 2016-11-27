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
/////////////////////

////////////////task//////////////////
Route::get('/task',['uses' => "AddTaskController@index", "as" => "AddTask"]);
Route::post('/task/post',['uses' => "AddTaskController@index", "as" => "PostTask"]);
/////////////////////

Route::get('/distribution',['uses' => "DistributionController@index", "as" => "distribution"]);
Route::post('/distribution/post',['uses' => "DistributionController@index", "as" => "PostDistribution"]);


Route::get('/statistics',['uses' => "StatisticsController@index", "as" => "statistics"]);
Route::get('/distTask',['uses' => "DistTaskController@index", "as" => "DistTaskCont"]);
Route::post('distTask/post',['uses' => "DistTaskController@index", "as" => "PostDistTaskCont"]);

$router->resource('programmer/post','AddProgController');
$router->resource('/distTask/post','DistTaskController');
$router->resource('/developer/post','DevelopersController');
$router->resource('task/post','AddTaskController');
$router->resource('/distribution/post','DistributionController');


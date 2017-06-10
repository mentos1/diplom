<?php

namespace App\Http\Controllers;

use App\LinkIdDistIdTech;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
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
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function createTask($dd, $task){
        $result_des = [];
        $result_tech = [];
        $dd->id = $task->id;
        $dd->subject = $task->subject;
        $dd->project = $task->TagProject;
        $dd->priority = Distribution::getPriority($task->priority)[0]->priority;
        $dd->status = Distribution::getStatus($task->status)[0]->status;
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
        return $dd;
    }
    public function createDev($d,$dev){
        $result_stc = [];
        $d->id = $dev->id;
        $d->FirstName = $dev->FirstName;
        $d->LastName = $dev->LastName;
        $d->idSpeciality = Distribution::getIdSpeciality($dev->idSpeciality)[0]->speciality;
        $d->idLevel = Distribution::getIdLevel($dev->idLevel)[0]->lvl;
        $d->AvailablePerWeek = $dev->AvailablePerWeek;
        foreach (Distribution::getDevelopers($dev->id) as $dist) {
            array_push($result_stc, $dist->tag);
        }
        $d->TagSpeciality = $result_stc;
        return $d;
    }

    public function index()
    {
//orderBy('created_at','desc')->get()
        /*        $date = [
                    'title' => 'Гостевая книга Laravel 5.3',
                    'page_title' => 'Гостевая книга',
                    'messages' => Mymodel::latest()->paginate(1),
                    'count' => Mymodel::count()
                ];*/
        $result = [];
        $result_last = [];

        //dd($data['distribution']);

        // distributions
        $distribution = DistTask::all();
        foreach ($distribution as $item){
            if(sizeof(Distribution::getDev($item->id)) > 0)
            array_push($result, Distribution::getDev($item->id));
        }

        if(isset($result))
        foreach ($result as $it) {
            foreach ($it as $item) {
                $task = Distribution::getTaskById($item->idTask)[0];
                $date_Create = Carbon::parse($item->created_at);
                $date_Create_T = Carbon::parse($item->created_at);
                $date_Finish = (new DistributionController())->dateFinishWorks($date_Create,$task);
                $date_now = Carbon::now()->addHours(3);
                if($date_Finish->timestamp < $date_now->timestamp){
                    $msg = DistTask::find($task->id);
                    $msg->status = 4;
                    $msg->save();
                }
            }
        }


        $arrCreatedTask = [];
/*        foreach ($result as $it) {
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
                $createdTask = new class
                {
                };
                $counte_status  = 0;
                $result_des = array();
                $result_tech = array();
                $result_stc = array();
                $time_now = Carbon::now();


                if(!$b){
                    foreach ($arrCreatedTask  as $it_CreatedTask){
                        if($it_CreatedTask->id === $task->id){
                            foreach ($it_CreatedTask->status as $it_stat){
                                if($task->status == $it_stat){
                                    $counte_status++;
                                }
                            }
                            if($counte_status == 0){
                                array_push($it_CreatedTask->status,$task->status);
                            }else{

                            }
                            $counte_status = 0;
                            /*if(in_array($task->status,$it_CreatedTask->status)){
                                // add new dev
                            }else{
                                array_push($createdTask->status,$task->status);
                            }
                        }

                    }
                }



                ///////////////////////////task////////////
                if ($b) {
                    //dd($task);

                    $time_create = Carbon::parse($item->created_at);
                    if ($task->estimate <= 8) {
                        $time_estime = ceil($task->estimate) * 60 * 60;
                    } else {
                        $time_estime = ceil($task->estimate / 8) * 24 * 60 * 60;
                    }
                    $dd->id = $task->id;
                    $dd->subject = $task->subject;
                    $dd->created_at = $item->created_at;

                    $createdTask->id = $task->id;
                    $createdTask->status = [];
                    array_push($createdTask->status,$task->status);
                    $createdTask->created_at = $task->created_at;

                    array_push($arrCreatedTask, $createdTask);
                    $dd->updated_at = $item->updated_at;
                    $dd->priority = Distribution::getPriority($task->priority)[0]->priority;
                    $dd->status = Distribution::getStatus($task->status)[0]->status;
                    $dd->case = "active";
                    if (($time_create->timestamp + $time_estime) <= $time_now->timestamp) {
                        $dd->case = "inexpect";
                    }
                    if (Distribution::getStatus($task->status)[0]->status === "complete") {
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
                $d->id = $dev->id;
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
        }*/


        $result_last = [];
        if(isset($result))
        foreach ($result as $it) {
            $b = true;
            $prepere_task  = 0;
            $result_dev = [];
            $task = null;
            $return_Task = null;
            foreach ($it as $item) {
                    if($b){
                        $task = Distribution::getTaskById($item->idTask)[0];
                        $dd = new class
                        {
                        };
                        $prepere_task = $item->created_at;
                        $return_Task = $this->createTask($dd,$task);
                        $date_Create = Carbon::parse($item->created_at);
                        $return_Task->created_at = $item->created_at;
                        $dist_Class = new DistributionController();
                        $return_Task->finish_at = $dist_Class->dateFinishWorks($date_Create,$return_Task)->toDateTimeString();
                    }else{
                        $time_create_created_at = Carbon::parse($item->created_at)->timestamp;
                        $time_create_prepere_task = Carbon::parse($prepere_task)->timestamp;
                        if($time_create_created_at !== $time_create_prepere_task && $time_create_created_at !== $time_create_prepere_task+1 && $time_create_created_at !== $time_create_prepere_task+2 && $time_create_created_at !== $time_create_prepere_task+3) {
                            $return_Task->developers = $result_dev;
                            array_push($result_last, $return_Task);
                            $result_dev = [];
                            $task = Distribution::getTaskById($item->idTask)[0];
                            $dd = new class
                            {
                            };
                            $prepere_task = $item->created_at;
                            $return_Task = $this->createTask($dd,$task);
                        }
                    }

                    $d = new class
                    {
                    };
                    $dev = Distribution::getDevelopersById($item->idProg)[0];
                    array_push($result_dev,  $this->createDev($d,$dev));
                    $b = false;
            }
            $return_Task->developers = $result_dev;
            array_push($result_last, $return_Task);
        }


        $projects = DistTask::select(['TagProject'])->get();
        $arr_progs = [];

        if(isset($projects))
        foreach ($projects as $it){
            array_push($arr_progs,$it);
        }

        $unique_arr_progs = array_unique($arr_progs);
        $main_answer_for_paint_canvas = [];
        if(isset($unique_arr_progs))
        foreach ($unique_arr_progs as $it){
            $arr_project_name = Distribution::getCreate_at_by_TagProject($it->TagProject);
            $arr_stack_for_val = [];
            foreach ($arr_project_name as $it1){

                if(count(Distribution::all()) != 0){
                    $dist = Distribution::getDevFromDistribution($it1->id);
                    foreach ($dist as $itemDev){
                        if(isset($itemDev)) {
                            $task = Distribution::getTaskById($itemDev->idTask);
                            $date_Create = Carbon::parse($itemDev->created_at);
                            $date_Create_T = Carbon::parse($itemDev->created_at);
                            $date_now = Carbon::now()->addHours(3);
                            $date = (new DistributionController)->dateFinishWorks($date_Create, $task[0]);
                            //var_dump($date_now->weekOfYear ."==".$date_Create_T->weekOfYear. "==" . $date->weekOfYear);
                            if (($date_now->weekOfYear == $date_Create_T->weekOfYear || $date->weekOfYear == $date_now->weekOfYear) ||
                                ($date_now->addWeek()->weekOfYear == $date_Create_T->weekOfYear || $date->addWeek()->weekOfYear == $date_now->weekOfYear)) {
                                //dd($date_now->weekOfYear ."==".$date_Create_T->weekOfYear. "==" . $date->weekOfYear);
                                $task[0]->finish_at = $date->toDateTimeString();
                                $check_add_Task = true;
                                $task[0]->created_at = $date_Create_T->toDateTimeString();
                                $obj =new class{};
                                $obj->subject =  $task[0]->subject;
                                $obj->TagProject =  $task[0]->TagProject;

                                $obj->finish_at = $date->toDateTimeString();
                                $obj->created_at = $date_Create_T->toDateTimeString();
                                if($date->weekOfYear == $date_now->weekOfYear && $date_Create_T->weekOfYear + 1 == $date_now->weekOfYear){
                                    $obj->finish_at = $date->toDateTimeString();
                                    $obj->created_at = Carbon::createFromDate($date->year, $date->month, $date->day);
                                    $obj->created_at->hour = 10;
                                    $obj->created_at->minute = 0;
                                    while($obj->created_at->dayOfWeek !== Carbon::MONDAY){
                                        $obj->created_at->subDay(1);
                                    }
                                }

                                if(count($main_answer_for_paint_canvas) == 0) {
                                    array_push($main_answer_for_paint_canvas, $obj);
                                }else{
                                    foreach ($main_answer_for_paint_canvas as $it){
                                        if($it->subject == $obj->subject && $obj->TagProject == $obj->TagProject)
                                            $check_add_Task = false;
                                    }
                                    if($check_add_Task){
                                        array_push($main_answer_for_paint_canvas, $obj);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            //$main_answer_for_paint_canvas_unique = array_unique($main_answer_for_paint_canvas);
            //dd($main_answer_for_paint_canvas);
           /* if(count($arr_stack_for_val) != 0){
                array_push($main_answer_for_paint_canvas, $arr_stack_for_val);
            }*/
        }

        usort($main_answer_for_paint_canvas, array($this,"alpha_sort"));



        //Get current page form url e.g. &page=6
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Create a new Laravel collection from the array data
        $collection = new Collection(array_reverse($result_last));

        //Define how many items we want to be visible in each page
        $perPage = 1;

        //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection->slice($currentPage * $perPage, $perPage)->all();

        //Create our paginator and pass it to the view
        $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);


        return view("home",['distribution' => $paginatedSearchResults, 'mainAnswerPaintCanvas' => $main_answer_for_paint_canvas]);
    }

    function objectToarray($data)
    {
        $array = (array)$data;
        foreach($array as $key => &$field){
            if(is_object($field))$field = $this->objectToarray($field);
        }
        return $array;
    }

    function alpha_sort($a, $b) {

        if ($a->TagProject == $b->TagProject) {
            return strnatcmp($a->TagProject, $b->TagProject);
        }
        return strnatcmp($a->TagProject, $b->TagProject);
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
        $time_now = Carbon::now()->addHours(3);
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
                        //Distribution::updateTaskStatus($task->id,5); //inexpect
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
        if(isset($Dis))
        foreach($Dis as $d){
            if(isset($Distribution))
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
                    if($d->id != $id) {
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


        foreach ($no_repiat_dev as $elementKey => $element) {
            foreach ($result_DistTask as $valueKey => $value) {
                if($element->id == $value->id){
                    unset($no_repiat_dev[$elementKey]);
                }
            }
        }


        $data_dist = $no_repiat_dev;
        $data_week = [];
        $dt = Carbon::now()->addHours(3);
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

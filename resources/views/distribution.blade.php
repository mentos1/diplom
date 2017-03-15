<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Case</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
        #div1, #div2 {
            height: 550px;
            margin-left: 20px;
            padding: 10px;
            border: 1px solid #949494;
            overflow-y: scroll;
        }
        .weekends {
            text-align: center;
            padding: 10px;
            background-color: #ad676a;

        }
        .workdays {
            background-color: #ff6b59;

        }
    </style>
    <script>
        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }
        var hours = 0;
        var i_for_tab = 0,b = true;
        function drop(ev) {
            ev.preventDefault();
            console.log(ev.target.getAttribute("id"));
            if (ev.target.getAttribute("id") == "div1") {
                var data = ev.dataTransfer.getData("text");
                ev.target.appendChild(document.getElementById(data));
                hours -= $(ev.dataTransfer.mozSourceNode).find(".AvailablePerWeek").eq(0).html();
                $("tbody").find("td[class='workdays']").removeAttr("class");
                i_for_tab = 0;
                console.log($("tbody").find("td[class='workdays']"));
                if (hours >= 8) {
                    while (b) {
                        if ($("tbody").find("td").eq(i_for_tab).hasClass("weekends")) {
                            i_for_tab++;
                        } else {
                            $("tbody").find("td").eq(i_for_tab).attr("class", "workdays");
                            break;
                        }
                    }
                    i_for_tab++;
                }
                if (hours >= 16) {
                    while (b) {
                        if ($("tbody").find("td").eq(i_for_tab).hasClass("weekends")) {
                            i_for_tab++;
                        } else {
                            $("tbody").find("td").eq(i_for_tab).attr("class", "workdays");
                            break;
                        }
                    }
                    i_for_tab++;
                }
                if (hours >= 24) {
                    while (b) {
                        if ($("tbody").find("td").eq(i_for_tab).hasClass("weekends")) {
                            i_for_tab++;
                        } else {
                            $("tbody").find("td").eq(i_for_tab).attr("class", "workdays");
                            break;
                        }
                    }
                    i_for_tab++;
                }
                if (hours >= 32) {
                    while (b) {
                        if ($("tbody").find("td").eq(i_for_tab).hasClass("weekends")) {
                            i_for_tab++;
                        } else {
                            $("tbody").find("td").eq(i_for_tab).attr("class", "workdays");
                            break;
                        }
                    }
                    i_for_tab++;
                }
                if (hours >= 40) {
                    while (b) {
                        if ($("tbody").find("td").eq(i_for_tab).hasClass("weekends")) {
                            i_for_tab++;
                        } else {
                            $("tbody").find("td").eq(i_for_tab).attr("class", "workdays");
                            break;
                        }
                    }
                }
            }
            if (ev.target.getAttribute("id") == "div2") {
                var data = ev.dataTransfer.getData("text");
                ev.target.appendChild(document.getElementById(data));
                hours += +$(ev.dataTransfer.mozSourceNode).find(".AvailablePerWeek").eq(0).html();
                console.log(hours);
                //console.log($("tbody").find("td").eq(3).hasClass("weekends"));
                if (hours >= 8) {
                    while (b) {
                        if ($("tbody").find("td").eq(i_for_tab).hasClass("weekends")) {
                            i_for_tab++;
                        } else {
                            $("tbody").find("td").eq(i_for_tab).attr("class", "workdays");
                            break;
                        }
                    }
                    i_for_tab++;
                }
                if (hours >= 16) {
                    while (b) {
                        if ($("tbody").find("td").eq(i_for_tab).hasClass("weekends")) {
                            i_for_tab++;
                        } else {
                            $("tbody").find("td").eq(i_for_tab).attr("class", "workdays");
                            break;
                        }
                    }
                    i_for_tab++;
                }
                if (hours >= 24) {
                    while (b) {
                        if ($("tbody").find("td").eq(i_for_tab).hasClass("weekends")) {
                            i_for_tab++;
                        } else {
                            $("tbody").find("td").eq(i_for_tab).attr("class", "workdays");
                            break;
                        }
                    }
                    i_for_tab++;
                }
                if (hours >= 32) {
                    while (b) {
                        if ($("tbody").find("td").eq(i_for_tab).hasClass("weekends")) {
                            i_for_tab++;
                        } else {
                            $("tbody").find("td").eq(i_for_tab).attr("class", "workdays");
                            break;
                        }
                    }
                    i_for_tab++;
                }
                if (hours >= 40) {
                    while (b) {
                        if ($("tbody").find("td").eq(i_for_tab).hasClass("weekends")) {
                            i_for_tab++;
                        } else {
                            $("tbody").find("td").eq(i_for_tab).attr("class", "workdays");
                            break;
                        }
                    }
                }
            }
        }




    </script>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">DisProgOnTask</a>
        </div>
        <ul class="nav navbar-nav">
            <li ><a href="//localhost/diplom/public/">Home</a></li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Add or Drop<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class="active"><a href="programmer">Programmer</a></li>
                    <li><a href="task">Task</a></li>
                </ul>
            </li>
            <li><a href="//localhost/diplom/public/distribution">Distribution</a></li>
            <li><a href="//localhost/diplom/public/statistics">Statistics</a></li>
        </ul>
    </div>
</nav>

<div class="row form-horizontal">
        <div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)" class="col-sm-3">
            @if(isset($developer))
                @foreach($developer as $mess)
                            <div id="{!! $mess->FirstName !!}{!! $mess->LastName !!}"   draggable="true" ondragstart="drag(event)"  width="88" height="31">
                                <img style="display: block; position: relative; border: 1px solid #c1c1c1;    border-radius: 10px; float: right; width: 65px; height: 65px;"  src="">
                                Name:  <span>{!! $mess->FirstName !!}</span></br>
                                LastName:  <span>{!! $mess->LastName !!}</span></br>
                                Speciality:  <span>{!! $mess->idSpeciality !!}</span></br>
                                Level:  <span>{!! $mess->idLevel !!}</span></br>
                                AvailablePerWeek:  <span class="AvailablePerWeek">{!! $mess->AvailablePerWeek!!}</span></br>
                                @foreach($mess->TagSpeciality as $tag)
                                    TagSpeciality:<span>{!!$tag!!}</span></br>
                                @endforeach
                                <input type="hidden" name="prog_id{!! $mess->id !!}" value="{!! $mess->id !!} ">
                                <hr>
                            </div>
                @endforeach
            @endif
        </div>
    <form method="POST" action="http://localhost/diplom/public/distribution/post" accept-charset="UTF-8"><input name="_token" value="jnubEBtxw7yYXeCgBjjt4ztrmUP0HvxB2t7G7mAP" type="hidden">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)" class="col-sm-3"></div>
        </div>
        <div class="col-sm-4"></div>
        <div class="row" style="margin-left: 40px; margin-top: -550px;">
            <select id="task_id" name="task_id" value="{{ csrf_token() }}">
                @if(isset($distTask))
                    @foreach($distTask as $task)
                        <option value="{{ $task->id }}">{{ $task->subject }}</option>
                    @endforeach
                @endif
            </select>
            <div class="col-sm-4" style="margin-left: 440px; margin-top: -550px;">
                    <ul class="nav nav-tabs">
                        @if(isset($distTask))
                            @foreach($distTask as $task)
                                    <li><a class="id_li" style="visibility: hidden" href="#{{ $task->id }}">{{ $task->subject }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                    <div class="tab-content well well-lg">
                        @if(isset($distTask))
                            @foreach($distTask as $task)
                                <div id="{{ $task->id }}" class="tab-pane fade in">
                                        <h3>{{ $task->subject }}</h3>
                                        <p>Priority: {{ $task->priority }}</p>
                                        <p>Status: {{ $task->status }}</p>
                                        @if(isset($task->description))
                                            @foreach($task->description as $desc)
                                                <p style="display:block; max-width: 400px; min-width: 30px;">Description: {{ $desc }}</p>
                                            @endforeach
                                        @endif
                                        @if(isset($task->technologies))
                                            @foreach($task->technologies as $tag)
                                                <p>Tag: {{ $tag }}</p>
                                            @endforeach
                                        @endif
                                        <p>Estimate: {{ $task->estimate }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
            </div>
            <div id="forTasks"></div>
            <button type="submit" class="btn btn-default col-sm-2">Send</button>
            <div class="col-sm-4">
                <table class="table" style="font-size: 12px !important;" width="100%">
                    <thead>
                        <tr>
                            @if(isset($dataWeek))
                                @foreach($dataWeek as $item)
                                    <th>{{$item}}</th>
                                @endforeach
                            @else
                                <th>Monday</th>
                                <th>Tuesday</th>
                                <th>Wednesday</th>
                                <th>Thursday</th>
                                <th>Friday</th>
                                <th>Saturday</th>
                                <th>Sunday</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($dataWeek as $item)
                                @if($item == "Saturday" || $item =="Sunday")
                                    <td class="weekends"></td>
                                @else
                                    <td></td>
                                @endif

                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </form>

<script>
    $(document).ready(function(){

        $(".nav-tabs a").click(function(){
            $(this).tab('show');
        });
        $(".id_li").first().trigger('click').addClass('active');  // при загрузки автра выбор 1 пункта меню
        $("#task_id").change(function (e) {
            $('.id_li[href="#'+ $(this).find(":selected").val() +'"]').trigger('click').addClass('active');
            console.log($(this).find(":selected").val());
         });
    });
</script>




</body>
</html>


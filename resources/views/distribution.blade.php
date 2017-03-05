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
    </style>
    <script>
        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        function drop(ev) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            ev.target.appendChild(document.getElementById(data));
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
                                AvailablePerWeek:  <span>{!! $mess->AvailablePerWeek!!}</span></br>
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
                                    <li><a href="#{{ $task->id }}">{{ $task->subject }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                    <div class="tab-content well well-lg">
                        @if(isset($distTask))
                            @foreach($distTask as $task)
                                <div id="{{ $task->id }}" class="tab-pane fade in active">
                                    <div class="container">
                                        <h3>{{ $task->subject }}</h3>
                                        <p></p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
            </div>
            <div id="forTasks"></div>
            <button type="submit" class="btn btn-default col-sm-2" style="margin: 40px">Send</button>
        </div>
        </form>

<script>
    $(document).ready(function(){
        $(".nav-tabs a").click(function(){
            $(this).tab('show');
        });
    });
</script>




</body>
</html>


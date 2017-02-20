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
                    <script>
                        var task_Check =document.getElementById("{!! $mess->FirstName !!}{!! $mess->LastName !!}");
                        console.log(task_Check);
                        if(task_Check != null) {
                            document.write("<div style='display:none'></div>");
                            var span = document.createElement('span');
                            span.innerHTML = ", {!! $mess->getTagSpeciality[0]->tag!!}";
                            document.getElementById("{!! $mess->FirstName !!}{!! $mess->LastName !!}").getElementsByTagName("span")[document.getElementById("{!! $mess->FirstName !!}{!! $mess->LastName !!}").getElementsByTagName("span").length - 1].appendChild(span);
                        }else
                            document.write("<div id='{!! $mess->FirstName !!}{!! $mess->LastName !!}'draggable='true' ondragstart='drag(event)'  width='88' height='31'><img style='display: block; position: relative; border: 1px solid #c1c1c1;    border-radius: 10px; float: right; width: 65px; height: 65px;'  src='https://pp.vk.me/c631616/v631616713/1fbdb/a5idV46L-38.jpg'>Lvl: <span>{!! $mess->getLvl['lvl'] !!}</span></br>Name:  <span>{!! $mess->FirstName !!}</span></br>LastName:  <span>{!! $mess->LastName !!}</span></br>Directions:  <span>{!! $mess->getSpeciality['speciality']!!}</span></br>Time:  <span>{!! $mess->AvailablePerWeek!!}</span></br>Tags:  <span>{!! $mess->getTagSpeciality[0]->tag!!}</span></br> <input type='hidden' name='prog_id{!! $mess->id !!}' value='{!! $mess->id !!}'> <hr> </div>");
                    </script>
                    {{--<div id="{!! $mess->FirstName !!}{!! $mess->LastName !!}"   draggable="true" ondragstart="drag(event)"  width="88" height="31">
                        <img style="display: block; position: relative; border: 1px solid #c1c1c1;    border-radius: 10px; float: right; width: 65px; height: 65px;"  src="https://pp.vk.me/c631616/v631616713/1fbdb/a5idV46L-38.jpg">
                        Lvl: <span>{!! $mess->getLvl['lvl'] !!}</span></br>
                        Name:  <span>{!! $mess->FirstName !!}</span></br>
                        LastName:  <span>{!! $mess->LastName !!}</span></br>
                        Directions:  <span>{!! $mess->getSpeciality["speciality"]!!}</span></br>
                        Time:  <span>{!! $mess->AvailablePerWeek!!}</span></br>
                        Tags:  <span>{!! $mess->getTagSpeciality[0]->tag!!}</span></br>
                        <input type="hidden" name="prog_id{!! $mess->id !!}" value="{!! $mess->id !!} ">
                        <hr>
                    </div>--}}
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
            <script>
                var task_Check =document.getElementById("{!! $task->subject !!}");
                if(task_Check != null)
                    document.write("<option style='display:none'>");
                else
                    document.write("<option id='{!! $task->subject !!}' name='optTask' value='{!! $task->id !!}'>{!! $task->subject !!}</option>");
            </script>
            @endforeach
        @endif
    </select>
    @if(isset($distTask))
        @foreach($distTask as $task)
        <script>
            $("#task_id").on('change', function() {
                console.log($(this).find('option:selected').html());
                if($(this).find('option:selected').html() == "{!! $task->subject !!}"){

                }
                else{

                }
            });
        </script>
        @endforeach
    @endif
    <div style="display: inline">
         <h2 style="padding-left: 1100px">Task</h2>
         <ul>
             <li>Subject: {!! $task->subject  !!}</li>
             <li>Description: </li>
             <li>Priority: </li>
             <li>Status: </li>
             <li>Technologies: </li>
             <li>Estimate: </li>
         </ul>
    </div>
    <button type="submit" class="btn btn-default col-sm-2" style="margin: 40px">Send</button>
</div>
</form>
<script>
    $("#task_id").on('change', function() {
       console.log($(this).find('option:selected').html())

    });
</script>






</body>
</html>


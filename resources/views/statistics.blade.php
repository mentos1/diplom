<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Case</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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

<div class="col-sm-2"></div>
<div class=" col-sm-8 table-responsive" style="overflow-y: scroll; height: 450px ">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Task</th>
            <th>Team Prog</th>
            <th>Time</th>
            <th>Completed</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>


        @foreach($distribution as $dist)
            <script>
                var task_Check =document.getElementById("{!! $dist->task[0]->task !!}");
                if(task_Check != null)
                document.write("<tr style='display:none'>")
                else
                document.write("<tr>")

                function cl_btn(s) {
                    //document.write(s);
                    return false;
                }
            </script>


                    <td id = "{!! $dist->task[0]->task !!}">
                        {!! $dist->task[0]->task !!}
                    </td>
                    <td>@foreach($distribution as $dist_prog)
                            @if( $dist_prog->idTask  == $dist->task[0]->id)
                            {!! $dist_prog->programmer[0]->name!!}
                            @endif
                        @endforeach
                    </td>
                    <td>Чмель</td>
                    <td>true or false</td>
                    <td><div>
                            <button style="float: right;" type="button" class="btn glyphicon glyphicon glyphicon-remove btn-danger" onclick=""></button>
                            <button style="float: left;" type="button" class="btn glyphicon glyphicon-wrench btn-success "></button></div></td>
                </tr>
        @endforeach


        </tbody>
    </table>
</div>

</body>
</html>

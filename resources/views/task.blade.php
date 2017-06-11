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

<div class="container">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#add">Add</a></li>
        <li><a href="#drop">Drop</a></li>
    </ul>

    <div class="tab-content well well-lg">
        <div id="add" class="tab-pane fade in active">
            <div class="container">
                <h2>Add Task</h2>
                {!! Form::open(['route' => 'post.store'] ) !!}
                <div class="form-group col-sm-10">
                    {!! Form::label('Task') !!}
                    {!! Form::file('Task', null, ['class'=>'form-control']) !!}
                </div>
                <div class="form-group col-sm-10">
                    {!! Form::label('Time') !!}
                    {!! Form::text('Time', null, ['class'=>'form-control']) !!}
                </div>
                <div class="form-group col-sm-10">
                    {!! Form::label('Complexity') !!}
                    {!! Form::select('Complexity', array('0' => 'free mode',
                                                   '1' => 'nomal mode',
                                                   '2' => 'extreme mode'
                                                   ), 'free mode', ['class'=>'form-control']) !!}
                </div>
                <div class="form-group col-sm-10">
                    {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div id="drop" class="tab-pane fade">
            <h2>Drop programmer</h2>
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="directions" class="control-label col-sm-2">Directions:</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="directions">
                            <option>Front-End</option>
                            <option>Back-End</option>
                            <option>Designer</option>
                            <option>SEO</option>
                            <option>Full Stack</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(".nav-tabs a").click(function(){
            $(this).tab('show');
        });
    });
</script>






</body>
</html>

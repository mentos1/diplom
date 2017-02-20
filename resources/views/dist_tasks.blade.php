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

        <div class="container">
            <h2>Add Task</h2>
            <form method="POST" enctype="multipart/form-data" action="http://localhost/diplom/public/distTask/post" accept-charset="UTF-8">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group col-sm-10">
                    <label for="subject">Subject</label>
                    <input class="form-control" name="subject" id="subject" type="text">
                </div>
                <div class="form-group col-sm-10">
                    <label for="description">Description</label>
                    <textarea class="form-control" rows="5" name="description" id="description"></textarea>
                </div>
                <div class="form-group col-sm-10" >
                    <label for="priority">Priority</label>
                    <select class="form-control" name="priority" id="priority">
                        @foreach($priority as $prior)
                            <option value="{!! $prior->id !!}">{!! $prior->priority!!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-10" >
                    <label for="status">Status</label>
                    <select class="form-control" name="status" id="status">
                        @foreach($status as $stat)
                            <option value="{!! $stat->id !!}">{!! $stat->status!!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-10">
                    @foreach($tag as $t)
                        @unless($t->tag == "none")
                            <div class="form-group col-sm-2">
                                    <label style="float: inherit" for="{!! $t->tag !!}">{!! $t->tag !!}</label>
                                    <input id="{!! $t->tag !!}" name="{!! $t->id !!}"  type="checkbox" class="form-control" value="{!! $t->id !!}"></hr>
                            </div>
                        @endunless
                    @endforeach
                </div>
{{--                <div class="form-group col-sm-10" >
                    <label for="speciality">Speciality</label>
                    <select class="form-control" name="speciality" id="speciality">
                        @foreach($speciality as $spec)
                            <option value="{!! $spec->id !!}">{!! $spec->speciality !!}</option>
                        @endforeach
                    </select>
                </div>--}}
                <div class="form-group col-sm-10">
                    <label style="float: inherit" for="estimate">Estimate</label>
                    <input id="estimate" name="estimate"  type="number" min="5" max="40" class="form-control" value="40"></hr>
                </div>
                <div class="form-group col-sm-10">
                    <input class="btn btn-primary" value="Create" type="submit">
                </div>
            </form>
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

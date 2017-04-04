<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Case</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<style>
    td > button{
        padding: 5px;
        margin: 5px;
    }
    .passive_Bg{
        background-color: #ad676a;
    }
    .active_Bg{
        background-color: #75ad5e;
    }
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
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">DisProgOnTask</a>
        </div>
        <ul class="nav navbar-nav">
            <li ><a href="http://localhost/diplom/public/">Home</a></li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Add or Drop<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="developer">Developer</a></li>
                    <li><a href="distTask">Task</a></li>
                </ul>
            </li>
            <li><a href="//localhost/diplom/public/distribution">Distribution</a></li>
        </ul>
    </div>
</nav>
@yield('content')
</body>
</html>

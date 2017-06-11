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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>


</head>
<style>
    td > button{
        padding: 5px;
        margin: 5px;
    }
    .layer {
        overflow: scroll; /* Добавляем полосы прокрутки */
        width: 300px; /* Ширина блока */
        height: 150px; /* Высота блока */
        padding: 2px; /* Поля вокруг текста */
        overflow-x: hidden;
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
                    <li><a href="//localhost/diplom/public/developer">Developer</a></li>
                    <li><a href="//localhost/diplom/public/distTask">Task</a></li>
                </ul>
            </li>
            <li><a href="//localhost/diplom/public/distribution">Distribution</a></li>
        </ul>
    </div>
</nav>
@yield('content')
</body>
</html>

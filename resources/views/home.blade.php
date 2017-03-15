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
</style>
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
        <li class="active"><a href="#active">Active</a></li>
        <li><a href="#inExpect">inExpect</a></li>
        <li><a href="#store">Store</a></li>
    </ul>
    <div class="tab-content well well-lg">
        <div id="active" class="tab-pane fade in active">
            <table class="table table-condensed">
            <thead>
            <tr>
                <th>Subject</th>
                <th>Description</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Technologies</th>
                <th>Estimate</th>
                <th>LastUpdate</th>
                <th>Developers</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($distribution))
                @foreach($distribution as $dist)
                    @if($dist->case == "active")
                        <tr  id='{!! $dist->subject !!}'>
                        <td>{!! $dist->subject !!}</td>
                        <td>@foreach($dist->description as $dTask)
                                    {!! $dTask !!}
                            @endforeach
                        </td>
                        <td>
                            {!! $dist->priority !!}
                        </td>
                        <td>
                            {!! $dist->status !!}
                        </td>
                        <td>
                            @foreach($dist->technologies as $dTask)
                                <span>{!! $dTask !!}</span>
                            @endforeach
                        </td>
                        <td>{!! $dist->estimate !!}</td>
                            <td><span>{!! $dist->updated_at !!}</span></td>
                            <td>
                                @foreach($dist->developers as $dDevelopers)
                                    <span data-val="{{$dDevelopers->id}}">{!! $dDevelopers->FirstName !!} {!! $dDevelopers->LastName !!}</span>
                                @endforeach
                            </td>
                            <td><button type='button' class='btn btn-danger' data-blok="active" value="{{$dist->id}}">Delet</button>
                                <button type='button' class='btn btn-info' data-blok="active" value="{{$dist->id}}">Update</button></td>
                        </tr>
                    @endif
                @endforeach
            @endif
            </tbody>
        </table>
</div>
    <div id="store" class="tab-pane fade">
            <table class="table table-condensed">
            <thead>
            <tr>
                <th>Subject</th>
                <th>Description</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Technologies</th>
                <th>Estimate</th>
                <th>LastUpdate</th>
                <th>Developers</th>
                <th>Actions</th>
            </tr>
            </thead>
                <tbody>
                @if(isset($distribution))
                    @foreach($distribution as $dist)
                        @if($dist->case == "inexpect")
                            <tr  id='{!! $dist->subject !!}'>
                                <td>{!! $dist->subject !!}</td>
                                <td>@foreach($dist->description as $dTask)
                                        {!! $dTask !!}
                                    @endforeach
                                </td>
                                <td>
                                    {!! $dist->priority !!}
                                </td>
                                <td>
                                    {!! $dist->status !!}
                                </td>
                                <td>
                                    @foreach($dist->technologies as $dTask)
                                        <span>{!! $dTask !!}</span>
                                    @endforeach
                                </td>
                                <td>{!! $dist->estimate !!}</td>
                                <td><span>{!! $dist->updated_at !!}</span></td>
                                <td>
                                    @foreach($dist->developers as $dDevelopers)
                                        <span data-val="{{$dDevelopers->id}}">{!! $dDevelopers->FirstName !!} {!! $dDevelopers->LastName !!}</span>
                                    @endforeach
                                </td>
                                <td><button type='button' class='btn btn-danger' data-blok="store" value="{{$dist->id}}">Delet</button>
                                    <button type='button' class='btn btn-info' data-blok="store" value="{{$dist->id}}">Update</button></td>
                            </tr>
                        @endif
                    @endforeach
                @endif
                </tbody>
        </table>
    </div>
    <div id="inExpect" class="tab-pane fade">
        <table class="table table-condensed">
            <thead>
            <tr>
                <th>Subject</th>
                <th>Description</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Technologies</th>
                <th>Estimate</th>
                <th>LastUpdate</th>
                <th>Developers</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($distribution))
                @foreach($distribution as $dist)
                    @if($dist->case == "complete")
                        <tr  id='{!! $dist->subject !!}'>
                            <td>{!! $dist->subject !!}</td>
                            <td>@foreach($dist->description as $dTask)
                                    {!! $dTask !!}
                                @endforeach
                            </td>
                            <td>
                                {!! $dist->priority !!}
                            </td>
                            <td>
                                {!! $dist->status !!}
                            </td>
                            <td>
                                @foreach($dist->technologies as $dTask)
                                    <span>{!! $dTask !!}</span>
                                @endforeach
                            </td>
                            <td>{!! $dist->estimate !!}</td>
                            <td><span>{!! $dist->updated_at !!}</span></td>
                            <td>
                            @foreach($dist->developers as $dDevelopers)
                                <span data-val="{{$dDevelopers->id}}">{!! $dDevelopers->FirstName !!} {!! $dDevelopers->LastName !!}</span>
                            @endforeach
                            </td>
                            <td><button type='button' class='btn btn-danger' data-blok="inExpect" value="{{$dist->id}}">Delet</button>
                                <button type='button' class='btn btn-info' data-blok="inExpect" value="{{$dist->id}}">Update</button></td>
                        </tr>
                    @endif
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
<script>

    $(document).ready(function(){
        $(".nav-tabs a").click(function(){
            $(this).tab('show');
        });
    });


    $(".btn-danger").on("click", function (e) {
        var url = "http://localhost/diplom/public/";
        var dev = [];
        //console.log($($($($(this).parents("tr")[0]).find("td")[6]).find("span")[0]).html());
        //console.log($($($(this).parents("tr")[0]).find("td")[7]).find("span"));
        var data_tite = $($($($(this).parents("tr")[0]).find("td")[6]).find("span")[0]).html();
        var mas_dev = $($($(this).parents("tr")[0]).find("td")[7]).find("span");


        mas_dev.each(function(){
            dev.push(this.getAttribute("data-val"));
        });

        var data = {
        "_token": "{{ csrf_token() }}",
        "id": $(this).val(),
        "idBlock": this.getAttribute("data-blok"),
        "dev": dev,
        "time_created_at": data_tite
        };
        console.log(data);
        //console.log(data);
        $.ajax({
            type: "POST",
            url: "http://localhost/diplom/public/",
            data: data,
            dataType: 'json',
            //beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
            success: function (response) {
                console.log("success")

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
        //$(this).parents("tr")[0].remove();
    })
</script>

</body>
</html>

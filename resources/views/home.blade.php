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
        <script>
            var a = -9;
            var date_Db , dateDb;
            var ms_update;
            var date_Now = Date.parse(new Date());
        </script>
        @if(isset($distribution))
            @foreach($distribution as $dist)
                <script>
                    var task_Check =document.getElementById("{!! $dist->getDistTask["subject"] !!}");
                    if(task_Check == null) {
                        dateDb = new Date("{!! $dist->updated_at !!}");
                        date_Db = Date.parse(dateDb);
                        ms_update = +"{!! $dist->getDistTask['estimate'] !!}" * 60 *60;
                        console.log("Date Now: " + date_Now + ". Date Db: " + date_Db + ms_update + "ms_update: " + ms_update);
                        document.write("<tr  id='{!! $dist->getDistTask['subject'] !!}'><td>{!! $dist->getDistTask['subject'] !!}</td><td>@foreach($distTask as $dTask)@if( $dist->getDistTask['description'] == $dTask->getDescription['id']){!! $dTask->getDescription['description'] !!}@break @endif @endforeach </td><td>@foreach($distTask as $dTask)@if( $dist->getDistTask['priority']  == $dTask->getPriority['id']){!! $dTask->getPriority['priority'] !!}@break @endif @endforeach </td><td>@foreach($distTask as $dTask)@if( $dist->getDistTask['status']  == $dTask->getStatus['id']){!! $dTask->getStatus['status'] !!}@break @endif @endforeach </td><td>@foreach($distTask as $dTask)@if( $dist->getDistTask['technologies']  == $dTask->getTechnologies['id'])<span>{!! $dTask->getTechnologies['tag'] !!}</span>@break @endif @endforeach </td><td>{!! $dist->getDistTask['estimate'] !!}</td><td>{!! $dist->updated_at !!}</td><td><span>{!! $dist->getDeveloper[0]['FirstName'] !!} {!! $dist->getDeveloper[0]['LastName'] !!}</span></td><td><button type='button' class='btn btn-danger'>Delet</button><button type='button' class='btn btn-info'>Update</button></td></tr>");
                        if(date_Now <= ms_update + date_Db){
                            $('#{!! $dist->getDistTask['subject'] !!}').attr("class","passive_Bg");
                        }else {
                            $('#{!! $dist->getDistTask['subject'] !!}').attr("class","active_Bg");
                        }
                        a = a + 9;
                    }
                    else{

                        var span = document.createElement('span');
                        var comma  = document.createElement('span');
                        var comma1  = document.createElement('span');
                        var span_name = document.createElement('span');
                        var Span_Tag = document.getElementsByTagName("td")[4].getElementsByTagName("span");
                        for(var i = 0; i < Span_Tag.length; i++){
                            if(Span_Tag[i].innerHTML != "{!! $dTask->getTechnologies['tag']!!}"){
                                span.innerHTML = "{!! $dTask->getTechnologies['tag']!!}";
                                comma.innerHTML = " , ";
                                document.getElementsByTagName("td")[4+a].appendChild(comma);
                                document.getElementsByTagName("td")[4+a].appendChild(span);

                            }
                        }
                        for(var i = 0; i < Span_Tag.length; i++){
                            if(Span_Tag[i].innerHTML != "{!! $dist->getDeveloper[0]['FirstName'] !!} {!! $dist->getDeveloper[0]['LastName'] !!}"){
                                comma1.innerHTML = " , ";
                                span_name.innerHTML = "{!! $dist->getDeveloper[0]['FirstName'] !!} {!! $dist->getDeveloper[0]['LastName'] !!}";
                                document.getElementsByTagName("td")[7+a].appendChild(comma1);
                                document.getElementsByTagName("td")[7+a].appendChild(span_name);
                            }
                        }
                    }
                </script>
            @endforeach
        @endif

    </tbody>
</table>

<script>
    $(".btn-danger").on("click", function (e) {
        var url = "http://localhost/diplom/public/";
        var data = {
          subject: $(this).parents("tr").eq(0).find("td").eq(0).html()
        };
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
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

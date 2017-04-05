@extends('layouts.main')

@section('content')
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
                $('#tDev').html(hours);
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
                console.log("time: " + hours);
                $('#tDev').html(hours);
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
            if(+$("#tDev").html() >= +$("#tTask").html()){
                $("#check").val("true");
            }else{
                $("#check").val("false")
            }
        }
    </script>
    <div class="row form-horizontal">
        <div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)" class="col-sm-3">
            @if(isset($developer))
                @foreach($developer as $mess)
                            <div id="{!! $mess->FirstName !!}{!! $mess->LastName !!}" draggable="true" ondragstart="drag(event)"  width="88" height="31">
                                <img style="display: block; position: relative; border: 1px solid #c1c1c1;    border-radius: 10px; float: right; width: 65px; height: 65px;"  src="">
                                Name:  <span>{!! $mess->FirstName !!}</span></br>
                                LastName:  <span>{!! $mess->LastName !!}</span></br>
                                Speciality:  <span>{!! $mess->idSpeciality !!}</span></br>
                                Level:  <span>{!! $mess->idLevel !!}</span></br>
                                AvailablePerWeek:  <span class="AvailablePerWeek">{!! $mess->AvailablePerWeek!!}</span></br>
                                @foreach($mess->TagSpeciality as $tag)
                                    TagSpeciality:<span>{!!$tag!!}</span></br>
                                @endforeach
                                <input type="hidden"  form="sendForm" name="prog_id{!! $mess->id !!}" value="{!! $mess->id !!} ">
                                <hr>
                            </div>
                @endforeach
            @endif
        </div>
        <form method="POST" id="sendForm" action="http://localhost/diplom/public/distribution/post" accept-charset="UTF-8"></form>
        <input name="_token" form="sendForm" value="jnubEBtxw7yYXeCgBjjt4ztrmUP0HvxB2t7G7mAP" type="hidden">
        <input type="hidden" form="sendForm" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" form="sendForm" id="check"  name="check" value="false">
        <div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)" class="col-sm-3"></div>
        </div>
        <div class="col-sm-4"></div>
        <div class="row" style="margin-left: 40px; margin-top: -550px;">
            <select id="task_id" name="task_id" form="sendForm">
                @if(isset($distTask))
                    @foreach($distTask as $task)
                        <option value="{{ $task->id }}" data-tTime="{{ $task->estimate }}">{{ $task->subject }}</option>
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
                                    <form method="POST" id="updateForm" action="http://localhost/diplom/public/update/{{$task->id }}" accept-charset="UTF-8"></form>
                                        <input type="hidden" form="updateForm" name="_token" value="{{ csrf_token() }}">
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
                                        <button type='submit' form="updateForm" class='btn btn-info' data-blok="active" value="{{$task->id}}">Update</button>
                                </div>
                            @endforeach
                        @endif
                    </div>
            </div>
            <div id="forTasks"></div>
            <button type="submit" form="sendForm" class="btn btn-default col-sm-2">Send</button>
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
                        <tr>
                            <td colspan="7" style="text-align: center"><span id="tTask">_</span>h / <span id="tDev">_</span>h</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

<script>
    $(document).ready(function(){

        $(".nav-tabs a").click(function(){
            $(this).tab('show');
        });



        $(".id_li").first().trigger('click').addClass('active');  // при загрузки автра выбор 1 пункта меню
        $("#task_id").change(function (e) {
            $('.id_li[href="#'+ $(this).find(":selected").val() +'"]').trigger('click').addClass('active');
            console.log($(this).find(":selected").attr("data-tTime"));
            $("#tTask").html($(this).find(":selected").attr("data-tTime"));
         });
    });
</script>
@endsection
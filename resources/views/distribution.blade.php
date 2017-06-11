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
            var maxDay;
            var days = $($(ev.dataTransfer.mozSourceNode).find(".days")[0]).html();
            var hours = $($(ev.dataTransfer.mozSourceNode).find(".hours")[0]).html();
            if(b){
                maxDay = days;
                b = false;
            }else{
                maxDay = 0;
            }
            $('#div2').children().each(function(index,elem){
                console.log(maxDay +" < "+ $($(elem).find(".days")[0]).html());
                if(maxDay < $($(elem).find(".days")[0]).html()){
                    maxDay = $($(elem).find(".days")[0]).html();
                }
            });
            $('#datepicker').datepicker('option', 'minDate', '+'+maxDay+'D');
            ev.preventDefault();
            var perent  = ev.target.parentNode;
            if(perent.getAttribute("id") == "div1" || perent.getAttribute("id") == "div2"){
                var data = ev.dataTransfer.getData("text");
                perent.appendChild(document.getElementById(data));
            }
            //console.log(ev.target.getAttribute("id"));
            if (ev.target.getAttribute("id") == "div1" || ev.target.getAttribute("id") == "div2") {
                var data = ev.dataTransfer.getData("text");
                ev.target.appendChild(document.getElementById(data));
            }
        }
    </script>
    <div class="row form-horizontal">
        <div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)" style="position: relative; z-index: 3" class="col-sm-3">
            @if(isset($developer))
                @foreach($developer as $mess)
                    <form method="POST" id="updateFormDev{{$mess->id}}" action="http://localhost/diplom/public/developer/update/{{$mess->id }}" accept-charset="UTF-8"></form>
                    <input type="hidden" form="updateFormDev{{$mess->id}}" name="_token" value="{{ csrf_token() }}">
                    <div id="{!! $mess->FirstName !!}{!! $mess->LastName !!}" draggable="true" ondrop="drop(event)" ondragstart="drag(event)"  width="88" height="31">
                                Name:  <span>{!! $mess->FirstName !!}</span></br>
                                Email:  <span>{!! $mess->LastName !!}</span></br>
                                Speciality:  <span>{!! $mess->idSpeciality !!}</span></br>
                                Level:  <span>{!! $mess->idLevel !!}</span></br>
                                AvailablePerWeek:  <span class="AvailablePerWeek">{!! $mess->AvailablePerWeek!!}</span></br>
                                @foreach($mess->TagSpeciality as $tag)
                                    TagSpeciality:<span>{!!$tag!!}</span></br>
                                @endforeach
                                    @if($mess->HoursBeforeStart !== 0 || $mess->DaysBeforeStart !== 0)
                                        Will busy<span class="busyTime" style="color:red; font-size: 1.2em"><span class="days">{!! $mess->DaysBeforeStart !!}</span>d : <span class="hours">{!! $mess->HoursBeforeStart !!}</span>h</span>
                                    @else
                                        Will busy<span class="busyTime" style="color:green; font-size: 1.2em"> <span class="days">{!! $mess->DaysBeforeStart !!}</span>d : <span class="hours">{!! $mess->HoursBeforeStart !!}</span>h</span>
                                    @endif
                                <input type="hidden"  form="sendForm" name="prog_id{!! $mess->id !!}" value="{!! $mess->id !!}">
                                <button type='submit' style="float: right" form="updateFormDev{{$mess->id}}" class='btn btn-inf' data-blok="active" value="{{$mess->id}}">Update</button>
                                <hr>
                            </div>
                @endforeach
            @endif
        </div>
        <form method="POST" id="sendForm" action="http://localhost/diplom/public/distribution/post" accept-charset="UTF-8"></form>
        <input name="_token" form="sendForm" value="jnubEBtxw7yYXeCgBjjt4ztrmUP0HvxB2t7G7mAP" type="hidden">
        <input type="hidden" form="sendForm" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" form="sendForm" id="check"  name="check" value="false">
        <div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)" style="position: relative; z-index: 3" class="col-sm-3"></div>
        </div>
        <div class="col-sm-4"></div>
        <div class="row" style="margin-left: 40px; margin-top: -550px; position: relative">
            @if(count($distTask) != 0)
            <div class="form-group" style="position: absolute; right: 108px; top: 41px; z-index: 1;"><input type="text" form="sendForm" required  name="data_send" id="datepicker"></div>
            <div class="form-group" style="position: absolute; right: 308px; top: 41px; z-index: 1;"><input type="text" form="sendForm" required  name="data_time" class="timepicker"></div>
            <select id="task_id" name="task_id" form="sendForm" style="position: absolute; z-index: 2;">
                @if(isset($distTask))
                    @foreach($distTask as $task)
                        <option value="{{ $task->id }}" data-tTime="{{ $task->estimate }}">{{ $task->subject }} from the {{ $task->TagProject }}</option>
                    @endforeach
                @endif
            </select>
            <div class="form-group">
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
                                    <form method="POST" id="updateForm{{$task->id}}" action="http://localhost/diplom/public/update/{{$task->id }}" accept-charset="UTF-8"></form>
                                        <input type="hidden" form="updateForm{{$task->id}}" name="_token" value="{{ csrf_token() }}">
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
                                        <button type='submit' form="updateForm{{$task->id}}" class='btn btn-inf' data-blok="active" value="{{$task->id}}">Update</button>
                                </div>
                            @endforeach
                        @endif
                    </div>
            </div>
            <div id="forTasks" style="width: 250px;float: left; position: relative">
                <button type="button" class="btn col-sm-5 btn-info" id="getAdvice">Get Advice</button>
                <button type="submit" form="sendForm" id="sendFormBut" class="btn btn-success col-sm-5 col-sm-offset-2">Send</button>
            </div>
        </div>
        @else
            <div class="tab-content well well-lg" style ="margin-left:1000px; margin-right : 100px; text-align: center">
                No free task
            </div>
        @endif

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


        var check_task = true;
        $("#sendFormBut").click(function (e) {
            if(check_task)
            e.preventDefault();
            if($('#div2').children().length) {
                var arr = $('#div2').children();
                var devArr = [];
                for (var i = 0; i < arr.length; i++) {
                    devArr.push(+($(arr[i]).find("input").val()));
                }

                var data = {
                    "_token": "{{ csrf_token() }}",
                    "idTask": $("select").find(":selected").val(),
                    "dev": devArr,
                    "dataTime": $("#datepicker").val(),
                    "hoursTime": $(".timepicker").val()
                };
                console.log(data);
                $.ajax({
                    type: "POST",
                    url: "http://localhost/diplom/public/distribution/checkTask",
                    data: data,
                    dataType: 'json',                    // тип загружаемых данных
                    success: function (data) { // вешаем свой обработчик на функцию success
                        console.log(data);
                        if (data.answer_AvailablePerWeek == false) {
                            alert("У программиста не осталось свободных часов на этой неделе.");
                            check_task = true;
                        }
                        if (data.answer_created_at == false) {
                            alert("На время этой задачи программист будет занят на друой задичи. Выберите другого програмиста.");
                            check_task = true;
                        }
                        if (data.weeked == false) {
                            alert("Вы питаетесь начать с выходного дня.");
                            check_task = true;
                        }
                        if (data.answer_AvailablePerWeek == true && data.answer_created_at == true && data.weeked == true) {
                            console.log("Успех");
                            check_task = false;
                            document.forms['sendForm'].submit(); // дабавить Сабмит
                        }
                    }
                });
            }else{
                alert("Вы не выбрали программистов.");
            }
        });


        $("#getAdvice").click(function (e) {
            if($("select").find(":selected").val() !== undefined) {
                var data = {
                    "_token": "{{ csrf_token() }}",
                    "id": $("select").find(":selected").val()
                }

                //console.log(data);
                $.ajax({
                    type: "POST",
                    url: "http://localhost/diplom/public/distribution/advice/" + data["id"],
                    data: data,
                    dataType: 'json',
                    //beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
                    success: function (response) {
                        var answer = response["response"];
                        console.dir(answer);
                        var itLength = 1 / answer.length, itOpacity = 0;

                        for (var item in answer) {
                            itOpacity += itLength;
                            console.log(itOpacity);
                            $("input[value='" + answer[item].id + "']").parent().css("background-color", "rgba(59, 252, 0, " + itOpacity);
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }else{
                alert("У вас нет задач");
            }
        });
    });

    $( function() {
            $( "#datepicker" ).datepicker({ minDate: -20,
                                            maxDate: "+1M +10D",
                                            onSelect: function (date) {
                                                if((new Date()).getDay() === (new Date(date)).getDay() && (new Date()).getMonth() === (new Date(date)).getMonth()){
                                                    $('.timepicker').timepicker('setTime', ''+(new Date()).getHours());
                                                }else{
                                                    $('.timepicker').timepicker('setTime', '10');
                                                }
                                        } });


    });

    function getDate() {
        var d = new Date();
        var n = d.getHours() + 1;
        if (n > 19 || n < 10)
            return n = 10;
        return n;
    }

    $('.timepicker').timepicker({
        timeFormat: 'H:mm',
        interval: 60,
        minTime: '10:00',
        maxTime: '19:00',
        defaultTime: ''+getDate(),
        startTime: '10:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true,

    });


</script>
@endsection
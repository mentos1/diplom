<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Bordered Table</h2>
    <p>The .table-bordered class adds borders to a table:</p>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Prevent</th>
            <th>New</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $newTask->subject }}</td>
            <td>
                <div class="form-group col-sm-10">
                    <label for="subject">Subject</label>
                    <input data-id="{{ $newTask->id }}" class="form-control" name="subject" id="subject" type="text">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div>
                    @if(isset($newTask->description))
                        @foreach($newTask->description as $desc)
                            <div class="form-group col-sm-12">
                                <p style="display:block; max-width: 400px; min-width: 30px; margin: 10px" value="{{$desc->id}}" class="col-sm-11 descripId">{{ $desc->description }}</p>
                                <button type="submit" style="margin: 0; padding: 0;  width: 1.5em; height: 1.5em; border-radius: 50%" class="btn btn-danger col-sm-1 dropDiscrip">X</button>
                            </div>
                        @endforeach
                    @endif
                </div>
            </td>
            <td>
                <div class="form-group col-sm-10">
                    <label for="description">Description</label>
                    <textarea class="form-control" rows="5" name="description" id="description"></textarea>
                    <input type="radio" name="gender" value="AddNew" checked> AddNew
                    <input type="radio" name="gender" value="Replace"> Replace
                </div>
            </td>
        </tr>
        <tr>
            <td>{{ $newTask->priority }}</td>
            <td><div class="form-group col-sm-10" >
                    <label for="priority">Priority</label>
                    <select class="form-control" name="priority" id="priority">
                        @foreach($priority as $prior)
                            <option value="{!! $prior->id !!}">{!! $prior->priority!!}</option>
                        @endforeach
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>{{ $newTask->status }}</td>
            <td>
                <div class="form-group col-sm-10" >
                    <label for="status">Status</label>
                    <select class="form-control" name="status" id="status">
                        @foreach($status as $stat)
                            @unless($stat->status == "inexpect")
                                <option value="{!! $stat->id !!}">{!! $stat->status!!}</option>
                            @endunless
                        @endforeach
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                @if(isset($newTask->technologies))
                    @foreach($newTask->technologies as $tag)
                        <div class="form-group col-sm-12">
                            <p class="col-sm-2" value="{{ $tag->id }}">{{ $tag->tag }}</p>
                            <button type="submit" style="margin: 0; padding: 0;  width: 1.5em; height: 1.5em; border-radius: 50%" class="btn btn-danger col-sm-1 dropTech">X</button>
                        </div>
                    @endforeach
                @endif
            </td>
            <td>
                @foreach($tag1 as $t)
                    @unless($t->tag == "none")
                                <div id="tags" class="tags" class="form-group col-sm-2">
                                    <label style="float: inherit" for="{!! $t->tag !!}">{!! $t->tag !!}</label>
                                    <input id="{!! $t->tag !!}" name="{!! $t->id !!}"  type="checkbox" class="form-control" value="{!! $t->id !!}"></hr>
                                </div>
                    @endunless
                @endforeach
            </td>
        </tr>
        <tr>
            <td><p>Estimate: {{ $newTask->estimate }}</p></td>
            <td>
                <div class="form-group col-sm-10">
                    <label style="float: inherit" for="estimate">Estimate</label>
                    <input id="estimate" name="estimate"  type="number" min="5" max="40" class="form-control" value="40"></hr>
                </div>
                <div class="form-group col-sm-10">
                    <input class="btn btn-primary" id="send" value="Update" type="submit">
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<script>
    var drop_Discrip = [];
    var drop_Thech = [];
    $('.dropTech').click(function(){
        //tags
        drop_Thech.push($(this).prev("p").attr("value"));
        $(this).prev("p").hide();
        $(this).hide();

    });

    $('.dropDiscrip').click(function(){
        //tags
        drop_Discrip.push($(this).prev("p").attr("value"));
        $(this).prev("p").hide();
        $(this).hide();

    });





    $("#send").on("click", function (e) {
        var dev = [],
            data = [];
        //console.log($($($($(this).parents("tr")[0]).find("td")[6]).find("span")[0]).html());
        //console.log($($($(this).parents("tr")[0]).find("td")[7]).find("span"));
        var data_tag = $(".tags").find("input");


        console.log(data_tag);
        data_tag.each(function () {
            if(this.checked == true)
            dev.push(this.getAttribute("name"));
        });



        var data = {
            "_token": "{{ csrf_token() }}",
            "id": $("#subject").attr("data-id"),
            "subject": $("#subject").val(),
            "descriptions": $("#description").val(),
            "descriptions_first_id": $(".descripId").eq(0).attr("value"),
            "descriptions_drop": drop_Discrip,
            "actionDiscrip": $($("input[type='radio']:checked")[0]).val(),
            "priority": $("#priority").val(),
            "status": $("#status").val(),
            "tags_drop": drop_Thech,
            "tags": dev,
            "estimate": $("#estimate").val()
        };

        console.log(data);

        $.ajax({
            type: "POST",
            url: "http://localhost/diplom/public/replace",
            data: data,
            dataType: 'json',
            //beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
            success: function (response) {
                console.log(response)

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });



</script>


</body>
</html>

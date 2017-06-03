@extends('layouts.main')

@section('content')
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
                <td>{{ $dev->FirstName }}</td>
                <td>
                    <div class="form-group col-sm-10">
                        <label for="subject">FirstName</label>
                        <input data-id="{{ $dev->id }}" value="{{ $dev->FirstName }}" class="form-control" name="FirstName" id="FirstName" type="text">
                    </div>
                </td>
            </tr>
            <tr>
                <td>{{ $dev->LastName }}</td>
                <td>
                    <div class="form-group col-sm-10">
                        <label for="subject">LastName</label>
                        <input class="form-control" value="{{ $dev->LastName }}" name="LastName" id="LastName" type="text">
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    @if(isset($dev->TagSpeciality))
                        @foreach($dev->TagSpeciality as $tag)
                            <div class="form-group col-sm-12">
                                <p class="col-sm-2" value="{{ $tag }}">{{ $tag }}</p>
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
                <td>{{ $dev->idSpeciality }}</td>
                <td>
                    @if(isset($speciality))
                        <select class="form-control" name="speciality" id="speciality">
                            @foreach($speciality as $spec)
                                <option value="{!! $spec->id !!}">{!! $spec->speciality !!}</option>
                            @endforeach
                        </select>
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    {{ $dev->idLevel }}
                </td>
                <td>
                    @if(isset($level))
                        <select class="form-control" name="lvl" id="lvl">
                            @foreach($level as $lvl)
                                <option value="{!! $lvl->id !!}">{!! $lvl->lvl!!}</option>
                            @endforeach
                        </select>
                    @endif
                </td>
            </tr>
            <tr>
                <td><p>Estimate: {{ $dev->AvailablePerWeek }}</p></td>
                <td>
                    <div class="form-group col-sm-10">
                        <label style="float: inherit" for="AvailablePerWeek">Estimate</label>
                        <input id="AvailablePerWeek" name="AvailablePerWeek"  type="number" min="5" max="40" class="form-control" value="{{ $dev->AvailablePerWeek }}"></hr>
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
                "id": $("#FirstName").attr("data-id"),
                "FirstName": $("#FirstName").val(),
                "LastName": $("#LastName").val(),
                "speciality": $("#speciality").val(),
                "lvl": $("#lvl").val(),
                "tags_drop": drop_Thech,
                "tags": dev,
                "AvailablePerWeek": $("#AvailablePerWeek").val()
            };

            console.log(data);



            $.ajax({
                type: "POST",
                url: "http://localhost/diplom/public/developer/replaceDev",
                data: data,
                dataType: 'json',
                //beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
                success: function (response) {
                   alert('The developer has been updated');
                   window.location.href = document.referrer;

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });



    </script>
@endsection
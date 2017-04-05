@extends('layouts.main');


@section('content')
<div class="container">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#add">Add</a></li>
        <li><a href="#drop">Drop</a></li>
    </ul>
    <div class="tab-content well well-lg">
        <div id="add" class="tab-pane fade in active">
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
                                @unless($stat->status == "inexpect")
                                    <option value="{!! $stat->id !!}">{!! $stat->status!!}</option>
                                @endunless
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
                    <div class="form-group col-sm-10">
                        <label for="estimate">Estimate</label>
                        <select class="form-control" name="estimate" id="estimate">
                                <option value="1">XS</option>
                                <option value="5">S</option>
                                <option value="10">M</option>
                                <option value="20">L</option>
                                <option value="40">XL</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-10">
                        <input class="btn btn-primary" value="Create" type="submit" onClick="alert('The task has been added')">
                    </div>
                </form>
            </div>
        </div>
        <div id="drop" class="tab-pane fade">
            <h2>Drop Task</h2>
            <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="http://localhost/diplom/public/distTask/drop" accept-charset="UTF-8">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="directions" class="control-label col-sm-2">Directions:</label>
                    <div class="col-sm-8">
                        <select name="DropTaskId" class="form-control" id="directions">
                            @foreach($distTask as $dist){
                                <option value="{{ $dist->id }}">{{ $dist->subject }}</option>
                            }
                            @endforeach
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
@endsection

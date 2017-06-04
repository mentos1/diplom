@extends('layouts.main')

@section('content')

<div class="container">
    <canvas id="myCanvas" width="1140" height="300" style="border:1px solid #e3e3e3; background-color: #f5f5f5; border-radius: 20px">
        Your browser does not support the HTML5 canvas tag.
    </canvas>
    <script>
        Date.prototype.addDays = function(days) {
            var dat = new Date(this.valueOf());
            dat.setDate(dat.getDate() + days);
            return dat;
        }

        function getWeekNumber(d) {
            // Copy date so don't modify original
            d = new Date(+d);
            d.setHours(0,0,0,0);
            // Set to nearest Thursday: current date + 4 - current day number
            // Make Sunday's day number 7
            d.setDate(d.getDate() + 4 - (d.getDay()||7));
            // Get first day of year
            var yearStart = new Date(d.getFullYear(),0,1);
            // Calculate full weeks to nearest Thursday
            var weekNo = Math.ceil(( ( (d - yearStart) / 86400000) + 1)/7);
            // Return array of year and week number
            return [d.getFullYear(), weekNo];
        }

        var locations = [
                @foreach ($mainAnswerPaintCanvas as $it)
                        ["{{ $it->TagProject }}","{{ $it->subject }}","{{ $it->created_at }}","{{ $it->finish_at}}"],
                @endforeach
        ];
        var count_Pr = 0;
        var arr_pr =[];
        var arr_obj =[];

        var pr = null;
        var obj = {};
        console.log(locations);
        for(var i = 0; i < locations.length; i++){
            if(pr !== locations[i][0]){
                pr = locations[i][0];
                    count_Pr++;
                    arr_pr.push(locations[i][0]);
            }
        }
        console.log(count_Pr);
        pr = null;
        var arr_all_pr =[];
        count_Pr = 0;

        for(var i = 0; i <= locations.length; i++){


            if(i == locations.length){
                arr_all_pr.push(arr_obj);
                break;
            }

            if(pr != locations[i][0]){
                if(arr_obj.length != 0){
                    arr_all_pr.push(arr_obj);
                }
                count_Pr++;
                arr_obj = [];
                //if (getWeekNumber(new Date()) + 1 == getWeekNumber(new Date(locations[i][2])) || getWeekNumber(new Date())[1] == getWeekNumber(new Date(locations[i][2]))[1]) {
                    //alert(getWeekNumber(new Date())[1] == getWeekNumber(new Date(locations[i][2]))[1]);
                    var answer_obj = function () {
                        var obj = {};
                        obj.subject = locations[i][1];
                        obj.created_at = locations[i][2];
                        obj.finish_at = locations[i][3];
                        return obj;
                    };
                    arr_obj.push(answer_obj());
                //}
                pr = locations[i][0];
            }else {
                //if (getWeekNumber(new Date())[1] + 1 == getWeekNumber(new Date(locations[i][2]))[1] || getWeekNumber(new Date())[1] == getWeekNumber(new Date(locations[i][2]))[1]){
                    var answer_obj = function () {
                        var obj = {};
                        obj.subject = locations[i][1];
                        obj.created_at = locations[i][2];
                        obj.finish_at = locations[i][3];
                        return obj;
                    };
                    arr_obj.push(answer_obj());
                }
            //}
        }

        var amountProjects = count_Pr;

        console.dir(arr_all_pr);
        var canvas = document.getElementById("myCanvas");
        var ctx = canvas.getContext('2d');

        var app = {};
        // the total area of our drawings, can be very large now
        app.WIDTH = 2320;
        //alert(amountProjects);
        app.HEIGHT = 200*amountProjects;


        app.draw = function() {
            // reset everything (clears the canvas + transform + fillStyle + any other property of the context)
            canvas.width = canvas.width;

            // move our context by the inverse of our scrollbars' left and top property
            ctx.setTransform(1, 0, 0, 1, -app.scrollbars.left, -app.scrollbars.top);

            ctx.textAlign = 'center';
            // draw only the visible area
            var visibleLeft = app.scrollbars.left;
            var visibleWidth = visibleLeft + canvas.width;
            var visibleTop = app.scrollbars.top;
            var visibleHeight = visibleTop + canvas.height;

            // you probably will have to make other calculations than these ones to get your drawings
            // to draw only where required
            var maxHeight = canvas.getAttribute("height");
            var maxWidth = canvas.getAttribute("width");
            var xBlock = app.WIDTH / 14;
            var yBlock = (app.HEIGHT / amountProjects / 1.5)-30;
            ctx.beginPath();
            ctx.font = '14px "Tahoma"';
            ctx.fillStyle = "rgba(200, 0, 0, 0.4)";
            ctx.fillText("Monday", 80, 20);
            ctx.fillText("Tuesday", 240, 20);
            ctx.fillText("Wednesday", 390, 20);
            ctx.fillText("Thursday", 560, 20);
            ctx.fillText("Friday", 740, 20);
            ctx.fillText("Saturday", 900, 20);
            ctx.fillText("Sunday", 1080, 20);

            ctx.fillText("Monday", 1240, 20);
            ctx.fillText("Tuesday", 1390, 20);
            ctx.fillText("Wednesday", 1570, 20);
            ctx.fillText("Thursday", 1740, 20);
            ctx.fillText("Friday", 1900, 20);
            ctx.fillText("Saturday", 2060, 20);
            ctx.fillText("Sunday", 2220, 20);

           ctx.beginPath();
            for(var i = 1; i < 14; i++){
                ctx.strokeStyle = "#e3e3e3";
                ctx.moveTo(xBlock * i,0);
                ctx.lineTo(xBlock * i,app.HEIGHT);
                ctx.stroke();
            }

            ctx.strokeStyle = "#e3e3e3";
            ctx.moveTo(0,50);
            ctx.lineTo(app.WIDTH,50);
            ctx.stroke();

            var underLine = 50;
            for(var i = 1; i <= amountProjects; i++){
               ctx.beginPath();
               ctx.lineWidth = 1;
               ctx.strokeStyle = "#e3e3e3";
               ctx.moveTo(0,yBlock * i + underLine);
               ctx.font = "bold italic 10px sans-serif";
               ctx.fillText(arr_pr[i-1], 30, yBlock * i + underLine - 5);
               ctx.lineTo(app.WIDTH,yBlock * i + underLine);
               ctx.stroke();
                    var glass = arr_all_pr[i-1];
                    //console.log(glass);
                    if(glass != undefined) {
                        for (var jx = 0; jx < glass.length; jx++) {
                            ctx.beginPath();
                            ctx.lineWidth = 10;
                            ctx.lineCap = "round";
                            ctx.strokeStyle = "red";
                            var start = parseTime(new Date(glass[jx].created_at), maxWidth);
                            //console.log(start);
                            var finish = parseTime(new Date(glass[jx].finish_at), maxWidth);
                            //console.log(finish);
                            //var step = (yBlock * i + 50 - yBlock * (i-1) + 45) /  glass.length;
                            var step = 10;
                            ctx.moveTo(start, (yBlock * (i - 1) + underLine) + step * (jx + 1));
                            ctx.lineTo(finish, (yBlock * (i - 1) + underLine) + step * (jx + 1));
                            ctx.stroke();
                        }
                        if (glass.length > 5)
                            underLine = underLine + 10 * glass.length - 5;
                    }
            }

            var result_now_time = parseTime(new Date(),maxWidth);
            //console.log("now" + result_now_time);


           ctx.beginPath();
           ctx.moveTo(result_now_time, 0);
           ctx.lineTo(result_now_time, app.HEIGHT);
           ctx.lineWidth = 5;
           ctx.lineCap = "round";
           ctx.fillStyle = "rgba(200, 0, 200, 0.2)";
           ctx.font = "bold italic 10px sans-serif";
           ctx.fillText("now", result_now_time+15, maxHeight/2);
           ctx.strokeStyle = "rgba(200, 0, 200, 0.3)";
           ctx.stroke();


            // draw our scrollbars on top if needed
            app.scrollbars.draw();
        }

        app.scrollbars = function() {
            var scrollbars = {};
            // initial position
            scrollbars.left = 0;
            scrollbars.top = 0;
            // a single constructor for both horizontal and vertical
            var ScrollBar = function(vertical) {
                var that = {
                    vertical: vertical
                };

                that.left = vertical ? canvas.width - 10 : 0;
                that.top = vertical ? 0 : canvas.height - 10;
                that.height = vertical ? canvas.height - 10 : 5;
                that.width = vertical ? 5 : canvas.width - 10;
                that.fill = '#dedede';

                that.cursor = {
                    radius: 5,
                    fill: '#bababa'
                };
                that.cursor.top = vertical ? that.cursor.radius : that.top + that.cursor.radius / 2;
                that.cursor.left = vertical ? that.left + that.cursor.radius / 2 : that.cursor.radius;

                that.draw = function() {
                    if (!that.visible) {
                        return;
                    }
                    // remember to reset the matrix
                    ctx.setTransform(1, 0, 0, 1, 0, 0);
                    // you can give it any shape you like, all canvas drawings operations are possible
                    ctx.fillStyle = that.fill;
                    ctx.fillRect(that.left, that.top, that.width, that.height);
                    ctx.beginPath();
                    ctx.arc(that.cursor.left, that.cursor.top, that.cursor.radius, 0, Math.PI * 2);
                    ctx.fillStyle = that.cursor.fill;
                    ctx.fill();
                };
                // check if we're hovered
                that.isHover = function(x, y) {
                    if (x >= that.left - that.cursor.radius && x <= that.left + that.width + that.cursor.radius &&
                            y >= that.top - that.cursor.radius && y <= that.top + that.height + that.cursor.radius) {
                        // we are so record the position of the mouse and set ourself as the one hovered
                        scrollbars.mousePos = vertical ? y : x;
                        scrollbars.hovered = that;
                        that.visible = true;
                        return true;
                    }
                    // we were visible last call and no wheel event is happening
                    else if (that.visible && !scrollbars.willHide) {
                        that.visible = false;
                        // the app should be redrawn
                        return true;
                    }
                }

                return that;
            };

            scrollbars.horizontal = ScrollBar(0);
            scrollbars.vertical = ScrollBar(1);

            scrollbars.hovered = null;
            scrollbars.dragged = null;
            scrollbars.mousePos = null;
            // check both of our scrollbars
            scrollbars.isHover = function(x, y) {
                return this.horizontal.isHover(x, y) || this.vertical.isHover(x, y);
            };
            // draw both of our scrollbars
            scrollbars.draw = function() {
                this.horizontal.draw();
                this.vertical.draw();
            };
            // check if one of our scrollbars is visible
            scrollbars.visible = function() {
                return this.horizontal.visible || this.vertical.visible;
            };
            // hide it...
            scrollbars.hide = function() {
                // only if we're not using the mousewheel or dragging the cursor
                if (this.willHide || this.dragged) {
                    return;
                }
                this.horizontal.visible = false;
                this.vertical.visible = false;
            };

            // get the area's coord relative to our scrollbar
            var toAreaCoord = function(pos, scrollBar) {
                var sbBase = scrollBar.vertical ? scrollBar.top : scrollBar.left;
                var sbMax = scrollBar.vertical ? scrollBar.height : scrollBar.width;
                var areaMax = scrollBar.vertical ? app.HEIGHT - canvas.height : app.WIDTH - canvas.width;

                var ratio = (pos - sbBase) / (sbMax - sbBase);

                return areaMax * ratio;
            };

            // get the scrollbar's coord relative to our total area
            var toScrollCoords = function(pos, scrollBar) {
                var sbBase = scrollBar.vertical ? scrollBar.top : scrollBar.left;
                var sbMax = scrollBar.vertical ? scrollBar.height : scrollBar.width;
                var areaMax = scrollBar.vertical ? app.HEIGHT - canvas.height : app.WIDTH - canvas.width;

                var ratio = pos / areaMax;

                return ((sbMax - sbBase) * ratio) + sbBase;
            }

            scrollbars.scroll = function() {
                // check which one of the scrollbars is active
                var vertical = this.hovered.vertical;
                // until where our cursor can go
                var maxCursorPos = this.hovered[vertical ? 'height' : 'width'];
                var pos = vertical ? 'top' : 'left';
                // check that we're not out of the bounds
                this.hovered.cursor[pos] = this.mousePos < 0 ? 0 :
                        this.mousePos > maxCursorPos ? maxCursorPos : this.mousePos;

                // seems ok so tell the app we scrolled
                this[pos] = toAreaCoord(this.hovered.cursor[pos], this.hovered);
                // redraw everything
                app.draw();
            }
            // because we will hide it after a small time
            scrollbars.willHide;
            // called by the wheel event
            scrollbars.scrollBy = function(deltaX, deltaY) {
                // it's not coming from our scrollbars
                this.hovered = null;
                // we're moving horizontally
                if (deltaX) {
                    var newLeft = this.left + deltaX;
                    // make sure we're in the bounds
                    this.left = newLeft > app.WIDTH - canvas.width ? app.WIDTH - canvas.width : newLeft < 0 ? 0 : newLeft;
                    // update the horizontal cursor
                    this.horizontal.cursor.left = toScrollCoords(this.left, this.horizontal);
                    // show our scrollbar
                    this.horizontal.visible = true;
                }
                if (deltaY) {
                    var newTop = this.top + deltaY;
                    this.top = newTop > app.HEIGHT - canvas.height ? app.HEIGHT - canvas.height : newTop < 0 ? 0 : newTop;
                    this.vertical.cursor.top = toScrollCoords(this.top, this.vertical);
                    this.vertical.visible = true;
                }
                // if we were called less than the required timeout
                clearTimeout(this.willHide);
                this.willHide = setTimeout(function() {
                    scrollbars.willHide = null;
                    scrollbars.hide();
                    app.draw();
                }, 500);
                // redraw everything
                app.draw();
            };

            return scrollbars;
        }();

        var mousedown = function(e) {
            // tell the browser we handle this
            e.preventDefault();
            // we're over one the scrollbars
            if (app.scrollbars.hovered) {
                // new promotion ! it becomes the dragged one
                app.scrollbars.dragged = app.scrollbars.hovered;
                app.scrollbars.scroll();
            }
        };

        var mousemove = function(e) {
            // check the coordinates of our canvas in the document
            var rect = canvas.getBoundingClientRect();
            var x = e.clientX - rect.left;
            var y = e.clientY - rect.top;
            // we're dragging something
            if (app.scrollbars.dragged) {
                // update the mouse position
                app.scrollbars.mousePos = app.scrollbars.dragged.vertical ? y : x;
                app.scrollbars.scroll();
            } else if (app.scrollbars.isHover(x, y)) {
                // something has changed, redraw to show or hide the scrollbar
                app.draw();
            }
            e.preventDefault();
        };
        var mouseup = function() {
            // we dropped it
            app.scrollbars.dragged = null;
        };

        var mouseout = function() {
            // we're out
            if (app.scrollbars.visible()) {
                app.scrollbars.hide();
                app.scrollbars.dragged = false;
                app.draw();
            }
        };

        function parseTime(date,maxWidth) {

            var sizeOneDayOfPx = maxWidth / (9 * 7);
            var day_of_week = date.getDay();
            var add_day = date.getHours();

            if(day_of_week !== 0 && day_of_week !== 6){
                var day = (((day_of_week - 1) * 9) + add_day) * sizeOneDayOfPx;
                alert(date);
                alert(day);
                var time_Now = (date.getTime() + 259200000) % 604800000;
                var answer_now_time = time_Now * 100 /604800000;
                //return  answer_now_time * maxWidth /100;
                return  day;
            }
        }

        var mouseWheel = function(e) {
            e.preventDefault();
            app.scrollbars.scrollBy(e.deltaX, e.deltaY);
        };

        canvas.addEventListener('mousemove', mousemove);
        canvas.addEventListener('mousedown', mousedown);
        canvas.addEventListener('mouseup', mouseup);
        canvas.addEventListener('mouseout', mouseout);
        canvas.addEventListener('wheel', mouseWheel);

        // an initial drawing
        app.draw();




    </script>
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
                            <td><span>0000</span></td>
                            <td>
                                @foreach($dist->developers as $dDevelopers)
                                    <span data-val="{{$dDevelopers->id}}">{!! $dDevelopers->FirstName !!} {!! $dDevelopers->LastName !!}</span>
                                @endforeach
                            </td>
                            <td><button type='button' class='btn btn-danger' data-blok="active" value="{{$dist->id}}">Delete</button>
                                <form method="POST" action="http://localhost/diplom/public/update/{{$dist->id}}" accept-charset="UTF-8">
                                    <input name="_token" value="jnubEBtxw7yYXeCgBjjt4ztrmUP0HvxB2t7G7mAP" type="hidden">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type='submit' class='btn btn-info' data-blok="active" value="{{$dist->id}}">Update</button>
                                </form>
                            </td>
                        </tr>
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
@endsection
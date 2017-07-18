
{{ Html::script('js/displays/SchoolMap/drawlocation.js') }}
{{ Html::script('js/displays/SchoolMap/loadFile.js') }}
{{ Html::script('js/displays/SchoolMap/location.js') }}

<script>

    var canvasID = "mapCanvas";
    var mapINFO = null;

    // set autoload button
    var autoload = false;
    function toggleAutorefresh() {
        autoload = !autoload;
        if (autoload) {
            refresh();
        }
    }

    var lastRefresh;
    var limit = 5000;

    function refresh() {

        lastRefresh = new Date();
        refreshLocation(canvasID, mapINFO);

        if (autoload) {
            var now = new Date();
            var refreshLengthMillisec = (now.getTime() - lastRefresh.getTime()) * 1000;
            // console.log(now.getTime(), lastRefresh.getTime());
            setTimeout(refresh, Math.max(0, limit));
        }
    }

    document.body.onload = function() {

        var canvas = document.getElementById(canvasID);
        // canvas.onclick = function(evt) {
        //     console.log(getCoor(canvas, evt));
        // }

        loadJson("{{ url('/map/CUD/map.json') }}", function(data) {

            mapINFO = data;
            widthDistance = mapINFO['width'];
            heightDistance = mapINFO['height'];

            @foreach ($students as $student)

                // register the device
                registerStudentDevice(
                    "{{ $student['device_mac_address'] }}", 
                    "{{ $student['std_id'] }}_location", 
                    "{{ $student['color'] }}");
                
                // add onmouseover event
                /*
                document.getElementById("{{ $student['std_id'] }}_name").onmouseover = function() {
                    var area = $("#{{ $student['std_id'] }}_location").text();
                    refreshImage(canvasID, mapINFO);
                    drawArea(canvasID, mapINFO[area], "{{ $student['color'] }}");
                }
                */
            @endforeach

            refresh();
        });

        toggleAutorefresh();
    }
</script>

<div style="width: 100%; padding: 0;">
<div style="width: 30%; padding: 0; display: inline-block; vertical-align: top; float: left;">
    @if (count($students) == 0) 
        No Data
    @endif
    @foreach ($students as $key => $student)
        <div style="width: 100%; height: 100px; position: relative;" id='{{ $student['std_id'] }}_row'>
            
            <div style="background-color: {{ $student['color'] }}; position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.3;"> </div>
            <div id='{{ $student['std_id'] }}_name' style="position: relative; top: 50%; transform: translateY(-50%); color: black;">
                {{ $student['name'] }}
                ({{ $student['std_level'] }}/{{ $student['std_class'] }})
                <span style='border-bottom-color: {{ $student['color'] }}; border-bottom-style: solid;'>
                    {{ $student['std_id'] }} 
                </span>
            </div>

            <div id='{{ $student['std_id'] }}_location'></div>

    {{--                             
            <td class="col-md-1 text-center">
                {{ $student['message'] or "No Message" }}
            </td>
    --}}
            <div id='{{ $student['std_id'] }}_location' style='display: inline-block;'>
            </div>
        </tr>
        </div>
    @endforeach
</div>
<div style="width: 69%; display: inline-block; float: right;">
    <div class="text-center" style="margin: 5px 10% 5px 10%;">
    <canvas id="mapCanvas" class='map' style="background: url({{ url('map/CUD/map.jpg') }}); background-size: 100% 100%; background-repeat: no-repeat; height: 500px;">
        Your browser does not support the HTML5 canvas tag.
    </canvas>
    </div>
</div>
</div>
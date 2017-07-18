
{{ Html::script('js/drawlocation.js') }}

<script>
    document.body.onload = function() {
        var canvas = document.getElementById('mapCanvas');
        // canvas.onclick = function(evt) {
        //     console.log(getCoor(canvas, evt));
        // }

        loadJson("{{ url('/map/CUD/map.json') }}", function(data) {

            mapINFO = data;
            widthDistance = mapINFO['width'];
            heightDistance = mapINFO['height'];

            @foreach ($students as $student)

                // register the device
                // registerStudentDevice("{{ $student['device_mac_address'] }}", "{{ $student['std_id'] }}_location", "{{ $student['std_id'] }}_token", "{{ $student['color'] }}");
                
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
    }
</script>

<canvas id="mapCanvas" class='col-md-12 map' style="background: url({{ url('map/CUD/map.jpg') }}); background-size: 100% 100%; background-repeat: no-repeat;">
    Your browser does not support the HTML5 canvas tag.
</canvas>

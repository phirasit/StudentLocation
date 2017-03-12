@extends('layouts.app')

@section('content')

{{ Html::style('css/style.css') }}
{{ Html::script('js/location.js') }}
{{ Html::script('js/drawlocation.js') }}
{{ Html::script('js/loadFile.js') }}

<script type="text/javascript">
    
    // define variables
    var getLocation_url = '{{ url('/getLocation') }}';
    var callStudent_url = '{{ url('/callStudent') }}';


    var mapINFO, timeLimit = 1000;
    var widthDistance, heightDistance;

    // set autoload button
    var autoload = false;
    function toggleAutorefresh() {
        autoload = !autoload;
        if (autoload) {
            refresh();
        }
    }

    var lastRefresh;
    var limit = 3000;

    function refresh() {

        lastRefresh = new Date();
        refreshLocation("mapCanvas", mapINFO);

        if (autoload) {
            var now = new Date();
            var refreshLengthMillisec = (now.getTime() - lastRefresh.getTime()) * 1000;
            // console.log(now.getTime(), lastRefresh.getTime());
            setTimeout(refresh, Math.max(0, limit - refreshLengthMillisec));
        }
    }

    // set onload function
    document.body.onload = function() {
        
        @foreach ($students as $student)
            registerStudentDevice("{{ $student['device_mac_address'] }}", "{{ $student['std_id'] }}_location", "{{ $student['std_id'] }}_token", "{{ $student['color'] }}");
        @endforeach

        loadJson("{{ url('/map/'. $map . '/map.json') }}", function(data) {

            mapINFO = data;
            widthDistance = mapINFO['width'];
            heightDistance = mapINFO['height'];
            refresh();

        });
    }


</script>

<div class="container">
    <div class="row">
        <div class="col-md-4 text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{-- Students --}}
                    Users
                </div>

                <div class="panel-body">
                    <table class='table-condensed' style="width: 100%;">
                    <thead>
                        <tr style="border-bottom:1pt dashed gray;">
                            <th style="width: 10%;" class="text-center">#</th>
                            <th style="width: 60%; padding-left: 20px;">Name</th>
                            <th style="width: 30%;" class="text-center">Location</th>
                        </tr>
                    </thead>
                    @foreach ($students as $key => $student)
                        <tr>
                            <td class='text-center' style="padding: 5px;">
                                {{ $key+1 }}
                            </td>
                            <td class='text-left' style="padding-left: 20px;">
                                <span style='border-bottom-color: {{ $student['color'] }}; border-bottom-style: solid;'>
                                    {{ $student['name'] }}
                                    {{-- ({{ $student['std_level'] }}/{{ $student['std_class'] }})  --}}
                                </span>
                            </td>
{{--                             
                            <td class="col-md-1 text-center">
                                {{ $student['message'] or "No Message" }}
                            </td>
--}}
                            <td class="text-center" style="padding: 10px;">
                                <div id='{{ $student['std_id'] }}_location' style='display: inline-block;'>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </table>
                    <div class='text-center'>
                        <div style="display:inline-block; vertical-align: middle;">
                            <label class="switch" style="margin: 0;">
                                <input type="checkbox" onclick="toggleAutorefresh();">
                                <div class="slider round"></div>
                            </label>
                        </div>
                        <div style="display: inline-block;">
                            <label style="margin:0; padding: 0;">
                                auto refresh
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="panel-footer text-center">
                    {{ Form::open(array('name' => 'manageStudent', 'url' => '/manageStudent', 'class' => 'form-inline')) }}
                        <div class="input-group">
                            {{ Form::text('student_id', '', array(
                                'class' => 'form-control span2', 
                                'placeholder' => 'Student ID',
                            )) }}
                            <span class='input-group-addon btn label-success' style="border-color:green; padding: 0; margin: 0;">
                                {{ Form::label('add', '+', array(
                                    'style' => 'cursor:pointer; display: inline-block; width:30px; padding: 0; margin: 0;',
                                    'class' => 'label',
                                )) }}
                                {{ Form::submit('add', array(
                                    'id' => 'add',
                                    'name' => 'type', 
                                    'class' => 'hidden btn bnt-xs', 
                                )) }}
                            </span>
                            <span class='input-group-addon btn label-danger' style="border-color:brown; padding:0;">
                                {{ Form::label('remove', '-', array(
                                    'style' => 'cursor:pointer; display: inline-block; width:30px; padding: 0; margin: 0;',
                                    'class' => 'label',
                                )) }}
                                {{ Form::submit('remove', array(
                                    'id' => 'remove',
                                    'name' => 'type', 
                                    'class' => 'hidden btn bnt-xs', 
                                )) }}
                            </span>
                        </div>
                    {{ Form::close() }}
                    @if (session('addingStudent'))
                        <div>
                            @if(session('addingStudent')['success'] == true)
                                <p class='text-success'> {{ session('addingStudent')['message'] }} </p>
                            @else
                                <p class='text-warning'> {{ session('addingStudent')['message'] }} </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8 text-left">
            <div class="panel panel-default">
                <div class="panel-heading">Current Location</div>

                <div class="panel-body text-center">
                    <canvas id="mapCanvas" class='col-md-12 map' height='200px' style="background: url({{ url('map/'. $map .'/map.jpg') }}); background-size: 100% 100%; background-repeat: no-repeat; ">
                        Your browser does not support the HTML5 canvas tag.
                    </canvas>
                </div>
                
                <div class="panel-footer text-center">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

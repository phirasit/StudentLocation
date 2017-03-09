@extends('layouts.app')

@section('content')

{{ Html::style('css/style.css') }}
{{ Html::script('js/location.js') }}
{{ Html::script('js/drawlocation.js') }}
{{ Html::script('js/loadXML.js') }}

<script type="text/javascript">
    
    // define variables
    var getLocation_url = '{{ url('/getLocation') }}';
    var callStudent_url = '{{ url('/callStudent') }}';


    var mapINFO;
    var widthDistance, heightDistance;

    function refresh() {
        refreshLocation("mapCanvas", mapINFO);
    }

    // set onload function
    document.body.onload = function() {
        
        @foreach ($students as $student)
            registerStudentDevice("{{ $student['device_mac_address'] }}", "{{ $student['std_id'] }}_location", "{{ $student['std_id'] }}_token", "{{ $student['color'] }}");
        @endforeach

        loadXML("{{ url('/map/'. $map . '/map.xml') }}", function(data) {
            mapINFO = data;
            widthDistance = extractXML(mapINFO, 'width');
            heightDistance = extractXML(mapINFO, 'height');
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
                    <span class='text-right' style='display: inline-block;' width='100%'>

                    {{ Html::image('img/refresh_icon.png', 'refresh', array('width' => 50, 'height' => 40, 'onclick' => 'refresh();', 'class' => 'btn')) }}
                    </span>
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
                            <td class="text-left" style="padding: 10px;">
                                <div id='{{ $student['std_id'] }}_location' style='display: inline-block;'>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </table>
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
                    <canvas id="mapCanvas" class='col-md-12' height='200px'
                        style="border:1px solid #000000; width: 100%; background: url({{ url('map/'. $map .'/map.jpg') }}); background-size: 100% 100%; background-repeat: no-repeat; margin: 0; padding: 0;">
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

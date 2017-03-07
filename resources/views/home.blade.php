@extends('layouts.app')

@section('content')

{{ Html::style('css/style.css') }}
{{ Html::script('js/location.js') }}

<script type="text/javascript">
    // define variables
    var getLocation_url = '{{ url('/getLocation') }}';
    var callStudent_url = '{{ url('/callStudent') }}';
</script>

<div class="container">
    <div class="row">
        <div class="col-md-4 text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Students
                    <span class='text-right' style='display: inline-block;' width='100%'>

                    {{ Html::image('img/refresh_icon.png', 'refresh', array('width' => 60, 'height' => 50, 'onclick' => 'refreshLocation();', 'class' => 'btn')) }}
                    </span>
                </div>

                <div class="panel-body">
                    <table class='table-condensed'>
                    @foreach ($students as $student)
                        <tr>
                            <td class='text-left' width='100%'>
                                <span style='border-bottom-color: {{ $student['color'] }}; border-bottom-style: solid;'>
                                    {{ $student['name'] }}({{ $student['std_level'] }}/{{ $student['std_class'] }}) 
                                </span>
                            </td>
{{--                             
                            <td class="col-md-1 text-center">
                                {{ $student['message'] or "No Message" }}
                            </td>
--}}
                            <td class="col-md-1 text-center">
                                <div id='{{ $student['std_id'] }}_location' style='display: inline-block;'>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </table>
                </div>
                
                <div class="panel-footer text-center">
                    {{ Form::open(array('url' => '/manageStudent', 'class' => 'form-inline')) }}
                        <div class="input-group">
                            {{ Form::text('student_id', '', array(
                                'class' => 'form-control span2', 
                                'placeholder' => 'Student ID',
                            )) }}
                            <span class='input-group-addon btn label-success' style="border-color:green;">
                                {{ Form::label('add', '+', array(
                                    'style' => 'cursor:pointer;',
                                    'class' => 'label',
                                )) }}
                                {{ Form::submit('add', array(
                                    'id' => 'add',
                                    'name' => 'type', 
                                    'class' => 'hidden btn bnt-xs', 
                                )) }}
                            </span>
                            <span class='input-group-addon btn label-danger' style="border-color:brown;">
                                {{ Form::label('remove', '-', array(
                                    'style' => 'cursor:pointer;',
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

        @foreach ($students as $student)
            <script type='text/javascript'>
                registerStudentDevice("{{ $student['device_mac_address'] }}", "{{ $student['std_id'] }}_location", "{{ $student['std_id'] }}_token");
            </script>
        @endforeach

        <div class="col-md-8 text-left">
            <div class="panel panel-default">
                <div class="panel-heading">Current Location</div>

                <div class="panel-body text-center">
    {{--                     @foreach ($students as $student)
                            <div class='display:inline-block;'>
                                <div id='{{ $student['std_id'] }}_token' class='circle' 
                                    style='background-color: {{ $student['color'] }};'>
                                    
                                </div>
                            </div>
                        @endforeach
 --}}                    {{ HTML::image('img/map.jpg', '', array(
                        'id' => 'map',
                        'class' => 'location_image',
                    )) }}
                </div>

                <div class="panel-footer text-center">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

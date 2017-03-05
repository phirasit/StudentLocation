@extends('layouts.app')

@section('content')

<script type='text/javascript' src='{{ url('js/getLocation.js') }}'></script>
<script type="text/javascript">
    // define variables
    var getLocation_url = '{{ url('/getLocation') }}';
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
                    @foreach($students as $student)
                        <tr>
                            <td class='text-left' style='width:100%;'>
                                <span style='border-bottom-color: {{ $student['color'] }}; border-bottom-style: solid;'>
                                    {{ $student['name'] }}({{ $student['std_level'] }}/{{ $student['std_class'] }}) 
                                </span>
                            </td>
                            <td class="col-md-2">
                                <div id='{{ $student['std_id'] }}_location'>
                                    {{ $student['location'] }}
                                </div>
                            </td>
{{--                             <td class='col-md-1'>
                                <button href='' class='btn btn-primary'>
                                    CALL
                                </button>
                            </td>
 --}}
                            <script type='text/javascript'>
                                registerStudentDevice("{{ $student['device_mac_address'] }}", "{{ $student['std_id'] }}_location");
                            </script>
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

        <div class="col-md-8 text-left">
            <div class="panel panel-default">
                <div class="panel-heading">Current Location</div>

                <div class="panel-body text-center">
                    {{ HTML::image('img/map.gif') }}
                </div>

                <div class="panel-footer">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

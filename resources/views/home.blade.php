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
                    <button class="btn btn-primary" onclick="refreshLocation();">refresh</button>
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
                    <form action="{{ url('/manageStudent') }}" method="get" class='form-inline'>
                        <div class="input-group">
                            <input name='student_id' type='input' class='form-control span2' placeholder='Student ID'/>
                            <span class='input-group-addon btn label-success' style="border-color:green;">
                                <label for="add" class='label'>+</label>
                                <input id="add" name="type" type='submit' class='hidden btn btn-xs' value="add"/>
                            </span>
                            <span class='input-group-addon btn label-danger' style="border-color:brown;">
                                <label for="remove" class='label'>-</label>
                                <input id="remove" name="type" type='submit' class='hidden btn btn-xs' value="remove"/>
                            </span>
                        </div>
                    </form>
                    @if(session('addingStudent'))
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

                <div class="panel-body">
                </div>

                <div class="panel-footer">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

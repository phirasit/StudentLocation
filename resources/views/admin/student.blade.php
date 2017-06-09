@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">

            <!-- Student info -->
            @if (isset($student))
            <form action="{{ url('student/update/' . $student->id) }}" method="POST" enctype="multipart/form-data">

            <div class='panel panel-primary'>
                <div class='panel-heading text-left'>
                    Student Information
                </div>
                
                <div class='panel-body text-left' style="padding: 0;">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                    <div class="col-md-2" style="padding: 0; background: url('{{ url('image/portraits/' . $student->id) }}') no-repeat center; background-size: 90%; height: 200px; text-align: center; vertical-align: middle; line-height: 200px;">
                    </div>

                    <div class="col-md-10" style="padding: 0;">
                    <table class="table" style="margin: 0;">
                        <colgroup>
                            <col class="col-md-2">
                            <col class="col-md-2">
                            <col class="col-md-2">
                            <col class="col-md-2">
                            <col class="col-md-2">
                            <col class="col-md-2">
                        </colgroup>

                        <!-- Name --> 
                        <tr>
                            <td class="text-right"> Name </td>
                            <td colspan="5"> <div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
                                <input name='name' type='text' class='form-control' value='{{ old('name', $student->name) }}'> 
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div> </td>
                        </tr>

                        <tr>
                            <!-- ID -->
                            <td class='text-right'> Student ID </td>
                            <td> <div class="form-group{{ $errors->has('id') ? ' has-error' : ''}}">
                                <input name='id' type='text' class='form-control' value='{{ old('id', $student->std_id) }}'> 
                                @if ($errors->has('id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('id') }}</strong>
                                    </span>
                                @endif
                            </div> </td>

                            <!-- room -->
                            <td class='text-right'> Student room </td>
                            <td> <div class="form-group{{ $errors->has('room') ? ' has-error' : ''}}">
                                <input name='room' type='text' class='form-control' value='{{ old('room', $student->std_room) }}'> 
                                @if ($errors->has('room'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('room') }}</strong>
                                    </span>
                                @endif
                            </div> </td>

                            <!-- number -->
                            <td class='text-right'> Student No. </td>
                            <td> <div class="form-group{{ $errors->has('no') ? ' has-error' : ''}}">
                                <input name='no' type='text' class='form-control' value='{{ old('no', $student->std_no) }}'> 
                                @if ($errors->has('no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('no') }}</strong>
                                    </span>
                                @endif
                            </div> </td>
                        </tr>
                        
                        <!-- Device Mac Address -->
                        <tr>
                            <td class='text-right'> Device Mac Address </td>
                            <td colspan="5"> <div class="form-group{{ $errors->has('device_mac_address') ? ' has-error' : ''}}">
                                <input name='device_mac_address' type='text' class='form-control' value='{{ old("device_mac_address", $student->device_mac_address) }}'> 
                                @if ($errors->has('device_mac_address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('device_mac_address') }}</strong>
                                    </span>
                                @endif
                            </div> </td>
                        </tr>

                        <!-- upload new image -->
                        <tr>
                            <td class='text-right'> Upload new portrait image </td>
                            <td colspan="5">
                                <button type="button" class="btn btn-default" onclick='$("#upload").click();' style="display: inline;">
                                    upload new image
                                </button>
                                <div id="filename" style="display: inline;"> {{ old('file', '') }} </div>
                                <input type='file' id="upload" name='portrait_image' class="form-control" style="display: none;" onchange='$("#filename").text($(this).val().split("\\").pop());' accept="image/jpeg">
                            </td>
                        </tr>
                    </table>
                    </div>

                </div>

                <div class="panel-footer">
                    <!-- Submit button -->
                    <input type='submit' class='form-control btn btn-success' value='update information'>
                    @if (Session::has('message'))
                        <span class="help-block">
                            <strong>{{ Session::get('message') }}</strong>
                        </span>
                    @endif

                </div>
            </div>
            </form>
            @endif

            <!-- Student Search -->
            <div class='panel panel-info'>
                <div class='panel-heading text-left'>
                    Seach / New / Delete
                </div>

                <form action='{{ url("/student") }}' method='get'>
                <div class='panel-body text-center'>
                    <div class="form-group col-md-8{{ $errors->any() ? ' has-error' : '' }}">
                        <input name='id' type='text' class='form-control' placeholder='student id' value='{{ old('id', '') }}'>
                        @if ($errors->any())
                            <span class='help-block'>
                                @foreach ($errors->get('msg') as $error) 
                                    {{ $error }}
                                @endforeach
                            </span>
                        @endif
                    </div>

                    <button type="submit" name='type' class="btn btn-primary" value='search'>
                        <i class="glyphicon glyphicon-search"></i> Search
                    </button>
                    <button type="submit" name='type' class="btn btn-success" value='new'>
                        <i class="glyphicon glyphicon-plus"></i> New
                    </button>
                    <button type="submit" name='type' class="btn btn-danger" value='delete'>
                        <i class="glyphicon glyphicon-minus"></i> Delete
                    </button>
                </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

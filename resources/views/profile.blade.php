@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">

            <form action="{{ url('/profile/update') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="panel panel-default col-md-6" style="margin:10px;">

                <div class="panel-heading text-left">
                    Personal Information
                </div>

                <div class="panel-body">                
                <table class="table">
                    <colgroup>
                        <col class="col-md-4">
                        <col class="col-md-8">
                    </colgroup>
                    <tr>
                        <td class="text-right"> Name </td>
                        <td> {{ $user['name'] }} </td>
                    </tr>

                    <!-- Email -->
                    <tr>
                        <td class='text-right'> E-mail </td>
                        <td> 
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
                                <input name='email' type='email' class='form-control text-center' value='{{ old('email', $user['email']) }}'> 
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>

                    <!-- Car image -->
                    <tr>
                        <td class='text-right'> 
                            Car Image <br> 
                            {{ Html::image('image/cars/' . $user['id'], 'current image', ['width' => 100, 'height' => 100]) }}
                        </td>                        
                        <td>
                            <input name='car_image' type="file" accept=".jpg" class='form-control btn-primary'>
                            @if ($errors->has('car_image'))
                                <div class='has-error'><span class="help-block">
                                    @foreach ($errors->get('car_image') as $error)
                                        <strong>{{ $error }}</strong> <br>
                                    @endforeach
                                </span></div>
                            @endif
                        </td>
                    </tr>

                </table>
                </div>
            </div>

            <div class="panel panel-default col-md-5" style="margin: 10px;">

                <div class="panel-heading text-left">
                    Security
                </div>

                <div class="panel-body">                
                <table class="table">
                    <colgroup>
                        <col class="col-md-4">
                        <col class="col-md-8">
                    </colgroup>

                    <tr>
                        <td class='text-right'> New Password </td>
                        <td>

                            <!-- check old password -->
                            <div class="form-group{{ $errors->has('old_password') ? ' has-error' : ''}}">
                                <input type='password' name='old_password' class="form-control" placeholder="old password">
                                @if ($errors->has('old_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- get new password -->
                            <div class="form-group{{ $errors->has('new_password') ? ' has-error' : ''}}">
                                <input type='password' name='new_password' class="form-control" placeholder="new password">
                                <input type='password' name='con_password' class="form-control" placeholder="confirm new password">
                                @if ($errors->has('new_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </td>
                    </tr>
                </table>
                </div>

            </div>

            <!-- Add/Rem Student -->
            <div class="panel panel-default col-md-5" style="margin: 10px;">

                <div class="panel-heading text-left">
                    Add Student
                </div>

                <div class="panel-body">                
                <table class="table">
                    <colgroup>
                        <col class="col-md-4">
                        <col class="col-md-8">
                    </colgroup>

                    <tr>
                        <td class='text-right'> Student ID </td>
                        <td>

                            <!-- student id -->
                            <div class="form-group{{ $errors->has('student_id') ? ' has-error' : ''}}">
                                <input type='text' name='student_id' class="form-control" placeholder="student ID">
                                @if ($errors->has('student_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('student_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button name="submit" type="submit" value="add" class="btn btn-success">
                                Add
                            </button>
                            <button name="submit" type="submit" value="remove" class="btn btn-danger">
                                Delete
                            </button>

                            @if (session()->has('student_message'))
                                <div class='text-center'>
                                    {{ session('student_message') }}
                                </div>
                            @endif
                        </td>
                    </tr>
                </table>
                </div>

            </div>

            <div class='panel panel-default col-md-12' style="margin: 10px;">

                <!-- submit button -->
                <div class='panel-body'>
                    <input type="submit" name="submit" class="form-control btn btn-primary" value="update information">
                    <!-- response text -->
                    @if (session()->has('message'))
                        <div class='text-center'>
                            {{ session('message') }}
                        </div>
                    @endif
                </div>            
                
            </div>
            
            </form>
        </div>
    </div>
</div>
@endsection

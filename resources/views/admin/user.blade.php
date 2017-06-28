@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">

        
            <div class="panel panel-default col-md-12" style="margin:10px;">

            @if (isset($user))

                <form action="{{ url('/system/user/updateStatus/' . $user['id']) }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">    
    
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
                        <td> {{ $user['email'] }} </td>
                    </tr>

                    <!-- Car image -->
                    <tr>
                        <td class='text-right'> 
                            Car Image 
                        </td>
                        <td>
                            {{ Html::image('image/cars/' . $user['id'], 'current image', ['width' => 100, 'height' => 100]) }}
                        </td>                        
                    </tr>

                    <!-- Status -->
                    <tr>
                        <td class='text-right'> 
                            Status 
                        </td>
                        <td>
                            <select name="status" class="form-control">
                                <option value="0" {{ $user->getStatus() == 0 ? 'selected' : '' }}>Super Admin</option>
                                <option value="1" {{ $user->getStatus() == 1 ? 'selected' : '' }}>Admin</option>
                                <option value="2" {{ $user->getStatus() == 2 ? 'selected' : '' }}>Normal User</option>
                            </select>
                        </td>                        
                    </tr>
                    <tr>
                        <td class='text-right' colspan="2">
                            <input type="submit" name="submit" class="form-control btn btn-primary" value="update">
                        </td>                        
                    </tr>

                </table>
                </div>

                </form>

            @else

                <form action="{{ url('/system/user/email') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">    
    
                <div class="panel-heading text-left">
                    Get User
                </div>


                <div class="panel-body">                
                <table class="table">
                    <colgroup>
                        <col class="col-md-2">
                        <col class="col-md-5">
                        <col class="col-md-5">
                    </colgroup>
                    <!-- Email -->
                    <tr>
                        <td class='text-right'> E-mail </td>
                        <td> 
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
                                <input name='email' type='email' class='form-control text-center' value='{{ old('email', '') }}' placeholder="insert email"> 
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <input type="submit" name="submit" class="form-control btn btn-primary" value="search">
                        </td>
                    </tr>
                </table>
                </div> 
            
                </form>
                
            </div>

            @endif
            
        </div>
    </div>
</div>
@endsection

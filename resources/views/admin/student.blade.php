@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">

            <!-- Student info -->
            @if (isset($student))
            <form action="?" method="POST">
            <div class='panel panel-primary'>
                <div class='panel-heading text-left'>
                    Student Information
                </div>
                
                <div class='panel-body text-left' style="padding: 0;">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                    <div class="col-md-2" style="padding: 0; background: url('{{ url('image/portraits/' . $student->id) }}') no-repeat center; background-size: 90%; height: 200px;">
                    </div>

                    <div class="col-md-10" style="padding: 0;">
                    <table class="table" style="margin: 0;">
                        <colgroup>
                            <col class="col-md-4">
                            <col class="col-md-8">
                        </colgroup>
                        <!-- Name --> 
                        <tr>
                            <td class="text-right"> Name </td>
                            <td> <input type='text' class='form-control' value='{{ $student->name }}'> </td>
                        </tr>

                        <!-- ID -->
                        <tr>
                            <td class='text-right'> Student ID </td>
                            <td> <input type='text' class='form-control' value='{{ $student->id }}'> </td>
                        </tr>
                        
                        <!-- Device Mac Address -->
                        <tr>
                            <td class='text-right'> Device Mac Address </td>
                            <td> <input type='text' class='form-control' value='{{ $student->device_mac_address }}'> </td>
                        </tr>
                    </table>
                    </div>

                </div>

                <div class="panel-footer">
                    <!-- Submit button -->
                    <input type='submit' class='form-control btn btn-success' value='update information'>
                </div>
            </div>
            </form>
            @endif

            <!-- Student Search -->
            <div class='panel panel-info'>
                <div class='panel-heading text-left'>
                    Seach / New / Delete
                </div>

                <form action='?' method='get'>
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

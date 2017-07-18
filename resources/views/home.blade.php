@extends('layouts.app')

@section('content')

<script type="text/javascript">
    
    // define variables
    var getLocation_url = '{{ url('/getLocation') }}';
    var callStudent_url = '{{ url('/callStudent') }}';

    var canvasID = "mapCanvas";
    var mapINFO, timeLimit = 1000;
    var widthDistance, heightDistance;

</script>

{{ Html::style('css/style.css') }}

<div class="container">
    <div class="row">
        <div class="text-left" style="width: 100%;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $mode }}
                </div>

                <div class="panel-body text-center" style="padding: 0;">
                    @include('displays/' . $mode . '/main')
                </div>
                
                <div class="panel-footer">
                    <a href="{{ url('home/Description') }}" style="padding: 10px;"> Description </a>
                    <a href="{{ url('home/SchoolMap') }}" style="padding: 10px;"> School Map </a>
                </div>
                
            </div>
        </div>

  
    </div>
</div>

@endsection

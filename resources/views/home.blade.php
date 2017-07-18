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

<script type="text/javascript">
    // set autoload button
    var autoload = false;
    function toggleAutorefresh() {
        autoload = !autoload;
        if (autoload) {
            refresh();
        }
    }

    var lastRefresh;
    var limit = 2000;

    function refresh() {

        lastRefresh = new Date();
        refreshLocation(canvasID, mapINFO);

        if (autoload) {
            var now = new Date();
            var refreshLengthMillisec = (now.getTime() - lastRefresh.getTime()) * 1000;
            // console.log(now.getTime(), lastRefresh.getTime());
            setTimeout(refresh, Math.max(0, limit));
        }
    }

    // set onload function
    document.body.onload = function() {
        toggleAutorefresh();
    }

</script>

<div class="container">
    <div class="row">
        <div class="text-left" style="width: 100%;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $mode }}
                </div>

                <div class="panel-body" style="padding: 0;">
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

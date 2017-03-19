@extends('layouts.app')

@section('content')

<link rel="stylesheet" type="text/css" href="{{ url('css/style.css') }}">

<script type="text/javascript">

    var timeLimit = 5 * 1000;
    var data = [];

    function registerData(id, row) {
        data.push({
            "id": id,
            "row": row
        });
    }
    
    function runSlideShow(data) {
        if (data.length <= 0) {
            return;
        }
        var student = data[0];

        console.log(student.row);

        $("#"+student.row).addClass("sliding-middle-out");
        $("#main-display").fadeOut(500).html(
            student.id
        ).fadeIn(500);

        setTimeout(function() {
            $("#"+student.row).removeClass("sliding-middle-out");
            data.shift();
            runSlideShow(data)
        }, timeLimit);
    }

    function endSlideShow() {
        location.reload(true);
    }

    function startSlideShow() {
        console.log(Math.max(data.length, 1) * timeLimit);
        setTimeout(endSlideShow, Math.max(data.length, 1) * timeLimit);
        if (data.length > 0) {
            runSlideShow(data);
        } else {
            console.log("No Data");
        }
    }

    window.onload = startSlideShow;

</script>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Information
                </div>
                @if (count($student_list) == 0)
                    <div class="panel-body text-center" id='main-display'>
                        No Data
                    </div>
                @else
                    <div class="panel-body text-center" id='main-display' style='display:none;'>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Waiting List
                </div>
                <div class="panel-body">
                    @if (count($student_list) == 0)
                        No Data
                    @endif
                    @foreach ($student_list as $index => $student)
                        <div class='col-md-8'>
                            <span id="{{ $student['id'] }}_row">
                                {{ $index+1 }} {{ $student['name'] }} ( {{ $student['id'] }} )
                            </span>
                        </div>
                        <script type="text/javascript">
                            registerData({{ $student['id'] }}, "{{ $student['id'] }}_row");
                        </script>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

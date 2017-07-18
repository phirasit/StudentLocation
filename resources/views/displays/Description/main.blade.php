{{ Html::script('js/displays/Description/location.js') }}

<div style="margin: 10px;">
<table class='table-condensed' style="width: 100%;">
<thead>
    <tr style="border-bottom:1pt dashed gray;">
        <th class="col-md-1 text-center">#</th>
        <th class="col-md-2 text-center">STUDENT ID</th>
        <th class="col-md-4">Name</th>
        <th class="col-md-5 text-center">Location</th>
    </tr>
</thead>

@if (count($students) == 0) 
    <tr>
        <td colspan="3" class='text-center'>No Data</td>
    </tr>
@endif
@foreach ($students as $key => $student)
    <tr id='{{ $student['std_id'] }}_row'>
        <td class='text-center'>
            {{ $key+1 }}
        </td>
        <td class='text-center'>
            {{ $student['std_id'] }} 
            </div>
        </td>
        <td class='text-left'>
            <div id='{{ $student['std_id'] }}_name'>
            <span style='border-bottom-color: {{ $student['color'] }}; border-bottom-style: solid;'>
                {{ $student['name'] }}
                ({{ $student['std_level'] }}/{{ $student['std_class'] }})
            </span>
            </div>
        </td>
{{--                             
        <td class="col-md-1 text-center">
            {{ $student['message'] or "No Message" }}
        </td>
--}}
        <td class="text-center" style="padding: 10px;">
            <div id='{{ $student['std_id'] }}_location' style='display: inline-block;'>
            </div>
        </td>
    </tr>

    <script type="text/javascript">
        registerStudentDevice(
            "{{ $student['device_mac_address'] }}", 
            "{{ $student['std_id'] }}_location", 
            "{{ $student['color'] }}");
    </script>
@endforeach
</table>
</div>
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9 text-center">

            <div class='panel panel-default'>
                <div class='panel-heading text-left'>
                    Receiver Status
                </div>
                <div class="panel-body">

                    <!-- receiver -->
                    @if (isset($receivers) and count($receivers) > 0)
                        <table class="table table-striped" style="margin: 0;">
                        <caption class="text-center">
                        </caption>
                        <thead>
                            <td class="col-md-1"> ID </td>
                            <td class="col-md-2"> DEVICE MAC ADDRESS </td>
                            <td class="col-md-4"> AREA </td>
                            <td class="col-md-2"> IP ADDRESS </td>
                            <td class="col-md-2"> LAST COMMUNICATION </td>
                            <td class="col-md-1"></td>
                        </thead>

                        @foreach ($receivers as $idx => $receiver)
                            <tr>
                                <td> {{ $receiver->id }} </td>
                                <td> {{ $receiver->adapter_name }} </td>
                                <td>
                                    <input type='text' id='area{{$receiver->id}}' class='form-control text-center' value='{{ $receiver->area }}'>
                                </td>
                                <td>
                                    <input type='text' id='ip{{$receiver->id}}' class='form-control text-center' value='{{ long2ip($receiver->ip_address) }}'>
                                </td>
                                <td> 
                                    {{ $receiver->updated_at ? date('G:i:s', time() - strtotime($receiver->updated_at)) : 
                                    "-" }} </td>
                                <td> 
                                    <button type='submit' class="btn btn-success" onclick="submitReceiverEdit('{{$receiver->id}}');"> 
                                        update 
                                    </button> 
                                </td>
                            </tr>                                
                        @endforeach

                        <script type="text/javascript">
                            function submitReceiverEdit(id) {
                                $.post('{{ url('/system/receiver/edit') }}', {
                                    '_token': '{{ csrf_token() }}',
                                    'id': id,
                                    'area': $('#area' + id).val(),
                                    'ip': $('#ip' + id).val(),
                                }, function(response) {
                                    report(response);
                                });
                            }
                        </script>
                        
                        </table>
                    @endif


                </div>
                <div class="panel-footer">
                </div>
            </div>
            </form>
        </div>

        <div class="col-md-3 text-center">
            <div class='panel panel-default'>
                <div class='panel-heading text-left'>
                    Server response
                </div>
                <div class='panel-body text-left' id='response'></div>
                <script type="text/javascript">
                    function report(response) {
                        $("#response").text("...");
                        setTimeout(function() {
                            $("#response").text(response);  
                        }, 1000);
                    }
                </script>
                <div class='panel-footer'>
                    refresh to see the changes
                </div>
            </div>
        </div>

        <div class="col-md-3 text-center">
            <div class='panel panel-default'>
                <div class='panel-heading text-left'>
                    create / delete 
                </div>
                <div class='panel-body text-left' id='response'>
                    <div class='panel-body text-center'>
                        <input id='mac_address' type='text' class='form-control' placeholder='device mac address'> <br>
                        <button type="submit" name='type' class="btn btn-success" value='new' onclick='createReceiver();'>
                            <i class="glyphicon glyphicon-plus"></i> New
                        </button>
                        <button type="submit" name='type' class="btn btn-danger" value='delete' onclick='removeReceiver();'>
                            <i class="glyphicon glyphicon-minus"></i> Delete
                        </button>
                    </div>

                    <script type="text/javascript">
                        function createReceiver() {
                            var mac = $("#mac_address").val();
                            if (mac == "") { report("[ERROR] no mac address is given"); return; }
                            $.post('{{ url('/system/receiver/create') }}', {
                                '_token': '{{ csrf_token() }}',
                                'mac_address': mac,
                            }, function(response) {
                                report(response);
                            });
                        }
                        function removeReceiver() {
                            var mac = $("#mac_address").val();
                            if (mac == "") { report("[ERROR] no mac address is given"); return; }
                            $.post('{{ url('/system/receiver/remove') }}', {
                                '_token': '{{ csrf_token() }}',
                                'mac_address': mac,
                            }, function(response) {
                                report(response);
                            });
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

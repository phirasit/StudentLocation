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
                        <table id='receiver' class="table table-striped" style="margin: 0;">
                        <caption class="text-center">
                        </caption>
                        <thead>
                            <td class="col-md-1"> ID </td>
                            <td class="col-md-2"> DEVICE MAC ADDRESS </td>
                            <td class="col-md-3"> AREA </td>
                            <td class="col-md-2"> USER </td>
                            <td class="col-md-2"> IP ADDRESS </td>
                            <td class="col-md-1"> LAST COMMUNICATION </td>
                            <td class="col-md-1"></td>
                        </thead>

                        @foreach ($receivers as $idx => $receiver)
                            <tr id="{{ $receiver->id }}">
                                <td> {{ $receiver->id }} </td>
                                <td> {{ $receiver->adapter_name }} </td>
                                <td>
                                    <input type='text' id='area{{$receiver->id}}' class='form-control text-center' value='{{ $receiver->area }}'>
                                </td>
                                <td>
                                    <input type='text' id='user{{$receiver->id}}' class='form-control text-center' value='{{ $receiver->login_user }}'>
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
                                    'user': $('#user' + id).val(),
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
                        $("#response").html(response);  
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
                    Create / Delete 
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

        <div class="col-md-3 text-center">
            <div class='panel panel-default'>
                <div class='panel-heading text-left'>
                    Shell command 
                </div>
                <div class='panel-body text-left' id='response'>
                    <div class='panel-body text-center'>
                        <input id='command' type='text' class='form-control' placeholder='command'> <br>
                        <button type="submit" name='type' class="btn btn-primary" value='send' onclick='sendCommand();'>
                            <i class="glyphicon glyphicon-send"></i> Send
                        </button>

                    </div>

                    <script type="text/javascript">

                        var targets = [];
                        var toggle = function(event) {
                            var id = $(this).attr('id');
                            var idx = targets.indexOf(id);
                            if (idx != -1) {
                                targets.splice(idx, 1);
                                $(this).removeClass('info');
                            } else {
                                targets.push(id);
                                $(this).addClass('info');
                            }
                        };

                        function toggleAll() {
                            if (targets.length > 0) {
                                targets = [];
                                $(this).parent().parent().find('tbody tr').removeClass('info');
                            } else {
                                targets = [
                                @foreach ($receivers as $idx => $receiver)
                                    "{{ $receiver->id }}",
                                @endforeach
                                ];
                                $(this).parent().parent().find('tbody tr').addClass('info');
                            }
                        }

                        function sendCommand() {

                            var command = $("#command").val();
                            
                            if (targets.length == 0) {
                                alert("select targets first (by clicking the row)\n" + "NOTE: click header to select all");
                                return;
                            }

                            if (command == "") {
                                alert("insert command first");
                                return;
                            }
                            
                            function sendCommand(targets) {
                                
                                if (targets.length == 0) return;
                                var target = targets.pop();

                                $.post('{{ url('/system/receiver/command') }}', {
                                    '_token': '{{ csrf_token() }}',
                                    'id': target,
                                    'command': command,
                                }, function(response) {
                                    report(response);
                                    $("#" + target).removeClass('info');
                                    setTimeout(function() {
                                        sendCommand(targets)
                                    }, 500);
                                });
                            }

                            sendCommand(targets);
                        }

                        window.onload = function() {
                            $('#receiver tbody tr').click(toggle);
                            $('#receiver thead tr').click(toggleAll);
                        };

                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

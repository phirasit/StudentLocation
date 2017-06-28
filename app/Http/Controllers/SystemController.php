<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Adapter;

class SystemController extends Controller {

    public function getReceiver(Request $request) {
        if (!Auth::user()->isSuperAdmin()) return abort('403');
        return view('admin/system')->with('receivers', Adapter::all());
	}

    public function updateReceiver(Request $request) {
        if (!Auth::user()->isSuperAdmin()) return abort('403');

        $input = $request->all();

        $adapter = Adapter::getAdapterByID($input['id']);    
        if ($adapter == null) {
            return response('[ERROR] no adapter is found', 200)->header('Content-Type', 'text/plain');
        }

        if (!array_key_exists('area', $input) or !array_key_exists('ip', $input) or !array_key_exists('user', $input)) {
            return response('[ERROR] data is incomplete', 200)->header('Content-Type', 'text/plain');
        }
        if (!filter_var($input['ip'], FILTER_VALIDATE_IP)) {
            return response('[ERROR] '. $input['ip'] .' is not ip address', 200)->header('Content-Type', 'text/plain');    
        }
        
        $adapter->update([
            'area' => $input['area'],
            'login_user' => $input['user'],
            'ip_address' => ip2long($input['ip']),
            'updated_at' => $adapter->updated_at,
        ]);

        return response('[OK] update complete', 200)->header('Content-Type', 'text/plain');
    }

    public function createReceiver(Request $request) {
        if (!Auth::user()->isSuperAdmin()) return abort('403');

        $input = $request->all();

        // not mac address
        if (preg_match('/([a-fA-F0-9]{2}[:|\-]?){6}/', $input['mac_address']) != 1) {
            return response('[ERROR] ' . $input['mac_address'] . ' is not a mac address' , 200)->header('Content-Type', 'text/plain');
        }

        $adapter = Adapter::getAdapterByName($input['mac_address']);    
        if ($adapter == null) {
            Adapter::insert([
                'adapter_name' => $input['mac_address'],
            ]);
            return response('[OK] new adapter is created', 200)->header('Content-Type', 'text/plain');
        } else {
            return response('[ERROR] adapter is already existed', 200)->header('Content-Type', 'text/plain');
        }
    }

    public function removeReceiver(Request $request) {
        if (!Auth::user()->isSuperAdmin()) return abort('403');

        $input = $request->all();

        // not mac address
        if (preg_match('/([a-fA-F0-9]{2}[:|\-]?){6}/', $input['mac_address']) != 1) {
            return response('[ERROR] ' . $input['mac_address'] . 'is not mac address' , 200)->header('Content-Type', 'text/plain');
        }

        $adapter = Adapter::getAdapterByName($input['mac_address']);    
        if ($adapter == null) {
            return response('[ERROR] adapter is not existed', 200)->header('Content-Type', 'text/plain');
        } else {
            $adapter->delete();
            return response('[OK] adapter is deleted', 200)->header('Content-Type', 'text/plain');
        }
    }

    public function sendCommand(Request $request) {
        if (!Auth::user()->isSuperAdmin()) return abort('403');

        $input = $request->all();
        $adapter = Adapter::getAdapterByID($input['id']);    
        
        if ($adapter == null) {
            return response('[ERROR] adapter is not existed', 200)->header('Content-Type', 'text/plain');
        } else if ($input['command'] == '') {
            return response('[ERROR] no command to send', 200)->header('Content-Type', 'text/plain');    
        } else {


            // add ssh and stderr redirection
            $command = "ssh " . $adapter['login_user'] . "@" . $adapter->getIPAddress() . " " . $input['command'] . " 2>&1";

            $result = exec($command);

            $response = $result . "<br><br> - " . $command;
            return response('[OK] command is send<br>' . $response, 200)->header('Content-Type', 'text/plain');
        }
    }

    public function __construct() {
        $this->middleware('auth');
    }
}
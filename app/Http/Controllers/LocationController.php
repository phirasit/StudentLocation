<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Adapter;
use App\Device;
use App\Location;
use App\Student;

class LocationController extends Controller {


    public function getLocation(Request $request) {
        return Device::getArea($request->input('device_mac_address'));
    }

    public function sendLocation($adapter_name, Request $request) {

        $adapter = Adapter::getAdapterByName($adapter_name);

        if ($adapter == null) {
            return abort('403');
        }

        $content = $request->json()->all();
        $adapter_id = $adapter->id;
        $area = $adapter->area;

        foreach ($content['data'] as $device) {
        
            // update a brief location  
            Device::getDeviceByAddress($device_mac_address)->update_area($area);
        
            // enqueue the data for position triangulation
            Location::enqueue_new_position($adapter_id, $device['device_mac_address']);
        }

        return abort(200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Adapter;
use App\Device;
use App\Location;
use App\Student;
use App\WaitingList;

class LocationController extends Controller {


    public function getLocation(Request $request) {

        $device_mac_address = $request->input('device_mac_address');
        $device = Device::getDeviceByAddress($device_mac_address);

        if ($device == null) {
            return json_encode('');
        }

        Location::triangulatePosition($device->getID());

        $area = Device::getArea($device_mac_address);

        $data = [
            'area' => $area,
            'callButton' => WaitingList::getCallButton($device->id, $area),
            'location' => Device::getLocation($device_mac_address),
        ];

        return json_encode($data);
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
        
            $dev = Device::getDeviceByAddress($device['device_mac_address']);
            if ($dev == null) {
                continue;
            }

            if ($device['length'] != null and $device['length'] < env('RANGE_LIMIT', 20)) {
                
                // update a brief location  
                $dev->updateArea($area);
            }
        
            // enqueue the data for position triangulation
            Location::enqueueNewLocation($adapter_id, $dev, $device['length']);
        }

        return abort(200);
    }
}

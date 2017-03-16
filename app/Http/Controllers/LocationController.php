<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

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
            return Response::json('[]');
        }

        $res = Location::triangulatePosition($device->getID());
        $area = Device::getArea($device_mac_address);

        $data = [
            'area' => $area,
            'callButton' => WaitingList::getCallButton($device->id, $area),
            'location' => $res,
        ];

        return Response::json($data);
    }

    public function sendLocation($adapter_name, Request $request) {

        $adapter = Adapter::getAdapterByName($adapter_name);

        if ($adapter == null) {
            return response('The device is not registered', 200)
                  ->header('Content-Type', 'text/plain');
        }

        $content = $request->json()->all();

        $adapter_id = $adapter->id;
        $area = $adapter->area;
        $range = floatval($adapter->inside_length);

        foreach ($content['data'] as $device) {
        
            $dev = Device::getDeviceByAddress($device['device_mac_address']);

            if ($dev == null) {
                continue;
            }

            if ($device['length'] != null and floatval($device['length']) < $range) {
                
                // update a brief location  
                $dev->updateArea($area);
            }
        
            // enqueue the data for position triangulation
            Location::enqueueNewLocation($adapter_id, $dev, $device['length']);
        }

        return response('[OK] update complete', 200)
                  ->header('Content-Type', 'text/plain');
    }
}

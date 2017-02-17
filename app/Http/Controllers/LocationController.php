<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller {

    protected $student_table = 'students';
    protected $device_table = 'device_location';
    protected $adapter_table = 'adapters';
    protected $waiting_table = 'waiting';
    protected $waitngLIMIT = 10;

    public function getLocation(Request $request) {
        return $this->getRealLocation($request->input('device_mac_address'));
    }

    public function getRealLocation($device_mac_address) {

        $device = DB::table($this->device_table)
            ->where('device_mac_address', $device_mac_address)
            ->first();

        if ($device == null) {
            return "error";
        } else {
            return $device->area;
        }
    }


    public function sendLocation($adapter_id, Request $request) {

    	$adapter = DB::table($this->adapter_table)
    		->where('adapter_name', $adapter_id)
    		->first();

    	if ($adapter == null) {
    		return abort('403');
    	}

        $content = $request->json()->all();
    	$area = $adapter->area;

    	foreach ($content['data'] as $device) {

    		$device_mac_address = $device['device_mac_address'];
    		$device_strength = $device['signal_strength'];
    		
    		$device = DB::table($this->device_table)
    			->where('device_mac_address', $device_mac_address);

    		if ($device != null) {
    			$device->update([
                    'area' => $area,
                ]);
    		}
    	}

        return abort(200);
    }

    public function displayWaiting($location) {

    	$students = [];
    	foreach (DB::table($this->waiting_table)
            ->where('area', $location)
    		->take($this->waitngLIMIT)
    		->get() as $student) {

    		$student_data = DB::table($this->student_table)->where('id', $student->id)->first();
    		array_push($students, [
    			'id' => $student_data->std_id,
    			'name' => $student_data->name,
    		]);
    	}

    	return view('waiting')->with('student_list', $students);
    }
}

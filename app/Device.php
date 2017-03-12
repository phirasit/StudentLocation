<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model {

    protected $fillable = ['area', 'location_x', 'location_y', 'location_z'];
    
    const UPDATE_AT = 'last_checkin';

    public static function getDeviceByID($device_id) {
    	return Device::where('id', $device_id)->first();
    }

    public static function getDeviceByAddress($device_mac_address) {
    	return Device::where('device_mac_address', $device_mac_address)->first();
    }

    public static function getArea($device_mac_address) {
    	$device = Device::getDeviceByAddress($device_mac_address);
    	return ($device == null ? "error" : $device->area);
    }
    public static function getLocation($device_mac_address) {
        $device = Device::getDeviceByAddress($device_mac_address);
        return ($device == null ? [0, 0, 0] : $device->getCurrentLocation());
    }

    public function updateArea($area) {
        $this->update(['area' => $area]);
    }

    public function updateLocation($position) {
        return $this->update([
            'location_x' => $position[0],
            'location_y' => $position[1],
            'location_z' => $position[2],
        ]);
    }

    public function getID() {
        return $this->id;
    }
    
    public function getLastUpdatedTime() {
        return $this->updated_at;
    }

    public function getCurrentLocation() {
        return [$this->location_x, $this->location_y, $this->location_z];
    }
}

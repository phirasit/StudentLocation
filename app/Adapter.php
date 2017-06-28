<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adapter extends Model
{
	protected $fillable = ['area', 'ip_address', 'login_user'];
    
	public static function getAdapterByID($adapter_id) {
		return Adapter::where('id', $adapter_id)->first();
	}

	public static function getAdapterByName($adapter_name) {
		return Adapter::where('adapter_name', $adapter_name)->first();
	}

	public function getPosition() {
		return array($this->location_x, $this->location_y, $this->location_z);
	}

	public function getIPAddress() {
		return long2ip($this->ip_address);
	}

	public function getSpecificPosition($idx) {
		if ($idx == 0) return $this->location_x;
		if ($idx == 1) return $this->location_y;
		if ($idx == 2) return $this->location_z;
		return -1;
	}

    public function getLastUpdatedTime() {
    	return $this->updated_at;
    }
}

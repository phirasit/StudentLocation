<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \SSH;
use \DateTime;

class Location extends Model {

    protected $fillable = ['device_id', 'adapter_id'];

    public function getLastUpdatedTime() {
        return $this->updated_at == null ? 0 : $this->updated_at->format('U');
    }

    public static function enqueueNewLocation($adapter_id, $device, $length) {

        $res = Location::firstOrNew([
    		'device_id' => $device->id,
    		'adapter_id' => $adapter_id,
    	]);

        $res->length = $length;
        $res->touch();

        $res->save();

        return $res;
    }

    private static function getPathToProgram() {
        return base_path('app/Helpers/Triangulation/main.out');
    }

    // /**
    //  * Find norm-2 of the difference vector
    //  *
    //  * @param two arrays of numbers (same size)
    //  * @return double (squared distance of the vectors)
    //  */
    // private static function distance2($position1, $position2) {
    //     return array_sum(array_map(function($a, $b) {
    //         return pow($a - $b, 2);
    //     }, $position1, $position2));
    // }

    /**
	 * Triangulate to locate the position of the device
	 * 
	 * @param $device_id the id of the device
	 *
	 * @return string error message if the triangulation fails
	 * @return list of position and speed vector if the triangulation is successful
     */
    public static function triangulatePosition($device_id) {

    	$currentTime = time();

    	// select only the latest 8 adapters
    	$allRecord = Location::where('device_id', $device_id)
            // ->orderBy('updated_at', 'desc')
            ->orderBy('length', 'asc')
            ->take(env('MAXIMUM_TRIANGULATION_ADAPTERS', 3))
            ->get()->all();

        $allRecord = array_filter($allRecord, function($record) use ($currentTime) {
            // return $currentTime - $record->getLastUpdatedTime() <= env('MAXIMUM_DELAY_TIME', 30);
            return true;
        });

        // number of recieved adapters is not enough
        if (count($allRecord) < env('MINIMUM_NUMBER_OF_TRIANGULATION_ADAPTERS', 3)) {
            return 'There are not enough adapters here';
        }
        

    	// get all info of each adapters
    	foreach ($allRecord as &$record) {
    		$record->adapter = Adapter::getAdapterByID($record->adapter_id); 
    	}

        $dimension = count($allRecord[0]->adapter->getPosition());
        $device = Device::getDeviceByID($device_id);
        $position = $device->getCurrentLocation();
        
        $data = ' ';
        $data .= count($allRecord) . ' ';
        $data .= $dimension . ' ';
        foreach ($allRecord as &$record) {
            foreach ($record->adapter->getPosition() as $pos) {
                $data .= $pos . ' ';
            }
            $data .= $record->getLastUpdatedTime() . ' ';
            $data .= $record->length . ' ';
            $data .= ' ';
        }
        foreach ($position as $pos) {
            $data .= $pos . ' ';
        }

        $path_to_program = Location::getPathToProgram();

        
        $output = shell_exec($path_to_program . ' ' . $data);

        $position = array_map('floatval', explode(' ', trim($output)));
        $device->updateLocation($position);

		return $position;
        // return $output;
        // return $data;
    }
}

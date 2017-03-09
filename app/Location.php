<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \DateTime;

class Location extends Model {

    protected $fillable = ['device_id', 'adapter_id'];

    public function getLastUpdatedTime() {
        return $this->updated_at->format('U');
    }

    public static function enqueueNewLocation($adapter_id, $device, $length) {

    	$record = Location::firstOrNew([
    		'device_id' => $device->id,
    		'adapter_id' => $adapter_id,
    	]);

    	$record->length = $length;
    	$record->save();
    }

    /**
     * Find norm-2 of the difference vector
     *
     * @param two arrays of numbers (same size)
     * @return double (squared distance of the vectors)
     */
    private static function distance2($position1, $position2) {
        return array_sum(array_map(function($a, $b) {
            return ($a - $b) * ($a - $b);
        }, $position1, $position2));
    }

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
            ->orderBy('updated_at', 'desc')
    		->take(env('MAXIMUM_TRIANGULATION_ADAPTERS', 8))
            ->get()
            ->all();

        $allRecord = array_filter($allRecord, function($record) use ($currentTime) {
            return $currentTime - $record->getLastUpdatedTime() <= env('MAXIMUM_DELAY_TIME', 1000);
        });

        // number of recieved adapters is not enough
        if (count($allRecord) < env('MINIMUM_TRIANGULATION_ADAPTERS', 4)) {
            return 'There are not enough adapters here';
        }
        

    	// get all info of each adapters
    	foreach ($allRecord as &$record) {
    		$record->adapter = Adapter::getAdapterByID($record->adapter_id); 
    	}

    	// run gradient descent
    	/*
    	D = 1/4 * sum( e^((ti-T)/alpha) * (dx^2 + dy^2 + dz^2 - l^2)^2 )
    	dD/dx = 1/4 * sum( e^((ti-T)/alpha) * 2*(dx^2 + dy^2 + dz^2 - l^2) * (2*(x-xi)) )
    	same as dD/dy and dD/dz
    	*/

    	$T = $allRecord[0]->getLastUpdatedTime();
        $T = $currentTime;
        $alpha = 10.0;
        $learning_rate = 0.001;
        $dimension = count($allRecord[0]->adapter->getPosition());

        foreach ($allRecord as &$record) {
            $record->coef = exp(($record->getLastUpdatedTime() - $T) / $alpha);
        }
    	
        $position = $allRecord[0]->adapter->getPosition();
    	
        for ($i = 0 ; $i < env('ITERATIONS', 100) ; ++$i) {

            $gradiences = [];
            for ($idx = 0 ; $idx < $dimension ; ++$idx) {
                $gradient = 0;
                foreach ($allRecord as &$record) {
                    $gradient += $record->coef 
    					* (Location::distance2($record->adapter->getPosition(), $position) + $record->length)
    					* ($position[$idx] - $record->adapter->getSpecificPosition($idx));
                }
                $gradiences[$idx] = $gradient;
            }

            for ($j = 0 ; $j < $dimension ; ++$j) {
                $position[$j] -= $learning_rate * $gradiences[$j];
            }
    	}
		
		$device = Device::getDeviceByID($device_id);

		// $time_elapsed = $currentTime - $T;
		// $position = array_map(function($x, $v) use ($time_elapsed) {
		// 	return $x + $time_elapsed * $v;
		// }, $position, $velocity);

		$device->updateLocation($position);

		return '';
    }
}

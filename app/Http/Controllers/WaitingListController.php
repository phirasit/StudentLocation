<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Device;
use App\Student;
use App\WaitingList;

use \Exception;
use \DateTime;

class WaitingListController extends Controller
{


    public function displayWaiting($location) {

        $time = new DateTime();
        $timestamp = $time->getTimestamp();

        $students = [];

        foreach (WaitingList::getListOfStudent($location, env('DISPLAY_LIMIT', 10))
        	->cursor() as $record) {

            $student = Student::getStudentByID($record->id);

            if ($student != null 
                and $record->updated_at != null 
                and ($timestamp - $record->updated_at->format('U')) < env('TIME_LIMIT_PER_CALL_REQUEST', 30)) {
                array_push($students, [
                    'id' => $student->std_id,
                    'name' => $student->name,
                ]);                
            }
        }

        return view('waiting')->with('student_list', $students);
    }

    public function callStudent($device_mac_address, $area) {

        try {
            $id = Device::getDeviceByAddress($device_mac_address)->id;
            $record = WaitingList::firstOrNew(array(
                'id' => $id,
                'area' => $area,
            ));

            $record->touch();
            
            return 'successfully called ' . $device_mac_address;
        } catch (Exception $e) {
            return $e;
        }

    }
}

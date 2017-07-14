<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Device;
use App\Student;
use App\User;
use App\UserStudent;

use Exception;
use Hash;
use Validator;
use Storage;
use File;

class StudentController extends Controller {

	public function index(Request $request) {

		if (!Auth::user()->isAdmin()) return abort(403, 'permission denied');

		$std_id = $request->input('id');
		$type = $request->input('type');

		if ($type == null) return view('admin/student');
		if ($std_id == null) return view('admin/student')->withErrors(['msg' => 'insert student id']);
		
		$student = Student::getStudentByStudentID($std_id);
		if ($type == "search") {
			if ($student == null) {
				return view('admin/student')->withErrors(['msg' => 'record is not exist']);
			} else if (Auth::user()->isAdmin() or UserStudent::RelationshipExisted(Auth::user()->id, $student->id)) {
				return view('admin/student')->with('student', $student);
			} else {
				return abort(403, 'permission denied');
			}
		} else if ($type == "new") {
			if ($student != null) return view('admin/student')->withErrors(['msg' => 'this ID is taken']);
			Student::insert([
				"std_id" => $std_id
			]);
			$student = Student::getStudentByStudentID($std_id);
			return view('admin/student')->with('student', $student);
		} else if ($type == "delete") {
			if ($student == null) return view('admin/student')->withErrors(['msg' => 'this record is not exist']);
			$student->delete();
			return view('admin/student');
		}
	}

    public function updateStudent($id, Request $request) {

        // checking for security
        // if (!$request->secure()) return abort('500', "we can't take this request");    

        $student = Student::getStudentById($id);
        if ($student == null) return redirect()->back();

        $input = $request->all();

        $rules = [];
        $message = [];
        $updated = [];

        // changing name
        if ($input['name'] != $student->name) {

            $rules = array_merge($rules, [
                'name' => 'required|max:100|unique:students,name'
            ]);
            $message = array_merge($message, [
                'name.required' => 'name is necessary',
                'name.max' => 'this is too long',
                'name.unique' => 'this name is already taken',
            ]);

            array_push($updated, 'name');
        }

        // changing id
        if ($input['id'] != $student->std_id) {

            $rules = array_merge($rules, [
                'id' => 'required|max:10|unique:students,std_id'
            ]);
            $message = array_merge($message, [
                'id.required' => 'student ID is necessary',
                'id.max' => 'this is too long',
                'id.unique' => 'this ID is already taken',
            ]);

            array_push($updated, 'id');
        }

        // changing room
        if ($input['room'] != $student->std_room) {

            $rules = array_merge($rules, [
                'room' => 'required|integer|max:70'
            ]);
            $message = array_merge($message, [
                'room.required' => 'student room is necessary',
                'room.integer' => 'it\'s not a number',
                'room.max' => 'it\'s too large',
            ]);

            array_push($updated, 'room');
        }

        // changing no
        if ($input['no'] != $student->std_no) {

            $rules = array_merge($rules, [
                'no' => 'required|integer|max:100'
            ]);
            $message = array_merge($message, [
                'no.required' => 'student number is necessary',
                'no.integer' => 'it\'s not a number',
                'no.max' => 'this is too large',
            ]);

            array_push($updated, 'no');
        }

        // changing device mac address
        if ($input['device_mac_address'] != $student->device_mac_address) {

            // extend validator to support mac address checking
            Validator::extend('mac_address', function ($attribute, $value, $parameters) {
                return (preg_match('/([a-fA-F0-9]{2}[:|\-]?){6}/', $value) == 1);
            });

            $rules = array_merge($rules, [
                'device_mac_address' => 'required|mac_address|unique:students,std_id'
            ]);
            $message = array_merge($message, [
                'device_mac_address.required' => 'device mac address is necessary',
                'device_mac_address.mac_address' => 'this is not a mac address',
                'device_mac_address.unique' => 'this mac address is already taken',
            ]);

            array_push($updated, 'device_mac_address');
        }

        // check uploading file
        if ($request->hasFile('portrait_image') and $request->file('portrait_image')->isValid()) {

            $rules = array_merge($rules, [
                'portrait_image' => 'mimes:jpeg|max:' . env('PORTRAIT_IMAGE_MAX_SIZE_KB', '10240'),
            ]);
            $message = array_merge($message, [
                'portrait_image.mimes' => 'wrong file type only (jpeg)',
                'portrait_image.max' => 'this file is larger than :max KB',
            ]);

            array_push($updated, 'portrait_image');
        }

        // check authentication before trying to edit password
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();         
        }

        // update and save all the information
        if (in_array('name', $updated)) $student->name = $input['name'];
        if (in_array('id', $updated)) $student->std_id = $input['id'];
        if (in_array('room', $updated)) $student->std_room = $input['room'];
        if (in_array('no', $updated)) $student->std_no = $input['no'];
        if (in_array('device_mac_address', $updated)) {
            $student->device_mac_address = $input['device_mac_address'];
            if (Device::getDeviceByAddress($input['device_mac_address']) == null) {
                Device::insertNewRecord($input['device_mac_address']);
            }
        }
        $student->save();

        // uploading the image
        if (in_array('portrait_image', $updated)) {
            try {
                $img = $request->file('portrait_image');
                $portrait_imageDir = storage_path( env('STORAGE_IMAGE_DIR', 'app') . '/portraits' );
                $filename = strtolower($student->id . '.' . $img->getClientOriginalExtension());
                $img->move($portrait_imageDir, $filename);  
            } catch (Exception $e) {
                return redirect()->back()->with('message', 'information updated (but image is not uploaded');
            }
        }

        return redirect('/student?type=search&id=' . $student->std_id)->with('message', 'information updated');
    }
}
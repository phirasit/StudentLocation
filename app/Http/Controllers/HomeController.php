<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Device;
use App\Student;
use App\UserStudent;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    protected $randomColor = ['#90EE90', '#FCAEFC', '#87CEFA', '#F08080', '#008080'];

    /**
     * Show the application main page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        // recieve every students who are related to user
        $students = [];

        foreach (UserStudent::getRelationship(Auth::user()->id)->cursor() as $relationship) {
            
            $student = Student::getStudentByID($relationship->student_id);

            if($student == null) {
                array_push($students, [
                    'name' => 'Student is not registered',
                    'std_id' => 'unknown',
                    'std_level' => 'null',
                    'std_class' => 'null',
                    'student_mac_address' => 'null',
                    'location' => 'unknown',                    
                    'color' => 'black',
                ]);
            } else {
                array_push($students, [
                    'name' => $student->name,
                    'std_id' => $student->std_id,
                    'std_level' => (int)($student->std_room/10),
                    'std_class' => $student->std_room%10,
                    'location' => Device::getArea($student->device_mac_address),
                    'color' => $this->randomColor[ count($students) % count($this->randomColor)],
                    'device_mac_address' => $student->device_mac_address,
                ]);
            }
        }

        return view('home')->with('students', $students);
    }

    /**
     * when user try to add/remove a student
     *
     * @return \Illuminate\Http\Response
     */
    public function manageStudent(Request $request) {

        $student_id = $request->input('student_id');
        $type = $request->input('type');

        $student = Student::getStudentByStudentID($student_id);
        if ($student == null) {
            return redirect('home')->with('addingStudent', [
                'success' => false,
                'message' => 'This ID is not in the database',
            ]);
        }

        if ($type == 'add') {

            $result = UserStudent::addNewRelationship(Auth::user()->id, $student->id); 

            if ($result == '') {
                return redirect('home')->with('addingStudent', [
                    'success' => true,
                    'message' => 'New Record is successfully added',
                ]);
            } else {
                return redirect('home')->with('addingStudent', [
                    'success' => false,
                    'message' => $result,
                ]);
            }
        } else if ($type == 'remove') {

            $result = UserStudent::removeRelationship(Auth::user()->id, $student->id);

            if ($result == '') {
                return redirect('home')->with('addingStudent', [
                    'success' => true,
                    'message' => 'This Record has been deleted',
                ]);                
            } else {
                return redirect('home')->with('addingStudent', [
                    'success' => false,
                    'message' => $result,
                ]);
            }
        } else {
            return abort(404);
        }
    }

    public function updateProfile() {
        return view('updateProfile');
    }

}
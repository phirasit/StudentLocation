<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    protected $students_table = 'students';
    protected $user_student_relationship_table = 'user_student_relationship';
    protected $device_table = 'device_location';
    protected $randomColor = ['#90EE90', '#FCAEFC', '#87CEFA', '#F08080', '#008080'];

    /**
     * Show the application main text.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        // recieve every students who related to user
        $students = [];
        foreach (DB::table($this->user_student_relationship_table)
                ->where('user_id', Auth::user()->id)
                ->get() as $user) {
            
            $student = DB::table($this->students_table)
                ->where('id', $user->student_id)
                ->first();

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
                    'location' => app('App\Http\Controllers\LocationController')->getRealLocation($student->device_mac_address),
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

        $userCurrentStudents = DB::table($this->user_student_relationship_table)
            ->where('user_id', Auth::user()->id);


        $student = DB::table('students')->where('std_id', $student_id)->first();
        if ($student == null) {
            return redirect('home')->with('addingStudent', [
                'success' => false,
                'message' => 'Student is not in the database',
            ]);
        }

        if ($type == 'add') {

            $numStudent = $userCurrentStudents->count();
            $maximum_student_num_per_user = env('STUDENT_LIMIT', 5);
            $userRelationExist = $userCurrentStudents->where('student_id', $student->id)->exists();

            if ($numStudent < $maximum_student_num_per_user and $userRelationExist == false) {
                DB::table($this->user_student_relationship_table)->insert([
                    'user_id' => Auth::user()->id,
                    'student_id' => $student->id,
                ]);
                return redirect('home')->with('addingStudent', [
                    'success' => true,
                    'message' => 'New Record is successfully added',
                ]);
            } else {
                return redirect('home')->with('addingStudent', [
                    'success' => false,
                    'message' => ($numStudent >= $maximum_student_num_per_user ?
                        "Maximum number of student reach" : 
                        "This student has already been added"),
                ]);
            }
        } else if ($type == 'remove') {

            $relation = $userCurrentStudents->where('student_id', $student->id);

            if ($relation->exists()) {
                $relation->delete();
                return redirect('home')->with('addingStudent', [
                    'success' => true,
                    'message' => 'This student has been deleted',
                ]);                
            } else {
                return redirect('home')->with('addingStudent', [
                    'success' => false,
                    'message' => 'This student is not in your list',
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

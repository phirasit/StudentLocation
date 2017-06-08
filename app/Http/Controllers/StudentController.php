<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Device;
use App\Student;
use App\UserStudent;

class StudentController extends Controller {

	public function index(Request $request) {

		$std_id = $request->input('id');

		if ($std_id != null) {
			$student = Student::getStudentByStudentID($std_id);
			if ($student == null) {
				return redirect()->back()->withInput()->withErrors(['msg' => 'record is not found']);
			} else if (Auth::user()->isAdmin() or UserStudent::RelationshipExisted(Auth::user()->id, $student->id)) {
				return view('admin/student')->with('student', $student);
			} else {
				return abort(403, 'permission denied');
			}
		} else {
			if (!Auth::user()->isAdmin()) return abort(403, 'permission denied');
			return view('admin/student');
		}
		

	}
}
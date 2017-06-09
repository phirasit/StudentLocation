<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {

	public static function getStudentByID($id) {
		return Student::where('id', $id)->first();
	}

	public static function getStudentByStudentID($std_id) {
		return Student::where('std_id', $std_id)->first();
	}
}
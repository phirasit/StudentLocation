<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStudent extends Model
{
    
    public $table = 'user_student_relationships';

    public static function getRelationship($user_id) {
        return UserStudent::where('user_id', $user_id);
    }
    public static function RelationshipExisted($user_id, $std_id) {
    	return UserStudent::getRelationship($user_id)->where('student_id', $std_id)->exists();
    }

    public static function countRelationship($user_id) {
    	return UserStudent::getRelationship($user_id)->where('user_id', $user_id)->count();
    }

    public static function addNewRelationship($user_id, $std_id) {

    	if (UserStudent::RelationshipExisted($user_id, $std_id)) {
    		return 'This record is already added';
    	}

    	if (UserStudent::countRelationship($user_id) >= env('MAX_STUDENT_ALLOW', INF)) {
    		return 'Maximum number of allowed records reached';
    	}

    	UserStudent::insert([
   			'user_id' => $user_id,
   			'student_id' => $std_id
   		]);

   		return '';
    }

    public static function removeRelationship($user_id, $std_id) {

    	if (!UserStudent::RelationshipExisted($user_id, $std_id)) {
    		return 'This record is not in the list';
    	}

    	UserStudent::where('user_id', $user_id)->where('student_id', $std_id)->delete();

    	return '';
    }
}

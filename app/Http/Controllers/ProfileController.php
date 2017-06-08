<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use Hash;
use Validator;
use Storage;
use File;

use App\User;

class ProfileController extends Controller {


    public function showProfile(Request $request) {

        return view('profile')->with('user', Auth::user());
    }

    public function getImage($folder, $id) {
    	if ($id == Auth::user()->id or Auth::user()->isAdmin()) {
            $dir = storage_path(env('STORAGE_DIR', 'app') .'/'. $folder .'/'. $id . '.jpg');
            if (File::exists($dir)) {
                $file = File::get($dir);
        	    return response($file, 200)->header('Content-Type', 'image/jpeg');
            } else {
                $file = File::get(public_path('img/noimage.png'));
                return response($file, 200)->header('Content-Type', 'image/jpeg');
                }
    	} else {
    		return abort(404);
    	}
    }

    public function updateProfile(Request $request) {

    	// checking for security
    	// if (!$request->secure()) return abort('403');	

    	$input = $request->all();

    	$rules = [];
    	$message = [];
	    $updated = [];

	    // changing email
	    if ($input['email'] != Auth::user()->email) {

    		$rules = array_merge($rules, [
    			'email' => 'required|email|max:100|unique:users'
	    	]);
	    	$message = array_merge($message, [
	    		'email.required' => 'email is necessary',
	    		'email.email' => 'this is not an email',
	    		'email.unique' => 'this email is already taken',
	    	]);

	    	array_push($updated, 'email');
	    }

		// check uploading file
		if ($request->hasFile('car_image') and $request->file('car_image')->isValid()) {

    		$rules = array_merge($rules, [
    			'car_image' => 'mimes:jpeg|max:' . env('CAR_IMAGE_MAX_SIZE_KB', '10240'),
	    	]);
	    	$message = array_merge($message, [
	    		'car_image.mimes' => 'wrong file type only (jpeg)',
	    		'car_image.max' => 'this file is larger than :max KB',
	    	]);

	    	array_push($updated, 'car_image');
		}

    	// changing password
    	if ($input['old_password'] . $input['new_password'] . $input['con_password'] != '') {

	    	// extend validator to support password checking
	    	Validator::extend('check_hashed_pass', function ($attribute, $value, $parameters) {
	    		return Hash::check($value, $parameters[0]);
	    	});

    		$rules = array_merge($rules, [
    			'old_password' => 'required|check_hashed_pass:' . Auth::user()->password,
    			'new_password' => 'required|min:4|same:con_password'
    		]);
    		$message = array_merge($message, [
    			'old_password.required' => 'insert password',
	    		'old_password.check_hashed_pass' => 'incorrect password',

	    		'new_password.required' => 'password is required',
	    		'new_password.min' => 'your password is too short(atleast :min chars)',
	    		'new_password.same' => 'passwords don\'t match'
    		]);

    		array_push($updated, 'password');
	    }

    	// check authentication before trying to edit password
    	$validator = Validator::make($input, $rules, $message);
    	if ($validator->fails()) {
    		return redirect()->back()->withErrors($validator)->withInput();    		
    	}

    	// update and save all the information
    	if (in_array('email', $updated)) Auth::user()->email = $input['email'];
    	if (in_array('password', $updated)) Auth::user()->password = bcrypt($input['new_password']);
    	Auth::user()->save();

    	// uploading the image
    	if (in_array('car_image', $updated)) {

    		try {
	    		$img = $request->file('car_image');
				$car_imageDir = storage_path( env('CAR_IMAGE_DIR', 'app/cars') );
	    		$filename = strtolower(Auth::user()->id . '.' . $img->getClientOriginalExtension());
	    		$img->move($car_imageDir, $filename);   
    		} catch (Exception $e) {
    			return redirect('/profile')->with('message', 'information updated (but image is not uploaded');
    		}

    	}
    	
    	return redirect('/profile')->with('message', 'information updated');
    }

}
<?php

use Illuminate\Database\Seeder;

use App\Adapter;
use App\Device;
use App\Student;
use App\User;

class DatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

    	Eloquent::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(DeviceLocationTableSeeder::class);
        $this->call(AdapterTableSeeder::class);
        $this->call(UserStudentRelationshipTableSeeder::class);
        $this->call(WaitingSeeder::class);

        $this->command->info('finishing sending data');
    }
}

// create temporary database
class UsersTableSeeder extends Seeder {

	public function run() {

		// clear database
		User::truncate();

		User::insert([
			'name' 		=> 'admin',
			'email' 	=> 'admin@CUD.com',
			'password' 	=> bcrypt('admin'),
		]);

	}
}

class StudentsTableSeeder extends Seeder {

	public function run() {

		// clear database
		Student::truncate();

		Student::insert([
			'name' 		=> 'นาย A',
			'std_id' 	=> 47411449,
			'std_room' 	=> 67,
			'std_no'	=> 39,
			'device_mac_address' => 'TBA1',
		]);

		Student::insert([
			'name' 		=> 'mr B',
			'std_id' 	=> 12345674,
			'std_room' 	=> 32,
			'std_no'	=> 4,
			'device_mac_address' => 'TBA2',
		]);
	}
}


class AdapterTableSeeder extends Seeder {

	public function run() {

		// clear database
		Adapter::truncate();

		Adapter::insert([
			'adapter_name' => '66:39:21:1A:E7:B9',
			'area' => 'Robotic club',
			'location_x' => 0,
			'location_y' => 0,
			'location_z' => 0,
		]);
	}
}

class DeviceLocationTableSeeder extends Seeder {

	public function run() {

		// clear database
		Device::truncate();

		Device::insert([
			'device_mac_address' => 'TBA1',
			'area' => 'Door1',
			'location_x' => 0,
			'location_y' => 0,
			'location_z' => 0,
		]);

		Device::insert([
			'device_mac_address' => 'TBA2',
			'area' => 'Room404',
			'location_x' => 0,
			'location_y' => 0,
			'location_z' => 0,
		]);

		Device::insert([
			'device_mac_address' => 'FF:FF:40:00:15:0D',
			'area' => '',
			'location_x' => 0,
			'location_y' => 0,
			'location_z' => 0,
		]);
	}
}

class UserStudentRelationshipTableSeeder extends Seeder {

	public function run() {

		// clear database
		DB::table('user_student_relationships')->truncate();

		DB::table('user_student_relationships')->insert([
			'user_id' => User::where('name', 'admin')->first()->id,
			'student_id' => Student::where('std_id', 47411449)->first()->id,
		]);

		DB::table('user_student_relationships')->insert([
			'user_id' => User::where('name', 'admin')->first()->id,
			'student_id' => Student::where('std_id', 12345674)->first()->id,
		]);
	}	
}

class WaitingSeeder extends Seeder {

	public function run() {

		DB::table('waitinglists')->truncate();

		DB::table('waitinglists')->insert([
			'id' => 0,
			'area' => 'Door1',
		]);
		DB::table('waitinglists')->insert([
			'id' => 0,
			'area' => 'Door2',
		]);

		DB::table('waitinglists')->insert([
			'id' => Student::getStudentByStudentID(47411449)->id, 
			'area' => 'Door1'
		]);

		DB::table('waitinglists')->insert([
			'id' => Student::getStudentByStudentID(12345674)->id, 
			'area' => 'Door1'
		]);

		DB::table('waitinglists')->insert([
			'id' => Student::getStudentByStudentID(12345674)->id, 
			'area' => 'Door2'
		]);
	}
}

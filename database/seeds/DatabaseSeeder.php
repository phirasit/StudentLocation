<?php

use Illuminate\Database\Seeder;

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
        $this->call(UserStudentRelationshipTableSeeder::class);
        $this->call(WaitingSeeder::class);

        $this->command->info('finishing sending data');
    }
}

// create temporary database
class UsersTableSeeder extends Seeder {

	public function run() {

		// clear database
		DB::table('users')->delete();

		DB::table('users')->insert([
			'name' 		=> 'admin',
			'email' 	=> 'admin@CUD.com',
			'password' 	=> bcrypt('admin'),
		]);

	}
}

class StudentsTableSeeder extends Seeder {

	public function run() {

		// clear database
		DB::table('students')->delete();

		DB::table('students')->insert([
			'name' 		=> 'นาย A',
			'std_id' 	=> 47411449,
			'std_room' 	=> 67,
			'std_no'	=> 39,
			'device_mac_address' => 'TBA1',
		]);

		DB::table('students')->insert([
			'name' 		=> 'mr B',
			'std_id' 	=> 12345674,
			'std_room' 	=> 32,
			'std_no'	=> 4,
			'device_mac_address' => 'TBA2',
		]);
	}
}


class DeviceLocationTableSeeder extends Seeder {

	public function run() {

		// clear database
		DB::table('device_location')->delete();

		DB::table('device_location')->insert([
			'device_mac_address' => 'TBA1',
			'area' => 'Room404',
			'location_x' => 0,
			'location_y' => 0,
			'location_z' => 0,
		]);

		DB::table('device_location')->insert([
			'device_mac_address' => 'TBA2',
			'area' => 'Room304',
			'location_x' => 0,
			'location_y' => 0,
			'location_z' => 0,
		]);
	}
}

class UserStudentRelationshipTableSeeder extends Seeder {

	public function run() {

		// clear database
		DB::table('user_student_relationship')->delete();

		DB::table('user_student_relationship')->insert([
			'user_id' => App\User::where('name', 'admin')->first()->id,
			'student_id' => DB::table('students')->where('std_id', 47411449)->first()->id,
		]);

		DB::table('user_student_relationship')->insert([
			'user_id' => App\User::where('name', 'admin')->first()->id,
			'student_id' => DB::table('students')->where('std_id', 12345674)->first()->id,
		]);
	}	
}

class WaitingSeeder extends Seeder {

	public function run() {

		DB::table('waiting')->delete();

		DB::table('waiting')->insert(['id' => DB::table('students')->where('std_id', 47411449)->first()->id, 'area' => 'Door1']);
		DB::table('waiting')->insert(['id' => DB::table('students')->where('std_id', 12345674)->first()->id, 'area' => 'Door2']);
	}
}

<?php

use Illuminate\Database\Seeder;

use App\Adapter;
use App\Device;
use App\Student;
use App\Location;
use App\User;
use App\UserStudent;

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
        $this->call(LocationTableSeeder::class);
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

		User::insert([
			'name' 		=> 'Guest',
			'email' 	=> '',
			'password' 	=> bcrypt(''),
		]);


	}
}

class StudentsTableSeeder extends Seeder {

	public function run() {

		// clear database
		Student::truncate();

		// Student::insert([
		// 	'name' 		=> 'นาย A',
		// 	'std_id' 	=> '47411449',
		// 	'std_room' 	=> 67,
		// 	'std_no'	=> 39,
		// 	'device_mac_address' => 'TBA1',
		// ]);

		// Student::insert([
		// 	'name' 		=> 'mr B',
		// 	'std_id' 	=> '12345674',
		// 	'std_room' 	=> 32,
		// 	'std_no'	=> 4,
		// 	'device_mac_address' => 'TBA2',
		// ]);

		// Student::insert([
		// 	'name' 		=> 'Gof',
		// 	'std_id' 	=> '5931040421',
		// 	'std_room' 	=> -1,
		// 	'std_no'	=> -1,
		// 	'device_mac_address' => 'FF:FF:40:00:15:0D',
		// ]);

		for ($i = 1 ; $i <= 20 ; ++$i) {
			Student::insert([
				'name' => 'user' . $i,
				'std_id' => $i,
				'std_room' => 0,
				'std_no' => 0,
				'device_mac_address' => $i,
			]);
		}
	}
}


class AdapterTableSeeder extends Seeder {

	public function run() {

		// clear database
		Adapter::truncate();

		// Adapter::insert([
		// 	'adapter_name' => '66:39:21:1A:E7:B9',
		// 	'area' => 'Robotic club',
		// 	'location_x' => 0,
		// 	'location_y' => 0,
		// 	'location_z' => 0,
		// ]);


		// Adapter::insert([
		// 	'adapter_name' => '2343402',
		// 	'area' => 'tmp2',
		// 	'location_x' => 10,
		// 	'location_y' => 10,
		// 	'location_z' => 0,
		// ]);

		// Adapter::insert([
		// 	'adapter_name' => '234342402',
		// 	'area' => 'tmp2',
		// 	'location_x' => 0,
		// 	'location_y' => 10,
		// 	'location_z' => 0,
		// ]);

		// Adapter::insert([
		// 	'adapter_name' => '234343402',
		// 	'area' => 'tmp2',
		// 	'location_x' => 10,
		// 	'location_y' => 10,
		// 	'location_z' => 0,
		// ]);

		for ($j = 1 ; $j <= 6 ; ++$j) {
			Adapter::insert([
				'adapter_name' => $j,
				'area' => 'area'. $j,
				'location_x' => (($j-1) % 3) * 13,
				'location_y' => ($j <= 3 ? 0 : 12),
				'location_z' => 0,
			]);
		}
	}
}

class DeviceLocationTableSeeder extends Seeder {

	public function run() {

		// clear database
		Device::truncate();

		// Device::insert([
		// 	'device_mac_address' => 'TBA1',
		// 	'area' => 'Door1',
		// 	'location_x' => 0,
		// 	'location_y' => 0,
		// 	'location_z' => 0,
		// ]);

		// Device::insert([
		// 	'device_mac_address' => 'TBA2',
		// 	'area' => 'Room404',
		// 	'location_x' => 0,
		// 	'location_y' => 10,
		// 	'location_z' => 0,
		// ]);

		// Device::insert([
		// 	'device_mac_address' => 'FF:FF:40:00:15:0D',
		// 	'area' => 'Robotic Club',
		// 	'location_x' => 10,
		// 	'location_y' => 10,
		// 	'location_z' => 0,
		// ]);
		for ($i = 1 ; $i <= 20 ; ++$i) {
			Device::insert([
				'device_mac_address' => $i,
				'area' => 'area'. $i,
				'location_x' => 10,
				'location_y' => 10,
				'location_z' => 0,
			]);
		}

	}
}

class LocationTableSeeder extends Seeder {

	public function run() {

		// clear database
		Location::truncate();

		// Location::create([
		// 	'device_id' => 3,
		// 	'adapter_id' => 1,
		// 	'length' => 7,
		// 	'updated_at' => time(),
		// ]);

		// Location::create([
		// 	'device_id' => 3,
		// 	'adapter_id' => 2,
		// 	'length' => 7,
		// 	'updated_at' => time(),
		// ]);

		// Location::create([
		// 	'device_id' => 3,
		// 	'adapter_id' => 3,
		// 	'length' => 7,
		// 	'updated_at' => time(),
		// ]);

		// Location::create([
		// 	'device_id' => 3,
		// 	'adapter_id' => 4,
		// 	'length' => 8,
		// 	'updated_at' => time(),
		// ]);

		for ($i = 1 ; $i <= 20 ; ++$i) {

			$x = rand(1, 26);
			$y = rand(1, 12);

			for ($j = 1 ; $j <= 6 ; ++$j) {

				$adapter = Adapter::getAdapterByID($j);


				Location::insert([
					'device_id' => $i,
					'adapter_id' => $j,
					'length' => sqrt(pow($x - $adapter->location_x, 2) + pow($y - $adapter->location_y, 2)),
				]);

				// Location::where('device_id', $i)->first()->touch();
			}
		}
	}
}

class UserStudentRelationshipTableSeeder extends Seeder {

	public function run() {

		// clear database
		DB::table('user_student_relationships')->truncate();

		// DB::table('user_student_relationships')->insert([
		// 	'user_id' => User::where('name', 'admin')->first()->id,
		// 	'student_id' => Student::where('std_id', 47411449)->first()->id,
		// ]);

		// DB::table('user_student_relationships')->insert([
		// 	'user_id' => User::where('name', 'admin')->first()->id,
		// 	'student_id' => Student::where('std_id', 12345674)->first()->id,
		// ]);

		// DB::table('user_student_relationships')->insert([
		// 	'user_id' => User::where('name', 'admin')->first()->id,
		// 	'student_id' => Student::where('std_id', 5931040421)->first()->id,
		// ]);

		for ($i = 1 ; $i <= 20 ; ++$i) {
			UserStudent::insert([
				'user_id' => User::where('name', 'admin')->first()->id,
				'student_id' => $i,
			]);
		}
	}	
}

class WaitingSeeder extends Seeder {

	public function run() {

		DB::table('waitinglists')->truncate();

		// DB::table('waitinglists')->insert([
		// 	'id' => 0,
		// 	'area' => 'Door1',
		// ]);
		// DB::table('waitinglists')->insert([
		// 	'id' => 0,
		// 	'area' => 'Door2',
		// ]);

		// DB::table('waitinglists')->insert([
		// 	'id' => Student::getStudentByStudentID(47411449)->id, 
		// 	'area' => 'Door1'
		// ]);

		// DB::table('waitinglists')->insert([
		// 	'id' => Student::getStudentByStudentID(12345674)->id, 
		// 	'area' => 'Door1'
		// ]);

		// DB::table('waitinglists')->insert([
		// 	'id' => Student::getStudentByStudentID(12345674)->id, 
		// 	'area' => 'Door2'
		// ]);
	}
}

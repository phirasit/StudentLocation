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
			'status'  	=> 0,
			'password' 	=> bcrypt('admin'),
		]);

		User::insert([
			'name' 		=> 'Jerasak',
			'email' 	=> 'j_jerasak@hotmail.com',
			'password' 	=> bcrypt('123456'),
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

		$data = [
			'13:67:14:FC:58:FC',
			'36:59:DC:FA:58:FC',
			'C9:35:0D:FA:58:FC',
			'FF:FF:B0:00:0C:32',
			'FF:FF:00:00:04:78',
			'FF:FF:00:00:1D:78',
			'FF:FF:10:00:0D:0D',
			'FF:FF:40:00:15:0D',
			'FF:FF:70:00:07:11',
			'FF:FF:90:00:0C:84',
			'FF:FF:E0:01:45:FF',
			'FF:FF:E0:01:53:40',
			'FF:FF:E0:01:5C:D3',
			'FF:FF:E0:01:37:36',
			'FF:FF:F0:00:37:25',
		];

		foreach ($data as $key => $device_mac_address) {
			Student::insert([
				'name' => 'user' . ($key + 1),
				'std_id' => $key,
				'std_room' => 0,
				'std_no' => 0,
				'device_mac_address' => $device_mac_address,
			]);
		}
	}
}


class AdapterTableSeeder extends Seeder {

	public function run() {

		// clear database
		Adapter::truncate();

		Adapter::insert([
			'adapter_name' => '66:39:21:1A:E7:B9',
			'area' => 'Door3',
			'location_x' => 13.00,
			'location_y' => 4.64,
			'location_z' => 2.00,
			'inside_length' => 2.0,
		]);

		Adapter::insert([
			'adapter_name' => '40:6A:2A:23:21:C4',
			'area' => 'Door5',
			'location_x' => 8.2,
			'location_y' => 10.92,
			'location_z' => 2.07,
			'inside_length' => 5,
		]);

		Adapter::insert([
			'adapter_name' => '6A:E0:EA:A8:86:2B',
			'area' => 'Door5',
			'location_x' => 1.0,
			'location_y' => 10.62,
			'location_z' => 2.34,
			'inside_length' => 5.00,
		]);

		Adapter::insert([ // done
			'adapter_name' => '8E:DE:A6:EB:56:BB',
			'area' => 'Door5',
			'location_x' => 25.00,
			'location_y' => 10.62,
			'location_z' => 2.34,
			'inside_length' => 5.0,
		]);


		Adapter::insert([
			'adapter_name' => '6C:5B:92:CB:C5:C1',
			'area' => 'Door3',
			'location_x' => 2.0,
			'location_y' => 1.0,
			'location_z' => 2.34,
			'inside_length' => 5.0,
		]);

		Adapter::insert([
			'adapter_name' => 'B8:27:EB:22:EF:69',
			'area' => 'Door5',
			'location_x' => 8.2,
			'location_y' => 10.62,
			'location_z' => 1.00,
			'inside_length' => 2.0,
		]);

		Adapter::insert([
			'adapter_name' => 'B8:27:EB:19:BC:DC',
			'location_x' => 8.2,
			'location_y' => 10.62,
			'location_z' => 1.00,
			'inside_length' => 2.0,
		]);
	}
}

class DeviceLocationTableSeeder extends Seeder {

	public function run() {

		// clear database
		Device::truncate();

		$data = [
			'13:67:14:FC:58:FC',
			'36:59:DC:FA:58:FC',
			'C9:35:0D:FA:58:FC',
			'FF:FF:B0:00:0C:32',
			'FF:FF:00:00:04:78',
			'FF:FF:00:00:1D:78',
			'FF:FF:10:00:0D:0D',
			'FF:FF:40:00:15:0D',
			'FF:FF:70:00:07:11',
			'FF:FF:90:00:0C:84',
			'FF:FF:E0:01:45:FF',
			'FF:FF:E0:01:53:40',
			'FF:FF:E0:01:5C:D3',
			'FF:FF:E0:01:37:36',
			'FF:FF:F0:00:37:25',
		];

		foreach ($data as $key => $device_mac_address) {
			Device::insert([
				'device_mac_address' => $device_mac_address,
				// 'area' => ($key <= 6 ? 'Door3' : 'Door5'),
			]);
		}

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
		// for ($i = 1 ; $i <= 20 ; ++$i) {
		// 	Device::insert([
		// 		'device_mac_address' => $i,
		// 		'area' => 'area'. $i,
		// 		'location_x' => 10,
		// 		'location_y' => 10,
		// 		'location_z' => 0,
		// 	]);
		// }

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

		// for ($i = 1 ; $i <= 20 ; ++$i) {

		// 	$x = rand(1, 26);
		// 	$y = rand(1, 12);

		// 	for ($j = 1 ; $j <= 6 ; ++$j) {

		// 		$adapter = Adapter::getAdapterByID($j);


		// 		Location::insert([
		// 			'device_id' => $i,
		// 			'adapter_id' => $j,
		// 			'length' => sqrt(pow($x - $adapter->location_x, 2) + pow($y - $adapter->location_y, 2)),
		// 		]);

		// 		// Location::where('device_id', $i)->first()->touch();
		// 	}
		// }
	}
}

class UserStudentRelationshipTableSeeder extends Seeder {

	public function run() {

		// clear database
		DB::table('user_student_relationships')->truncate();

		// for ($i = 1 ; $i <= 14 ; ++$i) {
			// DB::table('user_student_relationships')->insert([
			// 	'user_id' => 1,
			// 	'student_id' => 11,
			// ]);
		// }
	}	
}

class WaitingSeeder extends Seeder {

	public function run() {

		DB::table('waitinglists')->truncate();

		DB::table('waitinglists')->insert([
			'id' => 0,
			'area' => 'Door3',
		]);
		DB::table('waitinglists')->insert([
			'id' => 0,
			'area' => 'Door5',
		]);

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

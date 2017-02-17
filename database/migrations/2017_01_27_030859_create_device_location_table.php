<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_location', function (Blueprint $table) {
            $table->string('device_mac_address', 100)->primary();
            $table->string('area');
            $table->double('location_x');
            $table->double('location_y');
            $table->double('location_z');
            
            $table->timestamps('last_checkin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_location');
    }
}

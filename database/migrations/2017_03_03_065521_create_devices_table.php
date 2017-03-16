<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('device_mac_address', 100)->unique()->index();
            $table->string('area')->default('');
            $table->double('location_x')->default(0.0);
            $table->double('location_y')->default(0.0);
            $table->double('location_z')->default(0.0);
            
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
        Schema::dropIfExists('devices');
    }
}

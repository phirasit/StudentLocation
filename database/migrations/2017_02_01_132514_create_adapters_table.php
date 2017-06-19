<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adapters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('adapter_name', 100)->index();
            $table->string('area')->default('not assigned');
            $table->integer('ip_address')->default(0);
            $table->double('location_x')->default(0.0);
            $table->double('location_y')->default(0.0);
            $table->double('location_z')->default(0.0);
            $table->double('inside_length')->default(0.0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adapters');
    }
}

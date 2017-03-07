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
            $table->string('area');
            $table->double('location_x');
            $table->double('location_y');
            $table->double('location_z');
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

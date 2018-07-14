<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('car_id');
            $table->integer('status');
            $table->dateTime('begin_time');
            $table->integer('begin_user_id');
            $table->dateTime('end_time');
            $table->integer('end_user_id');
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
        Schema::dropIfExists('car_tasks');
    }
}

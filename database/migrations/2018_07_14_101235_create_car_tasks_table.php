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
            $table->string('car_reg_num');
            $table->string('task_type');
            $table->string('status');
            $table->dateTime('begin_time')->nullable();
            $table->string('begin_user_name')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->string('end_user_name')->nullable();
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

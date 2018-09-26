<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehouseOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_operations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('resource_name');
            $table->string('operation_type');
            $table->integer('old_val');
            $table->integer('quantity_change');
            $table->integer('new_val');
            $table->string('supplier_name')->nullable();
            $table->string('user_name');
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
        Schema::dropIfExists('warehouse_operations');
    }
}

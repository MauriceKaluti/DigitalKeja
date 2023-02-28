<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('building_id')->nullable();
            $table->string('room_number')->nullable();
            $table->double('rent')->nullable();
            $table->double('deposit')->nullable();
            $table->string('bedrooms')->nullable();
            $table->boolean('is_vacant')->default(true)->nullable();
            $table->unsignedInteger('deposit_period')->default(1)->nullable();
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
        Schema::dropIfExists('rooms');
    }
}

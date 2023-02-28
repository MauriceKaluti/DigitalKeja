<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_rents', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->string('lease_id');
            $table->string('tenant_id');
            $table->string('building_id');
            $table->string('room_id');
            $table->string('landlord_id');
            $table->string('amount');
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
        Schema::dropIfExists('monthly_rents');
    }
}

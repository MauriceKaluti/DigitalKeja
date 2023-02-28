<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_incomes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('building_id');
            $table->string('landlord_id');
            $table->string('overseer');
            $table->string('income_particular');
            $table->string('income_amount');
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
        Schema::dropIfExists('external_incomes');
    }
}

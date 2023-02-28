<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('building_id');
            $table->string('landlord_id');
            $table->string('overseer');
            $table->string('expense_particular');
            $table->string('expense_amount');
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
        Schema::dropIfExists('building_expenses');
    }
}

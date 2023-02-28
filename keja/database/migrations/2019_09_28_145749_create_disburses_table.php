<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisbursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disburses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('landlord_id')
                ->foreign('landlord_id')
                ->references('id')->on('landlords')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('user_id')
                ->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->string('amount');
            $table->string('payment_method');
            $table->string('reference_number');
            $table->timestamp('disburse_at')->nullable();
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
        Schema::dropIfExists('disburses');
    }
}

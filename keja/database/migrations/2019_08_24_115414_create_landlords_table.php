<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandlordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landlords', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone_number')->nullable()->unique();
            $table->string('id_no');
            $table->string('email')->nullable()->unique();
            $table->string('account_number')->nullable()->unique();
            $table->string('account_name')->nullable()->unique();
            $table->string('bank')->nullable();
            $table->string('address')->nullable()->unique();
            $table->boolean('is_active')->default(1);
            $table->unsignedInteger('user_id')->references('id')
                ->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('landlords');
    }
}

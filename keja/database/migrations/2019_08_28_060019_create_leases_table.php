<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')
                            ->references('id')->on('users')
                            ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('tenant_id')
                            ->references('id')->on('tenants')
                            ->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('room_id')
                            ->references('id')->on('rooms')
                            ->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('leases');
    }
}

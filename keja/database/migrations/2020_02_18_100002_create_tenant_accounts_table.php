<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('room_id')->foreign('room_id')
                ->references('id')->on('rooms')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('month');
            $table->string('amount')->nullable();
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
        Schema::dropIfExists('tenant_accounts');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('lease_id')->references('id')->on('leases')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('tenant_id')->references('id')->on('tenants')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('status');
            $table->double('deposit', 12,2);
            $table->double('rent', 12, 2);
            $table->unsignedInteger('user_id')->nullable()->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('invoices');
    }
}

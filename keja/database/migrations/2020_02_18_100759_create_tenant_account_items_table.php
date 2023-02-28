<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantAccountItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_account_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_account_id')->foreign('tenant_account_id')
                ->references('id')->on('tenant_accounts')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('tenant_id')->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('item');
            $table->string('amount');
            $table->boolean('is_paid')->default(false);
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
        Schema::dropIfExists('tenant_account_items');
    }
}

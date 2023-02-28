<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTenantIdOnPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('item')
                ->nullable()
                ->after('id');
            $table->unsignedBigInteger('tenant_id')
                ->nullable()
                ->after('item')
                ->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('tenant_account_id')
                ->nullable()
                ->after('item')
                ->foreign('tenant_account_id')
                ->references('id')->on('tenant_accounts')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('tenant_account_id');
          $table->dropForeign('tenant_id');
           $table->dropColumn('item');
           $table->dropColumn('tenant_account_id');
           $table->dropColumn('tenant_id');

        });
    }
}

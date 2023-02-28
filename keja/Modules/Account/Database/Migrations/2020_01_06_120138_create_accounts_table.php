<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chart_id')->foreign('chart_id')
                ->references('id')->on('chart_of_accounts')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('parent_id')->nullable()->foreign('parent_id')
                ->references('id')->on('accounts')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->boolean('allow_manual_entry')->default(false);
            $table->boolean('has_children')->default(false);
            $table->text('name');
            $table->string('glcode')->unique();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}

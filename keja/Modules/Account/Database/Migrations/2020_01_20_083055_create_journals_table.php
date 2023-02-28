<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account_id')->index();
            $table->string('debit')->default(0);
            $table->string('credit')->default(0);
            $table->unsignedBigInteger('payment_id')->nullable()->foreign('payment_id')
                ->references('id')->on('payments')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->text('narration');
            $table->timestamps();

            $table->foreign('account_id')
                ->references('id')->on('accounts')
                ->onUpdate('cascade')->onDelete('cascade');




        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journals');
    }
}

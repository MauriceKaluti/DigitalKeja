<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMpesaTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesa_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_type');
            $table->string('trans_id');
            $table->string('trans_time');
            $table->string('trans_amount');
            $table->string('business_short_code');
            $table->string('bill_ref_number');
            $table->string('org_account_balance');
            $table->string('invoice_number')->nullable();
            $table->string('third_party_trans_id')->nullable();
            $table->string('MSISDN')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
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
        Schema::dropIfExists('mpesa_transactions');
    }
}

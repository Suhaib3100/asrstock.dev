<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_money', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('payment_id')->nullable();
            $table->string('gateway_name');
            $table->string('gateway_currency');
            $table->string('conversion_rate');
            $table->string('amount');
            $table->string('grand_total')->comment('multiply with amount & conversion rate');
            $table->tinyInteger('status')->comment('1=paid,2=pending,3=cancelled')->default(2);
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('deposit_by')->nullable();
            $table->string('bank_deposit_slip')->nullable();
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
        Schema::dropIfExists('wallet_money');
    }
};

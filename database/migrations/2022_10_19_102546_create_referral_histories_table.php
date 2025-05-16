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
        Schema::create('referral_histories', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_no');
            $table->unsignedBigInteger('referred_customer_id');
            $table->unsignedBigInteger('buyer_customer_id');
            $table->unsignedBigInteger('order_id');
            $table->string('plan_name');
            $table->float('plan_price')->default(0);
            $table->float('actual_amount')->default(0);
            $table->float('commission_percentage');
            $table->float('earned_amount')->default(0);
            $table->tinyInteger('status')->default(2)->comment('1=paid,2=due');
            $table->unsignedBigInteger('referral_id');
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
        Schema::dropIfExists('referral_histories');
    }
};

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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->tinyInteger('use_type')->comment('1=Single,2=Multiple');
            $table->integer('maximum_use_limit')->comment('If use_type 1(Single), admin should set how many times can be use this coupon')->nullable();
            $table->tinyInteger('discount_type')->comment('1=Percentage,2=Amount');
            $table->float('discount_value')->default(0);
            $table->integer('minimum_amount')->comment('If discount type 2(amount), admin should give minimum amount to use this coupon')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('status')->comment('1=Active, 0=Disable')->default(1);
            $table->unsignedBigInteger('user_id')->comment('created_by')->nullable();
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
        Schema::dropIfExists('coupons');
    }
};

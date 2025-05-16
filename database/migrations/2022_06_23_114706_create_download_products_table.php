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
        Schema::create('download_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_type_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('contributor_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->tinyInteger('download_accessibility_type')->comment('1=Paid,2=Free');
            $table->unsignedBigInteger('monthly_earning_history_id')->nullable();
            $table->float('earn_money')->default(0);
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
        Schema::dropIfExists('download_products');
    }
};

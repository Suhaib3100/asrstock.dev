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
        Schema::create('reported_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reported_by_customer_id');
            $table->unsignedBigInteger('reported_to_customer_id')->nullable();
            $table->unsignedBigInteger('reported_to_user_id')->nullable();
            $table->text('reason');
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
        Schema::dropIfExists('reported_members');
    }
};

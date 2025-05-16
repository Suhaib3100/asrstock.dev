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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('slug');
            $table->float('monthly_price')->default(0);
            $table->float('yearly_price')->default(0);
            $table->integer('device_limit')->nullable();
            $table->tinyInteger('download_limit_type')->comment('1=unlimited,2=limited');
            $table->integer('download_limit')->nullable();
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0=Disable, 1=Active')->nullable();
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
        Schema::dropIfExists('plans');
    }
};

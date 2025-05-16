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
        Schema::create('file_managers', function (Blueprint $table) {
            $table->id();
            $table->string('file_type', 50);
            $table->string('storage_type');
            $table->string('original_name');
            $table->string('file_name')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('path');
            $table->string('extension');
            $table->string('size');
            $table->string('external_link')->nullable();
            $table->nullableMorphs('origin');
            $table->softDeletes();
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
        Schema::dropIfExists('file_managers');
    }
};

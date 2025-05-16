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
        Schema::create('product_type_extensions', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('product_type_category');
            $table->string('name');
            $table->string('title');
            $table->tinyInteger('thumbnail_required')->default(ACTIVE);
            $table->tinyInteger('maskingable')->default(DISABLE);
            $table->tinyInteger('status')->default(ACTIVE);
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
        Schema::dropIfExists('product_type_extensions');
    }
};

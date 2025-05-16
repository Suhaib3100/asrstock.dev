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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title');
            $table->string('slug');
            $table->longText('description');
            $table->float('price')->nullable();
            $table->tinyInteger('status')->default(2)->comment('1=Published, 2=Pending, 3=Hold')->nullable();
            $table->tinyInteger('uploaded_by')->comment('1=admin, 2=contributor')->nullable();
            $table->tinyInteger('accessibility')->comment('1=paid, 2=free')->nullable();
            $table->tinyInteger('is_featured')->default(0)->comment('1=yes, 0=no')->nullable();
            $table->tinyInteger('use_this_photo')->nullable();
            $table->unsignedBigInteger('thumbnail_image_id')->nullable();
            $table->string('file_types')->nullable();
            $table->unsignedBigInteger('product_type_id')->nullable();
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->unsignedBigInteger('total_watch')->default(0)->nullable();
            $table->tinyInteger('attribution_required')->default(0)->comment('1=yes, 0=no')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};

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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('user_name')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->text('address')->nullable();
            $table->string('slug');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('contact_number')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('portfolio_link')->nullable();
            $table->tinyInteger('role')->comment('1=Customer,2=Contributor')->default(1)->nullable();
            $table->tinyInteger('status')->comment('0=Disable,1=Active')->default(1)->nullable();
            $table->tinyInteger('contributor_apply')->comment('1=Yes, 0=No')->default(0)->nullable();
            $table->tinyInteger('contributor_status')->comment('0=pending, 1=approved,2=hold,3=cancelled')->default(0)->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('avatar')->nullable();
            $table->string('forgot_code')->nullable();
            $table->float('earning_balance')->default(0);
            $table->float('wallet_balance')->default(0);
            $table->integer('cover_image_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('customers');
    }
};

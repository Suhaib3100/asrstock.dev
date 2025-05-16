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
        Schema::create('gateways', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('gateway_name')->unique()->nullable();
            $table->string('gateway_slug')->unique()->nullable();
            $table->string('gateway_currency')->nullable();
            $table->tinyInteger('gateway_type')->comment('1=Manual,2=Automatic')->nullable();
            $table->text('user_proof_param')->nullable();
            $table->float('conversion_rate')->default(0);
            $table->string('url')->nullable();
            $table->string('key')->nullable()->comment('client id, public key, key, store id, api key');
            $table->string('secret')->nullable()->comment('client secret, secret, store password, auth token');
            $table->tinyInteger('status')->default(0)->comment('1=Active,0=Disable')->nullable();
            $table->tinyInteger('mode')->default(GATEWAY_MODE_SANDBOX)->comment('1=live,2=sandbox');
            $table->tinyInteger('wallet_gateway_status')->default(0)->comment('1=Active,0=Disable')->nullable();
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
        Schema::dropIfExists('gateways');
    }
};

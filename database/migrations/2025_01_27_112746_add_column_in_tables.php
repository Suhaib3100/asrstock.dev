<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('bank_id')->after('bank_name')->nullable();
        });

        Schema::table('wallet_money', function (Blueprint $table) {
            $table->unsignedBigInteger('bank_id')->after('bank_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('bank_id');
        });

        Schema::table('wallet_money', function (Blueprint $table) {
            $table->dropColumn('bank_id');
        });
    }
};

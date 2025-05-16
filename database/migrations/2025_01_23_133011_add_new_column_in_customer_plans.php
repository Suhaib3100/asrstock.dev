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
        Schema::table('customer_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id')->nullable()->after('end_date');
            $table->tinyInteger('plan_type')->default(ORDER_PLAN_DURATION_TYPE_YEAR)->after('plan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_plans', function (Blueprint $table) {
            $table->dropColumn('plan_id');
            $table->dropColumn('plan_type');
        });
    }
};

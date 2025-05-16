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
        Schema::create('monthly_earning_histories', function (Blueprint $table) {
            $table->id();
            $table->string('month_year')->unique();
            $table->string('total_download');
            $table->string('total_income_from_plan');
            $table->string('get_commission_per_download');
            $table->string('admin_commission_percentage');
            $table->string('admin_commission');
            $table->string('contributor_commission_percentage');
            $table->string('contributor_commission');
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
        Schema::dropIfExists('monthly_earning_histories');
    }
};

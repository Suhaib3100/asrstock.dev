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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->string('gateway_transaction')->nullable();
            $table->string('payment_id')->nullable();
            $table->unsignedBigInteger('customer_id');

            $table->unsignedBigInteger('plan_id')->nullable();
            $table->float('plan_price')->default(0)->nullable();
            $table->tinyInteger('plan_duration_type')->comment('1=yearly,2=monthly')->nullable();

            $table->unsignedBigInteger('product_id')->nullable();
            $table->float('product_price')->default(0)->nullable();
            $table->float('donate_price')->default(0)->nullable();

            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->float('coupon_discount_type')->nullable();
            $table->float('coupon_discount_value')->default(0)->nullable();

            $table->unsignedBigInteger('tax_id')->nullable();
            $table->float('tax_percentage')->nullable();

            $table->string('current_currency')->nullable();
            $table->unsignedBigInteger('gateway_id');
            $table->string('gateway_currency')->nullable();
            $table->float('conversion_rate')->default(0)->nullable();

            $table->float('admin_commission')->default(0);
            $table->float('contributor_commission')->default(0);

            $table->float('subtotal')->default(0);
            $table->float('discount')->default(0)->nullable();
            $table->float('tax_amount')->default(0)->nullable();
            $table->float('total')->default(0)->nullable();
            $table->float('grand_total')->default(0)->comment('Multiply with total and conversion_rate')->nullable();

            $table->tinyInteger('payment_status')->default(1)->comment('1=pending, 2=paid, 3=cancelled')->nullable();
            $table->tinyInteger('payment_type')->default(2)->comment('1=bank, 2=online')->nullable();
            $table->string('bank_name')->comment('If payment type bank, need to add bank name')->nullable();
            $table->string('bank_account_number')->comment('If payment type bank, need to add bank account number')->nullable();
            $table->string('deposit_by')->comment('If payment type bank, need to add deposit')->nullable();
            $table->string('bank_deposit_slip')->comment('If payment type bank, need to add bank deposit slip')->nullable();
            $table->tinyInteger('type')->comment('1=Plan,2=Product,3=Donate')->nullable();
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
        Schema::dropIfExists('orders');
    }
};

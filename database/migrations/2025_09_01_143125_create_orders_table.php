<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('order_number');
            $table->integer('buyer_id')->nullable();
            $table->integer('seller_id')->nullable();
            $table->integer('listing_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('plan_id')->nullable();
            $table->tinyInteger('is_topup')->default(0);
            $table->integer('quantity');
            $table->float('org_unit_price', 10)->comment('original unit price before discount');
            $table->float('unit_price', 10);
            $table->decimal('total_price', 10)->comment('after discount');
            $table->string('status', 25)->nullable()->default('pending');
            $table->string('payment_status')->nullable()->default('pending');
            $table->dateTime('order_date')->nullable()->useCurrent();
            $table->string('delivery_method', 100)->nullable();
            $table->string('delivery_speed', 100)->nullable();
            $table->string('delivery_speed_unit')->nullable();
            $table->integer('gateway_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->integer('coupon_id')->nullable();
            $table->decimal('discount_amount', 5)->nullable()->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

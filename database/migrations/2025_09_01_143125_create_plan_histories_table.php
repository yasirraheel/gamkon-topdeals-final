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
        Schema::create('plan_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('referral_level')->default(0);
            $table->float('withdraw_limit', 10)->default(0);
            $table->integer('listing_limit')->default(0);
            $table->integer('flash_sale_limit');
            $table->decimal('amount');
            $table->timestamp('validity_at');
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->enum('charge_type', ['percentage', 'amount'])->default('amount');
            $table->float('charge_value', 10)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_histories');
    }
};

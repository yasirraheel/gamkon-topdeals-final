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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->decimal('price');
            $table->integer('flash_sale_limit');
            $table->integer('validity');
            $table->integer('listing_limit')->default(0);
            $table->integer('referral_level')->default(0);
            $table->string('badge');
            $table->boolean('is_featured');
            $table->json('features');
            $table->float('withdraw_limit', 10)->default(0);
            $table->timestamps();
            $table->string('image');
            $table->enum('charge_type', ['percentage', 'amount']);
            $table->decimal('charge_value', 10)->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};

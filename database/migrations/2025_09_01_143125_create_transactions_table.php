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
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('from_user_id')->nullable();
            $table->integer('order_id')->nullable();
            $table->bigInteger('plan_id')->nullable();
            $table->string('from_model')->default('User');
            $table->integer('target_id')->nullable();
            $table->string('target_type')->nullable();
            $table->boolean('is_level')->nullable()->default(false);
            $table->string('tnx')->unique();
            $table->string('description')->nullable();
            $table->string('amount');
            $table->string('type');
            $table->string('charge')->default('0');
            $table->string('final_amount')->default('0');
            $table->string('method')->nullable();
            $table->string('pay_currency', 256)->nullable();
            $table->double('pay_amount', null, 0)->nullable();
            $table->text('manual_field_data')->nullable();
            $table->text('approval_cause')->nullable();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

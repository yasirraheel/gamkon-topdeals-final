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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('avatar', 256)->nullable();
            $table->enum('user_type', ['seller', 'buyer'])->default('buyer');
            $table->bigInteger('plan_id')->nullable();
            $table->timestamp('validity_at')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('country');
            $table->string('phone');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->enum('gender', ['male', 'female', 'other', ''])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->text('address')->nullable();
            $table->float('balance', 10)->default(0);
            $table->boolean('status')->default(true);
            $table->text('close_reason')->nullable();
            $table->integer('ref_id')->nullable();
            $table->boolean('kyc')->default(false);
            $table->text('google2fa_secret')->nullable();
            $table->boolean('two_fa')->default(false);
            $table->boolean('deposit_status')->default(true);
            $table->boolean('withdraw_status')->default(true);
            $table->boolean('transfer_status')->default(true);
            $table->boolean('otp_status')->default(true);
            $table->boolean('referral_status')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('phone_verified')->default(false);
            $table->string('otp')->nullable();
            $table->timestamps();
            $table->integer('total_sold')->nullable()->default(0);
            $table->integer('total_purchased')->nullable()->default(0);
            $table->decimal('total_amount_sold', 10)->nullable()->default(0);
            $table->decimal('total_amount_purchased', 10)->nullable()->default(0);
            $table->integer('total_reviews')->nullable()->default(0);
            $table->decimal('avg_rating', 3, 1)->nullable()->default(0);
            $table->boolean('show_following_follower_list')->nullable()->default(true);
            $table->boolean('accept_profile_chat')->nullable()->default(true);
            $table->float('topup_balance', 10)->default(0);
            $table->integer('current_plan_id')->nullable();
            $table->integer('portfolio_id')->nullable();
            $table->json('portfolios')->nullable();
            $table->text('about')->nullable();
            $table->tinyInteger('is_popular')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

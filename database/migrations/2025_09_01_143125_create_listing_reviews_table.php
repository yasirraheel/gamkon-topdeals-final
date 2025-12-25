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
        Schema::create('listing_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('listing_id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->unsignedTinyInteger('rating')->comment('1-5 star rating');
            $table->text('review')->nullable();
            $table->string('status', 20)->default('pending');
            $table->string('flag_reason')->nullable();
            $table->timestamp('reviewed_at')->nullable()->useCurrent();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            $table->integer('buyer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_reviews');
    }
};

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
        Schema::create('visitor_tracking', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip', 45); // IPv6 support
            $table->string('country')->nullable();
            $table->string('country_code', 5)->nullable();
            $table->string('browser', 50)->nullable();
            $table->string('platform', 50)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('url'); // Full URL visited
            $table->unsignedBigInteger('user_id')->nullable(); // For authenticated users
            $table->timestamps();

            // Indexes for performance
            $table->index('ip');
            $table->index('country_code');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_tracking');
    }
};

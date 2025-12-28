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
        Schema::create('ip_geolocation_cache', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip', 45)->unique(); // Primary lookup key
            $table->string('country')->nullable();
            $table->string('country_code', 5)->nullable();
            $table->string('region')->nullable(); // For future expansion
            $table->string('city')->nullable(); // For future expansion
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamp('expires_at')->nullable(); // Cache expiration
            $table->timestamps();

            // Index for fast lookups
            $table->index('ip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ip_geolocation_cache');
    }
};

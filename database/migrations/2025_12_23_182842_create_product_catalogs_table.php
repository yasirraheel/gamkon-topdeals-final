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
        Schema::create('product_catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('durations')->nullable(); // Store multiple durations as JSON
            $table->json('sharing_methods')->nullable(); // Store multiple sharing methods as JSON
            $table->json('plans')->nullable(); // Store multiple plan IDs as JSON
            $table->text('description')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_catalogs');
    }
};

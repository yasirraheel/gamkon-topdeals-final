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
        Schema::table('listings', function (Blueprint $table) {
            $table->unsignedBigInteger('product_catalog_id')->nullable()->after('category_id');
            $table->string('selected_duration')->nullable()->after('product_catalog_id');
            $table->string('selected_plan')->nullable()->after('selected_duration');
            
            $table->foreign('product_catalog_id')->references('id')->on('product_catalogs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropForeign(['product_catalog_id']);
            $table->dropColumn(['product_catalog_id', 'selected_duration', 'selected_plan']);
        });
    }
};

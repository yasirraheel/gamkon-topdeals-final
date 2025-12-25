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
            $table->enum('region_type', ['global', 'include', 'exclude'])->default('global')->after('product_catalog_id');
            // Ensure region column can store longer text for country lists
            $table->text('region')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn('region_type');
            $table->string('region')->nullable()->change();
        });
    }
};

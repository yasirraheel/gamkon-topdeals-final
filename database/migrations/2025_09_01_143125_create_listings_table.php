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
        Schema::create('listings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('category_id');
            $table->integer('subcategory_id')->nullable();
            $table->string('product_name');
            $table->text('description');
            $table->decimal('price', 10);
            $table->integer('views')->nullable()->default(0);
            $table->enum('discount_type', ['percentage', 'amount', 'none'])->nullable()->default('none');
            $table->decimal('discount_value', 10)->nullable()->default(0);
            $table->integer('quantity');
            $table->string('thumbnail')->nullable();
            $table->string('delivery_method')->nullable();
            $table->string('delivery_speed')->nullable();
            $table->string('status', 15)->default('draft');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('delivery_speed_unit')->nullable()->comment('day, min, hrs, sec etc');
            $table->tinyInteger('is_flash')->nullable()->default(0);
            $table->integer('sold_count')->default(0);
            $table->string('slug')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->tinyInteger('is_approved')->default(1);
            $table->tinyInteger('is_trending')->default(0);
            $table->float('avg_rating', 3)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};

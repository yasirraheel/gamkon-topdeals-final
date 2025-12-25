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
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('seller_id');
            $table->string('code')->unique('code');
            $table->enum('discount_type', ['percentage', 'amount']);
            $table->decimal('discount_value');
            $table->integer('max_use_limit');
            $table->integer('total_used')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('admin_approval');
            $table->date('expires_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};

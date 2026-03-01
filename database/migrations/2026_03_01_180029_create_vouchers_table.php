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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('description')->nullable();
            $table->unsignedInteger('discount_percent');        // ex: 20 = 20% de desconto
            $table->enum('applies_to', ['monthly', 'annual', 'both'])->default('both');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete(); // null = vale para todas
            $table->unsignedInteger('max_uses')->default(0);   // 0 = ilimitado
            $table->unsignedInteger('used_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};

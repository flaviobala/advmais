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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('payable'); // payable_type + payable_id (Course ou Lesson)
            $table->string('asaas_payment_id')->unique();
            $table->enum('status', ['pending', 'confirmed', 'overdue', 'cancelled'])->default('pending');
            $table->decimal('amount', 8, 2);
            $table->enum('billing_type', ['PIX', 'CREDIT_CARD', 'BOLETO']);
            $table->string('payment_url')->nullable();
            $table->text('pix_qr_code')->nullable();
            $table->string('pix_copy_paste')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->date('due_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

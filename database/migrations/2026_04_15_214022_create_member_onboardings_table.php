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
        Schema::create('member_onboardings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('token', 64)->unique();
            $table->enum('status', ['pending', 'received', 'approved'])->default('pending');
            $table->timestamp('welcome_sent_at')->nullable();
            $table->string('photo')->nullable();
            $table->text('mini_bio')->nullable();
            $table->string('oab_number')->nullable();
            $table->string('signed_term')->nullable();
            $table->timestamp('term_accepted_at')->nullable();
            $table->timestamp('docs_submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_onboardings');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Adiciona 'pending' ao enum de status (PostgreSQL usa CHECK constraint)
        DB::statement("ALTER TABLE subscriptions DROP CONSTRAINT IF EXISTS subscriptions_status_check");
        DB::statement("ALTER TABLE subscriptions ADD CONSTRAINT subscriptions_status_check CHECK (status IN ('active', 'inactive', 'overdue', 'cancelled', 'pending'))");

        // Torna category_id nullable (assinatura plataforma = null)
        DB::statement('ALTER TABLE subscriptions ALTER COLUMN category_id DROP NOT NULL');

        // Adiciona colunas extras
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('cycle', 10)->default('YEARLY')->after('billing_type');
            $table->timestamp('expires_at')->nullable()->after('cancelled_at');
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn(['cycle', 'expires_at']);
        });

        DB::statement('ALTER TABLE subscriptions ALTER COLUMN category_id SET NOT NULL');

        DB::statement("ALTER TABLE subscriptions DROP CONSTRAINT IF EXISTS subscriptions_status_check");
        DB::statement("ALTER TABLE subscriptions ADD CONSTRAINT subscriptions_status_check CHECK (status IN ('active', 'inactive', 'overdue', 'cancelled'))");
    }
};

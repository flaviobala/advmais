<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Remover constraint antes de alterar dados
        DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");

        // Mapear roles antigos para novos
        DB::statement("UPDATE users SET role = 'membro' WHERE role = 'advogado'");
        DB::statement("UPDATE users SET role = 'aluno' WHERE role = 'cliente'");
        DB::statement("UPDATE users SET role = 'professor' WHERE role = 'funcionario'");

        // Recriar constraint com novos valores
        DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'membro', 'aluno', 'professor'))");
        DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'aluno'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");

        DB::statement("UPDATE users SET role = 'advogado' WHERE role = 'membro'");
        DB::statement("UPDATE users SET role = 'cliente' WHERE role = 'aluno'");
        DB::statement("UPDATE users SET role = 'funcionario' WHERE role = 'professor'");

        DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'advogado', 'cliente', 'funcionario'))");
        DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'cliente'");
    }
};

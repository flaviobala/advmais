<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->string('cover_image')->nullable()->after('description');
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('cover_image');
        });
    }

    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn('cover_image');
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->string('cover_image')->nullable()->after('description');
        });
    }
};

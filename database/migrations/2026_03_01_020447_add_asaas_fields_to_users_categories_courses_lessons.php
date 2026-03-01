<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('asaas_customer_id')->nullable()->after('is_active');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->nullable()->after('is_active');
            $table->string('asaas_plan_id')->nullable()->after('price');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->nullable()->after('is_active');
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('asaas_customer_id');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['price', 'asaas_plan_id']);
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('price');
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};

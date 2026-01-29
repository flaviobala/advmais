<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add course_video to courses
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'course_video')) {
                $table->string('course_video')->nullable()->after('cover_image');
            }
        });

        // Add attachment to lessons
        Schema::table('lessons', function (Blueprint $table) {
            if (!Schema::hasColumn('lessons', 'attachment')) {
                $table->string('attachment')->nullable()->after('duration_seconds');
            }
        });

        // Drop pivot and groups tables if they exist
        if (Schema::hasTable('course_group')) {
            Schema::dropIfExists('course_group');
        }

        if (Schema::hasTable('lesson_group')) {
            Schema::dropIfExists('lesson_group');
        }

        if (Schema::hasTable('group_user')) {
            Schema::dropIfExists('group_user');
        }

        if (Schema::hasTable('groups')) {
            Schema::dropIfExists('groups');
        }
    }

    public function down(): void
    {
        // Recreate groups table (basic)
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // recreate pivot tables (empty)
        Schema::create('group_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('course_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->timestamp('available_at')->nullable();
            $table->timestamps();
        });

        Schema::create('lesson_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->timestamp('available_at')->nullable();
            $table->timestamps();
        });

        // remove added columns
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'course_video')) {
                $table->dropColumn('course_video');
            }
        });

        Schema::table('lessons', function (Blueprint $table) {
            if (Schema::hasColumn('lessons', 'attachment')) {
                $table->dropColumn('attachment');
            }
        });
    }
};

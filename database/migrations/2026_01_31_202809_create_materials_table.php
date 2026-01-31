<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->morphs('materialable');
            $table->enum('type', ['file', 'link'])->default('file');
            $table->string('title')->nullable();
            $table->string('filename')->nullable();
            $table->string('filepath')->nullable();
            $table->string('filetype')->nullable();
            $table->unsignedBigInteger('filesize')->nullable();
            $table->string('url')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};

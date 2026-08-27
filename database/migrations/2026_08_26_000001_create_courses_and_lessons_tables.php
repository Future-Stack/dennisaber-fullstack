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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('duration_days')->default(90);
            $table->string('total_hours')->nullable();
            $table->string('public_url')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('chapter_name')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->integer('lesson_number')->default(1);
            $table->integer('duration_minutes')->default(15);
            $table->string('video_url')->nullable();
            $table->string('video_path')->nullable();
            $table->string('audio_path')->nullable();
            $table->string('pdf_attachment_path')->nullable();
            $table->string('pdf_attachment_name')->nullable();
            $table->longText('content_html')->nullable();
            $table->boolean('is_preview')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->unique(['course_id', 'slug']);
        });

        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('invoice_number')->nullable();
            $table->date('started_at');
            $table->date('expires_at');
            $table->boolean('is_active')->default(true);
            $table->boolean('early_start_agreed')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
        });

        Schema::create('lesson_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->integer('last_position_seconds')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'lesson_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_progress');
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('courses');
    }
};

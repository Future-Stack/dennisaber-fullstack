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
        Schema::create('admin_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title', 120);
            $table->text('body');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        Schema::create('version_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title', 120);
            $table->text('body');
            $table->timestamps();
        });

        Schema::create('access_requests', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('username')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('course_slug')->nullable();
            $table->string('course_name')->nullable();
            $table->string('email')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->default('open'); // 'open', 'resolved', 'rejected'
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_requests');
        Schema::dropIfExists('version_notes');
        Schema::dropIfExists('admin_notes');
    }
};

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
        Schema::table('time_entries', function (Blueprint $table) {
            if (!Schema::hasColumn('time_entries', 'activity_1')) {
                $table->string('activity_1')->nullable()->after('activity_description');
                $table->string('activity_2')->nullable()->after('activity_1');
                $table->string('activity_3')->nullable()->after('activity_2');
                $table->string('activity_4')->nullable()->after('activity_3');
                $table->string('activity_5')->nullable()->after('activity_4');
                $table->foreignId('assigned_staff_id')->nullable()->after('activity_5')->constrained('users')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('time_entries', function (Blueprint $table) {
            if (Schema::hasColumn('time_entries', 'activity_1')) {
                $table->dropForeign(['assigned_staff_id']);
                $table->dropColumn(['activity_1', 'activity_2', 'activity_3', 'activity_4', 'activity_5', 'assigned_staff_id']);
            }
        });
    }
};

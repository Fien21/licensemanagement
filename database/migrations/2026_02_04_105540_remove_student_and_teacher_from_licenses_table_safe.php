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
        Schema::table('licenses', function (Blueprint $table) {
            if (Schema::hasColumn('licenses', 'student_id')) {
                $table->dropColumn('student_id');
            }
            if (Schema::hasColumn('licenses', 'teacher_id')) {
                $table->dropColumn('teacher_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('licenses', function (Blueprint $table) {
            $table->string('student_id')->nullable();
            $table->string('teacher_id')->nullable();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_answers', function (Blueprint $table) {
            // Make selected_option_id nullable to support unanswered questions
            $table->integer('selected_option_id')->nullable()->change();

            // Add index for performance
            $table->index(['student_id', 'question_id']);
        });
    }

    public function down(): void
    {
        Schema::table('student_answers', function (Blueprint $table) {
            // Revert to NOT NULL (requires data cleanup first)
            $table->integer('selected_option_id')->nullable(false)->change();
        });
    }
};

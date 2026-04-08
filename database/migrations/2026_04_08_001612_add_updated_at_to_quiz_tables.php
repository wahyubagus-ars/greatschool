<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add to quizzes
        Schema::table('quizzes', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });

        // Add to quiz_questions
        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });

        // Add to question_options
        Schema::table('question_options', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });

        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });

        Schema::table('question_options', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });
    }
};

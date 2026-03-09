<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_student_literacy_progress_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_literacy_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('literacy_content_id')->constrained()->onDelete('cascade');
            $table->timestamp('viewed_at')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'literacy_content_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_literacy_progress');
    }
};

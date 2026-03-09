<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_columns_to_quizzes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dateTime('start_date')->nullable()->after('description');
            $table->dateTime('end_date')->nullable()->after('start_date');
            $table->integer('duration_minutes')->nullable()->after('end_date');
            $table->string('category')->nullable()->after('duration_minutes');
        });
    }

    public function down()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date', 'duration_minutes', 'category']);
        });
    }
};

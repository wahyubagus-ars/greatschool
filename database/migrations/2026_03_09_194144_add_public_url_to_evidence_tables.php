<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bullying_evidence', function (Blueprint $table) {
            $table->string('public_url')->nullable()->after('file_path');
        });

        Schema::table('facility_evidence', function (Blueprint $table) {
            $table->string('public_url')->nullable()->after('file_path');
        });
    }

    public function down()
    {
        Schema::table('bullying_evidence', function (Blueprint $table) {
            $table->dropColumn('public_url');
        });

        Schema::table('facility_evidence', function (Blueprint $table) {
            $table->dropColumn('public_url');
        });
    }
};

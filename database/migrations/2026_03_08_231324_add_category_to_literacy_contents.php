<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('literacy_contents', function (Blueprint $table) {
            $table->string('category')->after('type')->nullable()->comment('e.g., anti-bullying, digital-literacy, mental-health');
            $table->string('platform')->after('url')->nullable()->comment('youtube, tiktok, instagram, medium');
            $table->string('platform_id')->after('platform')->nullable()->comment('Video ID or slug for embedding');
        });
    }

    public function down()
    {
        Schema::table('literacy_contents', function (Blueprint $table) {
            $table->dropColumn(['category', 'platform', 'platform_id']);
        });
    }
};

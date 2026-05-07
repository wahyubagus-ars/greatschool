<?php
// database/migrations/xxxx_xx_xx_add_available_points_to_students_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // available_points = total_points - redeemed points
            $table->integer('available_points')->default(0)->after('total_points');
        });

        // Backfill: set available_points = total_points for existing students
        DB::statement('UPDATE students SET available_points = total_points');
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('available_points');
        });
    }
};

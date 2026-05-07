<?php
// database/migrations/xxxx_xx_xx_create_point_redemptions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('point_redemptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('qr_code', 64)->unique(); // UUID for QR payload
            $table->integer('points_redeemed');
            $table->integer('idr_value'); // IDR value (10 points = 1000 IDR)
            $table->enum('status', ['pending', 'redeemed', 'expired', 'cancelled'])->default('pending');
            $table->timestamp('expires_at');
            $table->timestamp('redeemed_at')->nullable();
            $table->foreignId('redeemed_by_admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->string('location')->nullable(); // Where redemption happened
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['qr_code', 'status']);
            $table->index(['student_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('point_redemptions');
    }
};

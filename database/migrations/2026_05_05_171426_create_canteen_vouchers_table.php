<?php
// database/migrations/xxxx_xx_xx_create_canteen_vouchers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('canteen_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Nasi Goreng Voucher"
            $table->integer('points_required'); // e.g., 50 points
            $table->integer('idr_value'); // e.g., 5000 IDR
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('daily_limit')->nullable(); // Max redemptions per day
            $table->integer('used_today')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'points_required']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('canteen_vouchers');
    }
};

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class PointRedemption extends Model
{
    protected $fillable = [
        'student_id',
        'qr_code',
        'points_redeemed',
        'idr_value',
        'status',
        'expires_at',
        'redeemed_at',
        'redeemed_by_admin_id',
        'location',
        'notes',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'redeemed_at' => 'datetime',
    ];

    /**
     * Generate a simple, human-readable 8-character redemption code
     * Uses uppercase letters (excluding confusing chars) + numbers
     * Format: ABC12XYZ (easy to read/communicate verbally)
     */
    public static function generateRedemptionCode(): string
    {
        // Characters that are easy to distinguish verbally and visually
        // Excluded: O (looks like 0), I/L (look like 1), S/5 (can confuse), Z/2 (can confuse)
        $characters = 'ABCDEFGHJKMNPQRSTUVWXY346789'; // 24 safe characters
        $codeLength = 8;
        $code = '';

        // Generate unique code with collision handling
        do {
            $code = '';
            for ($i = 0; $i < $codeLength; $i++) {
                $code .= $characters[random_int(0, strlen($characters) - 1)];
            }
        } while (self::where('qr_code', $code)->exists());

        return $code;
    }

    /**
     * Validate if a code matches the expected format
     */
    public static function isValidCodeFormat(string $code): bool
    {
        return preg_match('/^[ABCDEFGHJKMNPQRSTUVWXY346789]{8}$/', strtoupper($code)) === 1;
    }

    // Check if QR is still valid
    public function isValid(): bool
    {
        return $this->status === 'pending' && now()->lessThan($this->expires_at);
    }

    // Calculate IDR value from points (10 points = 1000 IDR)
    public static function pointsToIdr(int $points): int
    {
        return ($points * 1000) / 10;
    }

    // Relationships
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function redeemedByAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'redeemed_by_admin_id');
    }
}

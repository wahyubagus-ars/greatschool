<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admins';

    // Enable timestamps if needed (currently your table has only created_at)
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password_hash',
        'full_name',
        'email',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the name of the unique identifier for the user.
     * This should return the column name, NOT the guard name.
     */
    public function getAuthIdentifierName(): string
    {
        return 'id'; // Changed from 'username' to 'id'
    }

    /**
     * Get the unique identifier for the user.
     * This returns the actual ID value for session storage.
     */
    public function getAuthIdentifier()
    {
        return $this->getKey(); // Returns the primary key value (integer)
    }

    /**
     * Get the password for the user.
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    /**
     * Get the token value for the "remember me" session.
     */
    public function getRememberToken()
    {
        return null; // Or add a remember_token column if needed
    }

    /**
     * Set the token value for the "remember me" session.
     */
    public function setRememberToken($value)
    {
        // No-op if no remember_token column
    }

    /**
     * Get the column name for the "remember me" token.
     */
    public function getRememberTokenName()
    {
        return null;
    }

    public function verifiedBullyingReports(): HasMany
    {
        return $this->hasMany(BullyingReport::class, 'verified_by_admin_id');
    }

    public function verifiedFacilityReports(): HasMany
    {
        return $this->hasMany(FacilityReport::class, 'verified_by_admin_id');
    }

    // Add to existing Admin model

    public function redeemQr(string $qrCode, string $location = null): array
    {
        $redemption = PointRedemption::where('qr_code', $qrCode)
            ->with('student')
            ->first();

        if (!$redemption) {
            return ['success' => false, 'message' => 'Invalid QR code'];
        }

        if (!$redemption->isValid()) {
            return ['success' => false, 'message' => 'QR code expired or already used'];
        }

        // Process redemption
        $redemption->update([
            'status' => 'redeemed',
            'redeemed_at' => now(),
            'redeemed_by_admin_id' => $this->id,
            'location' => $location,
        ]);

        // Log transaction for audit
        $redemption->student->pointTransactions()->create([
            'source' => 'redemption',
            'source_id' => $redemption->id,
            'points' => -$redemption->points_redeemed, // Negative for deduction
            'description' => "Redeemed {$redemption->idr_value} IDR voucher at {$location}",
        ]);

        return [
            'success' => true,
            'message' => "Successfully redeemed {$redemption->idr_value} IDR",
            'student_name' => $redemption->student->full_name,
            'idr_value' => $redemption->idr_value,
        ];
    }
}

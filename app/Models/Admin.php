<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins';
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

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function verifiedBullyingReports(): HasMany
    {
        return $this->hasMany(BullyingReport::class, 'verified_by_admin_id');
    }

    public function verifiedFacilityReports(): HasMany
    {
        return $this->hasMany(FacilityReport::class, 'verified_by_admin_id');
    }
}

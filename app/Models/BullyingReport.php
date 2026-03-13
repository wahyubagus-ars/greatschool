<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BullyingReport extends Model
{
    use HasFactory;

    protected $table = 'bullying_reports';

    protected $fillable = [
        'student_id',
        'reporter_type',
        'title',
        'incident_date',
        'location',
        'description',
        'status',
        'verification_note',
        'verified_by_admin_id',
        'verified_at',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function verifiedByAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'verified_by_admin_id');
    }

    public function evidence(): HasMany
    {
        return $this->hasMany(BullyingEvidence::class, 'report_id');
    }
}

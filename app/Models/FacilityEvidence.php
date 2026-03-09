<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacilityEvidence extends Model
{
    use HasFactory;

    protected $table = 'facility_evidence';

    // No updated_at column
    public $timestamps = false;

    protected $fillable = [
        'report_id',
        'file_path',
        'file_name',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(FacilityReport::class, 'report_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BullyingEvidence extends Model
{
    use HasFactory;

    protected $table = 'bullying_evidence';

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
        return $this->belongsTo(BullyingReport::class, 'report_id');
    }
}

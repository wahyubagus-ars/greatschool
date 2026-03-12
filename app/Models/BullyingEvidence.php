<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

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
        'public_url',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(BullyingReport::class);
    }

    public function getPublicUrlAttribute()
    {
        return Storage::disk('s3')->temporaryUrl(
            $this->file_path,
            now()->addMinutes(5)
        );
    }
}

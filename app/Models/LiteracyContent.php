<?php

// app/Models/LiteracyContent.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class LiteracyContent extends Model
{
    protected $fillable = [
        'type',
        'category',
        'title',
        'content',
        'url',
        'thumbnail',
        'platform',
        'platform_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Platform detection helper
    public function getPlatformBadgeAttribute(): array
    {
        return match($this->platform) {
            'youtube' => ['bg-red-500', 'YouTube'],
            'tiktok' => ['bg-black', 'TikTok'],
            'instagram' => ['bg-gradient-to-r from-[#405de6] via-[#5851db] to-[#c13584]', 'Instagram'],
            'medium' => ['bg-green-500', 'Medium'],
            default => ['bg-gray-500', 'External']
        };
    }

    // Category label helper
    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'anti-bullying' => 'Anti-Bullying',
            'digital-literacy' => 'Digital Literacy',
            'mental-health' => 'Mental Health',
            'school-safety' => 'School Safety',
            default => Str::headline($this->category ?? 'General')
        };
    }

    // Safe external URL with tracking
    public function getSafeUrlAttribute(): string
    {
        return $this->url
            ? url('/literacy/redirect?url=' . urlencode($this->url))
            : '#';
    }

    public function quizzes(): BelongsToMany
    {
        return $this->belongsToMany(Quiz::class, 'quiz_literacy_contents');
    }

    public function studentProgress(): HasMany
    {
        return $this->hasMany(StudentLiteracyProgress::class);
    }
}

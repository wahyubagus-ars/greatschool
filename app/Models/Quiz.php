<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quizzes';

    protected $fillable = [
        'title',
        'description',
        'points_per_quiz',
    ];

    protected $casts = [
        'points_per_quiz' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(QuizResult::class);
    }

    public function literacyContents(): BelongsToMany
    {
        return $this->belongsToMany(LiteracyContent::class, 'quiz_literacy_contents');
    }
}

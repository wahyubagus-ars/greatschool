<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizResult extends Model
{
    use HasFactory;

    protected $table = 'quiz_results';

    protected $fillable = [
        'student_id',
        'quiz_id',
        'score',
        'total_questions',
        'points_earned',
    ];

    protected $casts = [
        'score' => 'integer',
        'total_questions' => 'integer',
        'points_earned' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}

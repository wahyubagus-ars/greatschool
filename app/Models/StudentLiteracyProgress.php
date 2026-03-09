<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentLiteracyProgress extends Model
{
    use HasFactory;

    protected $table = 'student_literacy_progress';

    protected $fillable = [
        'student_id',
        'literacy_content_id',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function literacyContent(): BelongsTo
    {
        return $this->belongsTo(LiteracyContent::class);
    }
}

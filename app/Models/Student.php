<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'students';

    protected $fillable = [
        'nis',
        'password_hash',
        'full_name',
        'email',
        'phone_number',
        'total_points',
    ];

    protected $hidden = [
        'password_hash', // hide from arrays
    ];

    // Use password_hash as the password field for authentication
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    // Use 'nis' as the username/identifier
    public function getAuthIdentifierName()
    {
        return 'nis';
    }

    // If you don't need remember tokens, you can skip or implement as null
    public function getRememberToken()
    {
        return null; // not used
    }

    public function setRememberToken($value)
    {
        // not used
    }

    public function getRememberTokenName()
    {
        return null; // not used
    }

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function bullyingReports(): HasMany
    {
        return $this->hasMany(BullyingReport::class);
    }

    public function facilityReports(): HasMany
    {
        return $this->hasMany(FacilityReport::class);
    }

    public function quizResults(): HasMany
    {
        return $this->hasMany(QuizResult::class);
    }

    public function pointTransactions(): HasMany
    {
        return $this->hasMany(PointTransaction::class);
    }

    public function literacyProgress(): HasMany
    {
        return $this->hasMany(StudentLiteracyProgress::class);
    }

    /**
     * Get recent activities for dashboard timeline
     * Returns unified collection of activities sorted by timestamp
     */
    public function getRecentActivitiesAttribute()
    {
        $activities = collect();

        // 1. Bullying reports (created + status updates)
        $this->bullyingReports()
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get()
            ->each(function ($report) use (&$activities) {
                // Report creation
                $activities->push([
                    'type' => 'bullying_report_created',
                    'icon' => 'shield-exclamation',
                    'color' => 'text-red-500 bg-red-50',
                    'title' => 'Bullying Report Submitted',
                    'description' => Str::limit($report->title, 40),
                    'points' => $report->status === 'verified' ? '+15' : null,
                    'timestamp' => $report->created_at,
                    'url' => route('student.bullying-reports.show', $report),
                ]);

                // Status update (if different from creation time and verified/rejected)
                if ($report->status !== 'pending' && $report->updated_at->diffInSeconds($report->created_at) > 60) {
                    $statusLabel = match($report->status) {
                        'verified' => 'verified',
                        'rejected' => 'reviewed',
                        default => 'updated'
                    };

                    $activities->push([
                        'type' => 'bullying_report_status',
                        'icon' => $report->status === 'verified' ? 'check-circle' : 'x-circle',
                        'color' => $report->status === 'verified' ? 'text-green-500 bg-green-50' : 'text-yellow-500 bg-yellow-50',
                        'title' => "Report {$statusLabel}: {$report->status}",
                        'description' => Str::limit($report->title, 40),
                        'points' => $report->status === 'verified' ? '+15' : null,
                        'timestamp' => $report->updated_at,
                        'url' => route('student.bullying-reports.show', $report),
                    ]);
                }
            });

        // 2. Facility reports (created + status updates)
        $this->facilityReports()
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get()
            ->each(function ($report) use (&$activities) {
                // Report creation
                $activities->push([
                    'type' => 'facility_report_created',
                    'icon' => 'wrench',
                    'color' => 'text-yellow-500 bg-yellow-50',
                    'title' => 'Facility Report Submitted',
                    'description' => Str::limit($report->title, 40),
                    'points' => $report->status === 'verified' ? '+10' : null,
                    'timestamp' => $report->created_at,
                    'url' => route('student.facility-reports.show', $report),
                ]);

                // Status update
                if ($report->status !== 'pending' && $report->updated_at->diffInSeconds($report->created_at) > 60) {
                    $statusLabel = match($report->status) {
                        'verified' => 'fixed',
                        'rejected' => 'reviewed',
                        default => 'updated'
                    };

                    $activities->push([
                        'type' => 'facility_report_status',
                        'icon' => $report->status === 'verified' ? 'check-circle' : 'x-circle',
                        'color' => $report->status === 'verified' ? 'text-green-500 bg-green-50' : 'text-yellow-500 bg-yellow-50',
                        'title' => "Issue {$statusLabel}: {$report->status}",
                        'description' => Str::limit($report->title, 40),
                        'points' => $report->status === 'verified' ? '+10' : null,
                        'timestamp' => $report->updated_at,
                        'url' => route('student.facility-reports.show', $report),
                    ]);
                }
            });

        // 3. Quiz completions
        $this->quizResults()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->each(function ($result) use (&$activities) {
                $activities->push([
                    'type' => 'quiz_completed',
                    'icon' => 'academic-cap',
                    'color' => 'text-indigo-500 bg-indigo-50',
                    'title' => 'Quiz Completed',
                    'description' => Str::limit($result->quiz->title, 40),
                    'points' => "+{$result->points_earned}",
                    'score' => "{$result->score}/{$result->total_questions}",
                    'timestamp' => $result->created_at,
                    'url' => route('student.quizzes.result', $result->quiz),
                ]);
            });

        // Sort by timestamp descending and limit to 8 activities
        return $activities
            ->sortByDesc('timestamp')
            ->take(8)
            ->values();
    }
}

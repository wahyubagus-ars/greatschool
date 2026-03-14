<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\BullyingReport;
use App\Models\FacilityReport;
use App\Models\QuizResult;
use App\Models\PointTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentManagementController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'sort' => ['nullable', 'in:name,nis,points,created_at'],
            'order' => ['nullable', 'in:asc,desc'],
        ]);

        $search = $validated['search'] ?? '';
        $sort = $validated['sort'] ?? 'full_name';
        $order = $validated['order'] ?? 'asc';

        $query = Student::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'ilike', "%{$search}%")
                    ->orWhere('nis', 'ilike', "%{$search}%")
                    ->orWhere('email', 'ilike', "%{$search}%");
            });
        }

        $sortColumn = match ($sort) {
            'nis' => 'nis',
            'points' => 'total_points',
            'created_at' => 'created_at',
            default => 'full_name',
        };

        $query->orderBy($sortColumn, $order);

        $students = $query->paginate(15)->withQueryString();

        $totalStudents = Student::count();
        $activeStudents = Student::whereHas('bullyingReports')
            ->orWhereHas('facilityReports')
            ->orWhereHas('quizResults')
            ->distinct()
            ->count();

        return view('admin.students.index', compact(
            'students',
            'search',
            'sort',
            'order',
            'totalStudents',
            'activeStudents'
        ));
    }

    /**
     * Display the specified student with full profile.
     */
    public function show(Student $student)
    {
        $student->load([
            'bullyingReports' => function ($query) {
                $query->with('verifiedByAdmin')->orderBy('created_at', 'desc')->limit(10);
            },
            'facilityReports' => function ($query) {
                $query->with('verifiedByAdmin')->orderBy('created_at', 'desc')->limit(10);
            },
            'quizResults' => function ($query) {
                $query->with('quiz')->orderBy('created_at', 'desc')->limit(10);
            },
            'pointTransactions' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(15);
            }
        ]);

        $stats = [
            'total_bullying_reports' => $student->bullyingReports()->count(),
            'pending_bullying_reports' => $student->bullyingReports()->where('status', 'pending')->count(),
            'total_facility_reports' => $student->facilityReports()->count(),
            'pending_facility_reports' => $student->facilityReports()->where('status', 'pending')->count(),
            'quizzes_taken' => $student->quizResults()->count(),
            'average_quiz_score' => $student->quizResults()->avg('score') ?? 0,
            'total_points_earned' => $student->pointTransactions()->sum('points'),
        ];

        return view('admin.students.show', compact('student', 'stats'));
    }

    /**
     * Reset student password.
     */
    public function resetPassword(Request $request, Student $student)
    {
        $validated = $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'max:255'],
        ]);

        DB::transaction(function () use ($student, $validated) {
            $student->update([
                'password_hash' => Hash::make($validated['new_password']),
            ]);

            \Log::channel('admin_audit')->info('Student password reset', [
                'admin_id' => auth()->guard('admin')->id(),
                'admin_username' => auth()->guard('admin')->user()->username,
                'student_id' => $student->id,
                'student_nis' => $student->nis,
                'ip_address' => request()->ip(),
                'timestamp' => now()->toDateTimeString(),
            ]);
        });

        return redirect()->back()
            ->with('success', 'Password has been reset successfully.');
    }

    /**
     * Add points to student.
     */
    public function addPoints(Request $request, Student $student)
    {
        $validated = $request->validate([
            'points' => ['required', 'integer', 'min:1', 'max:1000'],
            'description' => ['required', 'string', 'min:5', 'max:500'],
        ]);

        DB::transaction(function () use ($student, $validated) {
            // Create point transaction
            PointTransaction::create([
                'student_id' => $student->id,
                'source' => 'admin_award',
                'source_id' => auth()->guard('admin')->id(),
                'points' => $validated['points'],
                'description' => $validated['description'],
            ]);

            // Update student total points
            $student->increment('total_points', $validated['points']);

            \Log::channel('admin_audit')->info('Points awarded to student', [
                'admin_id' => auth()->guard('admin')->id(),
                'admin_username' => auth()->guard('admin')->user()->username,
                'student_id' => $student->id,
                'student_nis' => $student->nis,
                'points' => $validated['points'],
                'description' => $validated['description'],
                'ip_address' => request()->ip(),
                'timestamp' => now()->toDateTimeString(),
            ]);
        });

        return redirect()->back()
            ->with('success', "Successfully added {$validated['points']} points to {$student->full_name}.");
    }
}

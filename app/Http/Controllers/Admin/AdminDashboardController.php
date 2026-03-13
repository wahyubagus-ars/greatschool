<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BullyingReport;
use App\Models\FacilityReport;
use App\Models\Student;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // Pending reports counts
        $pendingBullyingReports = BullyingReport::where('status', 'pending')->count();
        $pendingFacilityReports = FacilityReport::where('status', 'pending')->count();

        // Total counts for overview
        $totalBullyingReports = BullyingReport::count();
        $totalFacilityReports = FacilityReport::count();
        $totalStudents = Student::count();
        $totalQuizzes = Quiz::count();

        // Recent pending reports for quick action
        $recentBullyingReports = BullyingReport::where('status', 'pending')
            ->with('student')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentFacilityReports = FacilityReport::where('status', 'pending')
            ->with('student')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Reports verified by this admin
        $verifiedByAdmin = $admin->verifiedBullyingReports()->count() + $admin->verifiedFacilityReports()->count();

        // Status breakdown for charts
        $bullyingStatusBreakdown = [
            'pending' => BullyingReport::where('status', 'pending')->count(),
            'verified' => BullyingReport::where('status', 'verified')->count(),
            'rejected' => BullyingReport::where('status', 'rejected')->count(),
        ];

        $facilityStatusBreakdown = [
            'pending' => FacilityReport::where('status', 'pending')->count(),
            'verified' => FacilityReport::where('status', 'verified')->count(),
            'rejected' => FacilityReport::where('status', 'rejected')->count(),
        ];

        return view('admin.dashboard', compact(
            'pendingBullyingReports',
            'pendingFacilityReports',
            'totalBullyingReports',
            'totalFacilityReports',
            'totalStudents',
            'totalQuizzes',
            'recentBullyingReports',
            'recentFacilityReports',
            'verifiedByAdmin',
            'bullyingStatusBreakdown',
            'facilityStatusBreakdown'
        ));
    }
}

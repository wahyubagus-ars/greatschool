<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacilityReport;
use Illuminate\Http\Request;

class FacilityReportManagementController extends Controller
{
    /**
     * Display a listing of facility reports.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = FacilityReport::with('student');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.facility-reports.index', compact('reports', 'status'));
    }

    /**
     * Display the specified facility report.
     */
    public function show(FacilityReport $facilityReport)
    {
        $facilityReport->load(['student', 'evidence']);

        return view('admin.facility-reports.show', compact('facilityReport'));
    }

    /**
     * Verify a facility report.
     */
    public function verify(Request $request, FacilityReport $facilityReport)
    {
        // TODO: Implement verification logic
        return redirect()->route('admin.facility-reports.index')
            ->with('success', 'Report verified successfully.');
    }

    /**
     * Reject a facility report.
     */
    public function reject(Request $request, FacilityReport $facilityReport)
    {
        // TODO: Implement rejection logic
        return redirect()->route('admin.facility-reports.index')
            ->with('success', 'Report rejected successfully.');
    }
}

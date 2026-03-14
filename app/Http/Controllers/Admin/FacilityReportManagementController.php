<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacilityReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FacilityReportManagementController extends Controller
{
    /**
     * Display a listing of facility reports.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'status' => ['nullable', Rule::in(['all', 'pending', 'verified', 'rejected'])],
            'sort' => ['nullable', Rule::in(['created_at', 'status'])],
            'order' => ['nullable', Rule::in(['asc', 'desc'])],
            'search' => ['nullable', 'string', 'max:100'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $status = $validated['status'] ?? 'all';
        $sort = $validated['sort'] ?? 'created_at';
        $order = $validated['order'] ?? 'desc';
        $search = $validated['search'] ?? '';
        $dateFrom = $validated['date_from'] ?? null;
        $dateTo = $validated['date_to'] ?? null;

        $query = FacilityReport::with(['student', 'verifiedByAdmin']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                    ->orWhere('description', 'ilike', "%{$search}%")
                    ->orWhere('location', 'ilike', "%{$search}%")
                    ->orWhereHas('student', function ($studentQuery) use ($search) {
                        $studentQuery->where('full_name', 'ilike', "%{$search}%")
                            ->orWhere('nis', 'ilike', "%{$search}%");
                    });
            });
        }

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $query->orderBy($sort, $order);

        $perPage = $request->get('per_page', 15);
        $reports = $query->paginate($perPage)->withQueryString();

        $statusCounts = [
            'all' => FacilityReport::count(),
            'pending' => FacilityReport::where('status', 'pending')->count(),
            'verified' => FacilityReport::where('status', 'verified')->count(),
            'rejected' => FacilityReport::where('status', 'rejected')->count(),
        ];

        $queryParams = $request->except('page');

        return view('admin.facility-reports.index', compact(
            'reports',
            'status',
            'sort',
            'order',
            'search',
            'dateFrom',
            'dateTo',
            'statusCounts',
            'queryParams'
        ));
    }

    /**
     * Display the specified facility report.
     */
    public function show(FacilityReport $facilityReport)
    {
        $facilityReport->load([
            'student',
            'verifiedByAdmin',
            'evidence'
        ]);

        $studentOtherReports = FacilityReport::where('student_id', $facilityReport->student_id)
            ->where('id', '!=', $facilityReport->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.facility-reports.show', compact(
            'facilityReport',
            'studentOtherReports'
        ));
    }

    /**
     * Verify a facility report.
     */
    public function verify(Request $request, FacilityReport $facilityReport)
    {
        $validated = $request->validate([
            'verification_note' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($facilityReport->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'This report has already been processed.');
        }

        DB::transaction(function () use ($facilityReport, $validated) {
            $facilityReport->update([
                'status' => 'verified',
                'verification_note' => $validated['verification_note'] ?? null,
                'verified_by_admin_id' => Auth::guard('admin')->id(),
                'verified_at' => now(),
            ]);

            $this->logAdminAction('verified', $facilityReport);
        });

        return redirect()->route('admin.facility-reports.show', $facilityReport)
            ->with('success', 'Report has been verified successfully.');
    }

    /**
     * Reject a facility report.
     */
    public function reject(Request $request, FacilityReport $facilityReport)
    {
        $validated = $request->validate([
            'verification_note' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'verification_note.required' => 'Please provide a reason for rejection.',
            'verification_note.min' => 'Rejection reason must be at least 10 characters.',
        ]);

        if ($facilityReport->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'This report has already been processed.');
        }

        DB::transaction(function () use ($facilityReport, $validated) {
            $facilityReport->update([
                'status' => 'rejected',
                'verification_note' => $validated['verification_note'],
                'verified_by_admin_id' => Auth::guard('admin')->id(),
                'verified_at' => now(),
            ]);

            $this->logAdminAction('rejected', $facilityReport);
        });

        return redirect()->route('admin.facility-reports.show', $facilityReport)
            ->with('success', 'Report has been rejected.');
    }

    /**
     * Log admin action for audit trail.
     */
    private function logAdminAction(string $action, FacilityReport $report): void
    {
        \Log::channel('admin_audit')->info('Facility report ' . $action, [
            'admin_id' => Auth::guard('admin')->id(),
            'admin_username' => Auth::guard('admin')->user()->username,
            'report_id' => $report->id,
            'report_title' => $report->title,
            'student_id' => $report->student_id,
            'previous_status' => 'pending',
            'new_status' => $action,
            'ip_address' => request()->ip(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
}

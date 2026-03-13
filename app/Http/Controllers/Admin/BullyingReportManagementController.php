<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BullyingReport;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BullyingReportManagementController extends Controller
{
    /**
     * Display a listing of bullying reports with filtering, sorting, and search.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Validate input parameters
        $validated = $request->validate([
            'status' => ['nullable', Rule::in(['all', 'pending', 'verified', 'rejected'])],
            'sort' => ['nullable', Rule::in(['created_at', 'incident_date', 'student_name', 'status'])],
            'order' => ['nullable', Rule::in(['asc', 'desc'])],
            'search' => ['nullable', 'string', 'max:100'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        // Extract validated parameters with defaults
        $status = $validated['status'] ?? 'all';
        $sort = $validated['sort'] ?? 'created_at';
        $order = $validated['order'] ?? 'desc';
        $search = $validated['search'] ?? '';
        $dateFrom = $validated['date_from'] ?? null;
        $dateTo = $validated['date_to'] ?? null;

        // Build query with eager loading for performance
        $query = BullyingReport::with(['student', 'verifiedByAdmin']);

        // Apply status filter
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Apply search filter (search in title, description, student name, NIS)
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

        // Apply date range filter
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Apply sorting
        $sortColumn = $this->getSortColumn($sort);
        $query->orderBy($sortColumn, $order);

        // Paginate results
        $perPage = $request->get('per_page', 15);
        $reports = $query->paginate($perPage)->withQueryString();

        // Get status counts for filter badges
        $statusCounts = $this->getStatusCounts();

        // Preserve query parameters for pagination links
        $queryParams = $request->except('page');

        return view('admin.bullying-reports.index', compact(
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
     * Display the specified bullying report with full details.
     *
     * @param BullyingReport $bullyingReport
     * @return \Illuminate\View\View
     */
    public function show(BullyingReport $bullyingReport)
    {
        $bullyingReport->load([
            'student',
            'verifiedByAdmin',
            'evidence'
        ]);

        $studentOtherReports = BullyingReport::where('student_id', $bullyingReport->student_id)
            ->where('id', '!=', $bullyingReport->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.bullying-reports.show', compact(
            'bullyingReport',
            'studentOtherReports'
        ));
    }

    /**
     * Verify a bullying report.
     *
     * @param Request $request
     * @param BullyingReport $bullyingReport
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request, BullyingReport $bullyingReport)
    {
        // Validate verification note
        $validated = $request->validate([
            'verification_note' => ['nullable', 'string', 'max:1000'],
        ]);

        // Check if report is already processed
        if ($bullyingReport->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'This report has already been processed.');
        }

        // Update report status
        DB::transaction(function () use ($bullyingReport, $validated) {
            $bullyingReport->update([
                'status' => 'verified',
                'verification_note' => $validated['verification_note'] ?? null,
                'verified_by_admin_id' => Auth::guard('admin')->id(),
                'verified_at' => now(),
            ]);

            // Log the action for audit trail
            $this->logAdminAction('verified', $bullyingReport);
        });

        return redirect()->route('admin.bullying-reports.show', $bullyingReport)
            ->with('success', 'Report has been verified successfully.');
    }

    /**
     * Reject a bullying report.
     *
     * @param Request $request
     * @param BullyingReport $bullyingReport
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(Request $request, BullyingReport $bullyingReport)
    {
        // Rejection requires a note
        $validated = $request->validate([
            'verification_note' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'verification_note.required' => 'Please provide a reason for rejection.',
            'verification_note.min' => 'Rejection reason must be at least 10 characters.',
        ]);

        // Check if report is already processed
        if ($bullyingReport->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'This report has already been processed.');
        }

        // Update report status
        DB::transaction(function () use ($bullyingReport, $validated) {
            $bullyingReport->update([
                'status' => 'rejected',
                'verification_note' => $validated['verification_note'],
                'verified_by_admin_id' => Auth::guard('admin')->id(),
                'verified_at' => now(),
            ]);

            // Log the action for audit trail
            $this->logAdminAction('rejected', $bullyingReport);
        });

        return redirect()->route('admin.bullying-reports.show', $bullyingReport)
            ->with('success', 'Report has been rejected.');
    }

    /**
     * Get the database column name for sorting.
     *
     * @param string $sort
     * @return string
     */
    private function getSortColumn(string $sort): string
    {
        return match ($sort) {
            'student_name' => 'student_id', // Will join with students table
            'incident_date' => 'incident_date',
            'status' => 'status',
            default => 'created_at',
        };
    }

    /**
     * Get counts for each status for filter badges.
     *
     * @return array
     */
    private function getStatusCounts(): array
    {
        return [
            'all' => BullyingReport::count(),
            'pending' => BullyingReport::where('status', 'pending')->count(),
            'verified' => BullyingReport::where('status', 'verified')->count(),
            'rejected' => BullyingReport::where('status', 'rejected')->count(),
        ];
    }

    /**
     * Log admin action for audit trail.
     *
     * @param string $action
     * @param BullyingReport $report
     * @return void
     */
    private function logAdminAction(string $action, BullyingReport $report): void
    {
        \Log::channel('admin_audit')->info('Bullying report ' . $action, [
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

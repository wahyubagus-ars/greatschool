<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFacilityReportRequest;
use App\Models\FacilityReport;
use App\Models\FacilityEvidence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FacilityReportController extends Controller
{
    protected $student;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->student = Auth::guard('student')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the student's facility reports.
     */
    public function index()
    {
        $reports = FacilityReport::where('student_id', $this->student->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('student.facility-reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new report.
     */
    public function create()
    {
        return view('student.facility-reports.create');
    }

    /**
     * Store a newly created report in storage.
     */
    public function store(StoreFacilityReportRequest $request)
    {
        $validated = $request->validated();

        // Create the report
        $report = FacilityReport::create([
            'student_id' => $this->student->id,
            'title' => $validated['title'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'status' => 'pending',
        ]);

        // Handle evidence files if any
        if ($request->hasFile('evidence_files')) {
            foreach ($request->file('evidence_files') as $file) {
                $path = $file->store('facility-evidence', 'public');
                FacilityEvidence::create([
                    'report_id' => $report->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->route('student.facility-reports.show', $report)
            ->with('success', 'Facility report submitted successfully.');
    }

    /**
     * Display the specified report.
     */
    public function show(FacilityReport $facilityReport)
    {
        // Ensure the student owns this report
        if ($facilityReport->student_id !== $this->student->id) {
            abort(403);
        }

        return view('student.facility-reports.show', compact('facilityReport'));
    }
}

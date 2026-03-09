<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBullyingReportRequest;
use App\Models\BullyingReport;
use App\Models\BullyingEvidence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BullyingReportController extends Controller
{
    protected $student;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->student = Auth::guard('student')->user();
            return $next($request);
        });
    }

    public function index()
    {
        $reports = $this->student->bullyingReports()->latest()->paginate(10);
        return view('student.bullying-reports.index', compact('reports'));
    }

    public function create()
    {
        return view('student.bullying-reports.create');
    }

    public function store(StoreBullyingReportRequest $request)
    {
        $validated = $request->validated();

        // Create report
        $report = BullyingReport::create([
            'student_id' => $this->student->id,
            'reporter_type' => $validated['reporter_type'],
            'title' => $validated['title'],
            'incident_date' => $validated['incident_date'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'status' => 'pending',
        ]);

        // Handle evidence uploads
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $path = $file->store('bullying-evidence', 'public');
                BullyingEvidence::create([
                    'report_id' => $report->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        // Optionally award points? Not yet, only after verification.

        return redirect()->route('student.bullying-reports.show', $report)
            ->with('success', 'Bullying report submitted successfully.');
    }

    public function show(BullyingReport $bullyingReport)
    {
        // Ensure the report belongs to the authenticated student
        if ($bullyingReport->student_id !== $this->student->id) {
            abort(403);
        }

        return view('student.bullying-reports.show', compact('bullyingReport'));
    }
}

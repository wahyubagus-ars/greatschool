<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFacilityReportRequest;
use App\Models\FacilityReport;
use App\Models\FacilityEvidence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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

    public function index()
    {
        $reports = FacilityReport::where('student_id', $this->student->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('student.facility-reports.index', compact('reports'));
    }

    public function create()
    {
        return view('student.facility-reports.create');
    }
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

        // Handle evidence files
        if ($request->hasFile('evidence_files')) {
            foreach ($request->file('evidence_files') as $file) {
                try {

                    $filename = Str::uuid() . '_' . $file->getClientOriginalName();

                    $path = "facility-evidence/{$this->student->id}/{$report->id}/{$filename}";

                    // SAME LOGIC AS BULLYING REPORT
                    $storedPath = Storage::disk('supabase')->putFile(
                        dirname($path),
                        $file,
                        'public'
                    );

                    // Generate URL via driver
                    $publicUrl = Storage::disk('supabase')->url($storedPath);

                    FacilityEvidence::create([
                        'report_id' => $report->id,
                        'file_path' => $storedPath,
                        'file_name' => $file->getClientOriginalName(),
                        'public_url' => $publicUrl,
                    ]);

                } catch (\Exception $e) {

                    Log::error('Supabase upload failed', [
                        'student_id' => $this->student->id,
                        'report_id' => $report->id,
                        'filename' => $file->getClientOriginalName(),
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);

                    session()->flash(
                        'warning',
                        'Report created but some evidence files failed to upload. Please try again later.'
                    );
                }
            }
        }

        return redirect()
            ->route('student.facility-reports.show', $report)
            ->with('success', 'Facility report submitted successfully.');
    }

    public function show(FacilityReport $facilityReport)
    {
        if ($facilityReport->student_id !== $this->student->id) {
            abort(403);
        }

        return view('student.facility-reports.show', compact('facilityReport'));
    }
}

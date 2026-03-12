<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBullyingReportRequest;
use App\Models\BullyingReport;
use App\Models\BullyingEvidence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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
//
//    public function store(StoreBullyingReportRequest $request)
//    {
//        $validated = $request->validated();
//
//        // Create report
//        $report = BullyingReport::create([
//            'student_id' => $this->student->id,
//            'reporter_type' => $validated['reporter_type'],
//            'title' => $validated['title'],
//            'incident_date' => $validated['incident_date'],
//            'location' => $validated['location'],
//            'description' => $validated['description'],
//            'status' => 'pending',
//        ]);
//
//        // Handle evidence uploads to Supabase
//        if ($request->hasFile('evidence')) {
//            foreach ($request->file('evidence') as $file) {
//                try {
//                    // Generate secure unique filename
//                    $filename = Str::uuid() . '_' . $file->getClientOriginalName();
//
//                    // Organize files by student/report for easy management
//                    $path = "bullying-evidence/{$this->student->id}/{$report->id}/{$filename}";
//
//                    // Upload to Supabase storage with error handling
//                    if (!Storage::disk('supabase')->put($path, file_get_contents($file))) {
//                        throw new \Exception("Failed to upload file to Supabase");
//                    }
//
//                    // Generate public URL (Supabase public bucket pattern)
//                    $publicUrl = config('filesystems.disks.supabase.url') .
//                        "/storage/v1/object/public/" .
//                        config('filesystems.disks.supabase.bucket') .
//                        "/{$path}";
//
//                    // Store evidence metadata
//                    BullyingEvidence::create([
//                        'report_id' => $report->id,
//                        'file_path' => $path,
//                        'file_name' => $file->getClientOriginalName(),
//                        'public_url' => $publicUrl,
//                    ]);
//
//                } catch (\Exception $e) {
//                    Log::error('Supabase upload failed', [
//                        'student_id' => $this->student->id,
//                        'report_id' => $report->id,
//                        'filename' => $file->getClientOriginalName(),
//                        'error' => $e->getMessage()
//                    ]);
//
//                    // Continue with report creation even if evidence fails (don't block reporting)
//                    session()->flash('warning', 'Report created but some evidence files failed to upload. Please try again later.');
//                }
//            }
//        }
//
//        return redirect()->route('student.bullying-reports.show', $report)
//            ->with('success', 'Bullying report submitted successfully.');
//    }

    public function store(StoreBullyingReportRequest $request)
    {
        $validated = $request->validated();

        $report = BullyingReport::create([
            'student_id' => $this->student->id,
            'reporter_type' => $validated['reporter_type'],
            'title' => $validated['title'],
            'incident_date' => $validated['incident_date'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'status' => 'pending',
        ]);

        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                try {
                    $filename = Str::uuid() . '_' . $file->getClientOriginalName();
                    $path = "bullying-evidence/{$this->student->id}/{$report->id}/{$filename}";

                    // CRITICAL FIX: Use putFile() for proper MIME handling
                    $storedPath = Storage::disk('supabase')->putFile(
                        dirname($path),
                        $file,
                        'public' // Ensures correct ACL for public access
                    );

                    // CRITICAL FIX: Generate URL using Laravel's driver (handles encoding)
                    $publicUrl = Storage::disk('supabase')->url($storedPath);

                    BullyingEvidence::create([
                        'report_id' => $report->id,
                        'file_path' => $storedPath,
                        'file_name' => $file->getClientOriginalName(),
                        'public_url' => $publicUrl,
                    ]);

                } catch (\Exception $e) {
                    Log::error('Supabase upload failed', [
                        'student_id' => $this->student->id,
                        'report_id' => $report->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);

                    session()->flash('warning', 'Report created but some evidence files failed to upload. Please try again later.');
                }
            }
        }

        return redirect()->route('student.bullying-reports.show', $report)
            ->with('success', 'Bullying report submitted successfully.');
    }

    public function show(BullyingReport $bullyingReport)
    {
        if ($bullyingReport->student_id !== $this->student->id) {
            abort(403);
        }

        return view('student.bullying-reports.show', compact('bullyingReport'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuestionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\QuizImport;
use App\Exports\QuizFailedExport;
use App\Exports\QuizTemplateExport;

class QuizManagementController extends Controller
{
    /**
     * Display a listing of quizzes.
     */
    public function index(Request $request)
    {
        $quizzes = Quiz::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new quiz.
     */
    public function create()
    {
        return view('admin.quizzes.create');
    }

    /**
     * Store a newly created quiz.
     */
    public function store(Request $request)
    {
        // TODO: Implement store logic
        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz created successfully.');
    }

    /**
     * Display the specified quiz.
     */
    public function show(Quiz $quiz)
    {
        $quiz->load(['questions', 'literacyContents']);

        return view('admin.quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified quiz.
     */
    public function edit(Quiz $quiz)
    {
        return view('admin.quizzes.edit', compact('quiz'));
    }

    /**
     * Update the specified quiz.
     */
    public function update(Request $request, Quiz $quiz)
    {
        // TODO: Implement update logic
        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz updated successfully.');
    }

    /**
     * Remove the specified quiz.
     */
    public function destroy(Quiz $quiz)
    {
        // TODO: Implement delete logic
        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz deleted successfully.');
    }

    /**
     * Display upload form for bulk import.
     */
    public function showUploadForm()
    {
        return view('admin.quizzes.upload');
    }

    /**
     * Handle bulk upload via Excel.
     */
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'], // Max 10MB
        ], [
            'file.required' => 'Please select an Excel file to upload.',
            'file.mimes' => 'Only Excel files (.xlsx, .xls) and CSV files are allowed.',
            'file.max' => 'File size must not exceed 10MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Create a shared state holder
            $state = new \App\Imports\QuizImportState();
            $import = new QuizImport($state);

            Excel::import($import, $request->file('file'));

            DB::commit();

            if ($import->failures()->count() > 0) {
                // Store failures for download
                $failedRows = $import->failures()->toArray();
                $sessionId = 'failed_quiz_import_' . time();
                session()->put($sessionId, $failedRows);
                session()->put('failed_session_id', $sessionId);

                return redirect()->back()
                    ->with('success', "Successfully imported {$import->getSuccessCount()} records.")
                    ->with('warning', "{$import->failures()->count()} records failed validation.")
                    ->with('failed_count', $import->failures()->count())
                    ->with('failed_session_id', $sessionId);
            }

            return redirect()->route('admin.quizzes.index')
                ->with('success', "Successfully imported {$import->getSuccessCount()} quiz records.");

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Quiz bulk upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()
                ->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    /**
     * Download failed import report.
     */
    public function downloadFailedReport($sessionId)
    {
        $failedRows = session()->get('failed_quiz_import_' . $sessionId);

        if (!$failedRows) {
            return redirect()->back()
                ->with('error', 'No failed import report found.');
        }

        return Excel::download(
            new QuizFailedExport($failedRows),
            'failed_quiz_import_' . date('Y-m-d_His') . '.xlsx'
        );
    }

    /**
     * Download Excel template.
     */
    public function downloadTemplate()
    {
        return Excel::download(
            new QuizTemplateExport(),
            'quiz_template.xlsx'
        );
    }
}

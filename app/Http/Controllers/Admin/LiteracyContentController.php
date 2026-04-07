<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LiteracyContentFailedExport;
use App\Http\Controllers\Controller;
use App\Imports\LiteracyContentImport;
use App\Models\LiteracyContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class LiteracyContentController extends Controller
{

    /**
     * Display upload form for bulk import.
     */
    public function showUploadForm()
    {
        return view('admin.literacy-contents.upload');
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

            // Import the Excel file
            $import = new LiteracyContentImport();
            Excel::import($import, $request->file('file'));

            DB::commit();

            // Check for failures
            if ($import->failures()->count() > 0) {
                // Store failed rows for download
                $failedRows = $import->failures()->toArray();
                session()->put('failed_import_' . time(), $failedRows);

                return redirect()->back()
                    ->with('success', "Successfully imported {$import->getSuccessCount()} records.")
                    ->with('warning', "{$import->failures()->count()} records failed validation. You can download the error report.")
                    ->with('failed_count', $import->failures()->count());
            }

            return redirect()->route('admin.literacy-contents.index')
                ->with('success', "Successfully imported {$import->getSuccessCount()} literacy content records.");

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Literacy content bulk upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'admin_id' => auth()->guard('admin')->id(),
            ]);

            return redirect()->back()
                ->with('error', 'Upload failed. Please check the file format and try again. Error: ' . $e->getMessage());
        }
    }

    /**
     * Download failed import report.
     */
    public function downloadFailedReport($sessionId)
    {
        $failedRows = session()->get('failed_import_' . $sessionId);

        if (!$failedRows) {
            return redirect()->back()
                ->with('error', 'No failed import report found.');
        }

        return Excel::download(
            new LiteracyContentFailedExport($failedRows),
            'failed_import_' . date('Y-m-d_His') . '.xlsx'
        );
    }

    /**
     * Download Excel template.
     */
    public function downloadTemplate()
    {
        return Excel::download(
            new \App\Exports\LiteracyContentTemplateExport(),
            'literacy_content_template.xlsx'
        );
    }

    /**
     * Display a listing of literacy contents.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'type' => ['nullable', Rule::in(['all', 'article', 'video'])],
            'category' => ['nullable', 'string', 'max:255'],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $type = $validated['type'] ?? 'all';
        $search = $validated['search'] ?? '';
        $category = $validated['category'] ?? '';

        $query = LiteracyContent::query();

        if ($type !== 'all') {
            $query->where('type', $type);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                    ->orWhere('content', 'ilike', "%{$search}%")
                    ->orWhere('category', 'ilike', "%{$search}%");
            });
        }

        if ($category) {
            $query->where('category', 'ilike', "%{$category}%");
        }

        $contents = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get unique categories for filter
        $categories = LiteracyContent::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');

        $typeCounts = [
            'all' => LiteracyContent::count(),
            'article' => LiteracyContent::where('type', 'article')->count(),
            'video' => LiteracyContent::where('type', 'video')->count(),
        ];

        return view('admin.literacy-contents.index', compact(
            'contents',
            'type',
            'search',
            'category',
            'categories',
            'typeCounts'
        ));
    }

    /**
     * Show the form for creating a new literacy content.
     */
    public function create()
    {
        return view('admin.literacy-contents.create');
    }

    /**
     * Store a newly created literacy content.
     */
    public function store(Request $request)
    {
        // TODO: Implement store logic
        return redirect()->route('admin.literacy-contents.index')
            ->with('success', 'Literacy content created successfully.');
    }

    /**
     * Display the specified literacy content.
     */
    public function show(LiteracyContent $literacyContent)
    {
        return view('admin.literacy-contents.show', compact('literacyContent'));
    }

    /**
     * Show the form for editing the specified literacy content.
     */
    public function edit(LiteracyContent $literacyContent)
    {
        return view('admin.literacy-contents.edit', compact('literacyContent'));
    }

    /**
     * Update the specified literacy content.
     */
    public function update(Request $request, LiteracyContent $literacyContent)
    {
        // TODO: Implement update logic
        return redirect()->route('admin.literacy-contents.index')
            ->with('success', 'Literacy content updated successfully.');
    }

    /**
     * Remove the specified literacy content.
     */
    public function destroy(LiteracyContent $literacyContent)
    {
        // TODO: Implement delete logic
        return redirect()->route('admin.literacy-contents.index')
            ->with('success', 'Literacy content deleted successfully.');
    }
}

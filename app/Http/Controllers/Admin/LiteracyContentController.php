<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiteracyContent;
use Illuminate\Http\Request;

class LiteracyContentController extends Controller
{
    /**
     * Display a listing of literacy contents.
     */
    public function index(Request $request)
    {
        $type = $request->query('type', 'all');

        $query = LiteracyContent::query();

        if ($type !== 'all') {
            $query->where('type', $type);
        }

        $contents = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.literacy-contents.index', compact('contents', 'type'));
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

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
}

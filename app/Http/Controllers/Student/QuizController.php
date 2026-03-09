<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\StudentAnswer;
use App\Models\QuizResult;
use App\Models\PointTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        $quizzes = Quiz::withCount('questions')
            ->orderBy('created_at', 'desc')
            ->get();

        $takenQuizIds = QuizResult::where('student_id', $student->id)
            ->pluck('quiz_id')
            ->toArray();

        return view('student.quizzes.index', compact('quizzes', 'takenQuizIds'));
    }

    public function show(Quiz $quiz)
    {
        $student = Auth::guard('student')->user();

        // Check if student already took this quiz
        $taken = QuizResult::where('student_id', $student->id)
            ->where('quiz_id', $quiz->id)
            ->exists();

        // FIX 1: Always define $completedLiteracyIds to prevent undefined variable error
        $completedLiteracyIds = [];
        $allCompleted = true;

        // Optional: Load literacy contents if relationship exists (graceful degradation)
        try {
            // Only attempt if relationship method exists
            if (method_exists($quiz, 'literacyContents')) {
                $quiz->loadMissing('literacyContents');

                if ($quiz->literacyContents->count() > 0) {
                    // Only check completion if student model has literacyProgress relationship
                    if (method_exists($student, 'literacyProgress')) {
                        $completedLiteracyIds = $student->literacyProgress()
                            ->whereIn('literacy_content_id', $quiz->literacyContents->pluck('id'))
                            ->pluck('literacy_content_id')
                            ->toArray();

                        $allCompleted = count($completedLiteracyIds) === $quiz->literacyContents->count();
                    }
                }
            }
            $quiz->loadCount('questions');
        } catch (\Exception $e) {
            // Relationship doesn't exist in current schema - silently ignore
            $quiz->setRelation('literacyContents', collect());
        }

        return view('student.quizzes.show', compact('quiz', 'completedLiteracyIds', 'allCompleted', 'taken'));
    }

    public function start(Quiz $quiz)
    {
        $student = Auth::guard('student')->user();

        if (QuizResult::where('student_id', $student->id)->where('quiz_id', $quiz->id)->exists()) {
            return redirect()->route('student.quizzes.show', $quiz)
                ->with('error', 'You have already taken this quiz.');
        }

        // CRITICAL FIX: Store timestamp as INTEGER (Unix timestamp) to avoid serialization issues
        session([
            'quiz_attempt' => [
                'quiz_id' => $quiz->id,
                'started_at' => now()->getTimestamp(), // Integer timestamp
                'duration_minutes' => $quiz->duration_minutes ?? 10,
                'answers' => [],
                'current_question_index' => 0,
            ]
        ]);

        return redirect()->route('student.quizzes.take', $quiz);
    }

    public function take(Quiz $quiz)
    {
        $attempt = session('quiz_attempt');

        if (!$attempt || $attempt['quiz_id'] != $quiz->id) {
            return redirect()->route('student.quizzes.show', $quiz)
                ->with('error', 'No active quiz session. Please start again.');
        }

        $questions = $quiz->questions()->with('options')->orderBy('display_order')->get();
        $totalQuestions = $questions->count();

        // CRITICAL FIX: Use integer timestamp arithmetic (no Carbon serialization issues)
        $startedTimestamp = $attempt['started_at'];
        $elapsed = now()->getTimestamp() - $startedTimestamp;
        $totalSeconds = ($quiz->duration_minutes ?? 10) * 60;
        $remainingSeconds = max(0, $totalSeconds - $elapsed);

        // CRITICAL FIX: Ensure integer value before passing to view
        $remainingSeconds = (int) $remainingSeconds;

        if ($remainingSeconds <= 0) {
            return $this->submit($quiz);
        }

        $currentIndex = $attempt['current_question_index'];
        $currentQuestion = $questions[$currentIndex] ?? null;
        if (!$currentQuestion) {
            return redirect()->route('student.quizzes.result', $quiz);
        }

        $answers = $attempt['answers'];

        return view('student.quizzes.take', compact(
            'quiz', 'questions', 'currentQuestion', 'currentIndex',
            'totalQuestions', 'remainingSeconds', 'answers'
        ));
    }

    public function storeAnswer(Request $request, Quiz $quiz)
    {
        $request->validate([
            'question_id' => 'required|exists:quiz_questions,id',
            'option_id' => 'nullable|exists:question_options,id',
        ]);

        $attempt = session('quiz_attempt');
        if (!$attempt || $attempt['quiz_id'] != $quiz->id) {
            return response()->json(['error' => 'No active session'], 400);
        }

        // Store answer
        $attempt['answers'][$request->question_id] = $request->option_id;
        session(['quiz_attempt' => $attempt]);

        return response()->json(['success' => true]);
    }

    public function navigate(Request $request, Quiz $quiz)
    {
        $request->validate(['direction' => 'required|in:next,prev']);
        $attempt = session('quiz_attempt');
        if (!$attempt || $attempt['quiz_id'] != $quiz->id) {
            return redirect()->route('student.quizzes.show', $quiz);
        }

        $questions = $quiz->questions()->count();
        $newIndex = $attempt['current_question_index'] + ($request->direction === 'next' ? 1 : -1);

        if ($newIndex >= 0 && $newIndex < $questions) {
            $attempt['current_question_index'] = $newIndex;
            session(['quiz_attempt' => $attempt]);
        }

        return redirect()->route('student.quizzes.take', $quiz);
    }

    public function submit(Quiz $quiz)
    {
        $student = Auth::guard('student')->user();
        $attempt = session('quiz_attempt');
        $pointsEarned = 0;

        if (!$attempt || $attempt['quiz_id'] != $quiz->id) {
            return redirect()->route('student.quizzes.show', $quiz)
                ->with('error', 'Quiz session expired.');
        }

        $questions = $quiz->questions()->with('options')->get();
        $totalQuestions = $questions->count();
        $score = 0;

        DB::transaction(function () use ($student, $quiz, $questions, $attempt, &$score, $totalQuestions) {
            foreach ($questions as $question) {
                $selectedOptionId = $attempt['answers'][$question->id] ?? null;
                $isCorrect = false;

                if ($selectedOptionId) {
                    $option = $question->options->firstWhere('id', $selectedOptionId);
                    $isCorrect = $option ? $option->is_correct : false;
                    if ($isCorrect) $score++;
                }

                // CRITICAL FIX: Handle unanswered questions safely
                // Only store if we have an answer OR if column is nullable (migration required)
                try {
                    StudentAnswer::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'question_id' => $question->id,
                        ],
                        [
                            'selected_option_id' => $selectedOptionId, // NULL allowed after migration
                            'is_correct' => $isCorrect,
                        ]
                    );
                } catch (\Exception $e) {
                    // Temporary workaround until migration is applied
                    if (str_contains($e->getMessage(), 'null value') && !$selectedOptionId) {
                        continue; // Skip unanswered questions
                    }
                    throw $e;
                }
            }

            // CRITICAL FIX: Points = correct answers × points_per_quiz
            $pointsPerQuestion = $quiz->points_per_quiz ?? 10;
            $pointsEarned = $pointsPerQuestion * $score;

            QuizResult::create([
                'student_id' => $student->id,
                'quiz_id' => $quiz->id,
                'score' => $score,
                'total_questions' => $totalQuestions,
                'points_earned' => $pointsEarned,
            ]);

            if ($pointsEarned > 0) {
                $student->increment('total_points', $pointsEarned);
                PointTransaction::create([
                    'student_id' => $student->id,
                    'source' => 'quiz',
                    'source_id' => $quiz->id,
                    'points' => $pointsEarned,
                    'description' => "Earned {$pointsEarned} points for {$score} correct answers in quiz: {$quiz->title}",
                ]);
            }
        });

        session()->forget('quiz_attempt');

        return redirect()->route('student.quizzes.result', $quiz)
            ->with('success', "Quiz submitted! You scored {$score} out of {$totalQuestions} and earned {$pointsEarned} points.");
    }

    public function result(Quiz $quiz)
    {
        $student = Auth::guard('student')->user();
        $result = QuizResult::where('student_id', $student->id)
            ->where('quiz_id', $quiz->id)
            ->firstOrFail();

        return view('student.quizzes.result', compact('quiz', 'result'));
    }
}

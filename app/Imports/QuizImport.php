<?php

namespace App\Imports;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuestionOption;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Str;
use Throwable;

class QuizImport implements
    ToCollection,
    WithMultipleSheets,
    WithHeadingRow,
    WithValidation,
    WithLimit,
    SkipsEmptyRows,
    SkipsOnFailure,
    SkipsOnError,
    WithEvents
{
    protected QuizImportState $state;
    protected string $currentSheet = 'Quizzes';

    public function __construct(QuizImportState $state = null)
    {
        $this->state = $state ?? new QuizImportState();
    }

    public function limit(): int
    {
        return 500;
    }

    public function sheets(): array
    {
        // Exact sheet names as in your Excel file
        return [
            'Quizzes'   => new self($this->state),
            'Questions' => new self($this->state),
            'Options'   => new self($this->state),
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $this->currentSheet = $event->getSheet()->getTitle();
            },
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        switch ($this->currentSheet) {
            case 'Quizzes':
                return [
                    'quiz_title' => ['required', 'string', 'max:255'],
                    'description' => ['nullable', 'string'],
                    'points_per_quiz' => ['required', 'integer', 'min:1', 'max:100'],
                    'start_date' => ['nullable', 'date_format:Y-m-d H:i'],
                    'end_date' => ['nullable', 'date_format:Y-m-d H:i'],
                    'duration_minutes' => ['nullable', 'integer', 'min:1', 'max:180'],
                    'category' => ['nullable', 'string', 'max:255'],
                ];
            case 'Questions':
                return [
                    'quiz_title' => ['required', 'string', 'max:255'],
                    'question_text' => ['required', 'string', 'max:1000'],
                    'question_type' => ['required', 'in:multiple_choice,true_false,short_answer'],
                    'display_order' => ['required', 'integer', 'min:1'],
                ];
            case 'Options':
                return [
                    'quiz_title' => ['required', 'string', 'max:255'],
                    'question_text' => ['required', 'string', 'max:1000'],
                    'option_text' => ['required', 'string', 'max:500'],
                    'is_correct' => ['required', 'in:Yes,No'],
                    'display_order' => ['required', 'integer', 'min:1'],
                ];
            default:
                return [];
        }
    }
    /**
     * Custom validation messages.
     */
    public function customValidationMessages()
    {
        return [
            'quiz_title.required' => 'Quiz Title is required',
            'quiz_title.max' => 'Quiz Title cannot exceed 255 characters',
            'points_per_quiz.required' => 'Points Per Quiz is required',
            'points_per_quiz.integer' => 'Points Per Quiz must be a number',
            'points_per_quiz.min' => 'Points Per Quiz must be at least 1',
            'points_per_quiz.max' => 'Points Per Quiz cannot exceed 100',
            'start_date.date_format' => 'Start Date must be in YYYY-MM-DD HH:MM format',
            'end_date.date_format' => 'End Date must be in YYYY-MM-DD HH:MM format',
            'duration_minutes.integer' => 'Duration must be a number',
            'duration_minutes.min' => 'Duration must be at least 1 minute',
            'duration_minutes.max' => 'Duration cannot exceed 180 minutes',
            'question_type.required' => 'Question Type is required',
            'question_type.in' => 'Question Type must be one of: multiple_choice, true_false, short_answer',
            'question_text.required' => 'Question Text is required',
            'question_text.max' => 'Question Text cannot exceed 1000 characters',
            'option_text.required' => 'Option Text is required',
            'option_text.max' => 'Option Text cannot exceed 500 characters',
            'is_correct.required' => 'Is Correct is required',
            'is_correct.in' => 'Is Correct must be either "Yes" or "No"',
            'display_order.required' => 'Display Order is required',
            'display_order.integer' => 'Display Order must be a number',
            'display_order.min' => 'Display Order must be at least 1',
        ];
    }
    public function collection(Collection $rows)
    {
        switch ($this->currentSheet) {
            case 'Quizzes':
                $this->processQuizzesSheet($rows);
                break;
            case 'Questions':
                $this->processQuestionsSheet($rows);
                break;
            case 'Options':
                $this->processOptionsSheet($rows);
                break;
        }
    }

    protected function processQuizzesSheet(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            try {
                $exists = Quiz::where('title', $row['quiz_title'])->exists();
                if ($exists) {
                    $this->state->failures[] = [
                        'sheet' => 'Quizzes',
                        'row' => $index + 2,
                        'errors' => ['Duplicate quiz title: "' . $row['quiz_title'] . '" already exists'],
                        'data' => $row->toArray(),
                    ];
                    continue;
                }

                $points = (int)($row['points_per_quiz'] ?? 10);
                if ($points < 1 || $points > 100) {
                    $this->state->failures[] = [
                        'sheet' => 'Quizzes',
                        'row' => $index + 2,
                        'errors' => ['Points Per Quiz must be between 1 and 100'],
                        'data' => $row->toArray(),
                    ];
                    continue;
                }

                $quiz = Quiz::create([
                    'title' => trim($row['quiz_title']),
                    'description' => $row['description'] ?? null,
                    'points_per_quiz' => $points,
                    'start_date' => !empty($row['start_date']) ? date('Y-m-d H:i:s', strtotime($row['start_date'])) : null,
                    'end_date' => !empty($row['end_date']) ? date('Y-m-d H:i:s', strtotime($row['end_date'])) : null,
                    'duration_minutes' => $row['duration_minutes'] ?? null,
                    'category' => $row['category'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->state->quizzes[$row['quiz_title']] = $quiz;
                $this->state->successCount++;
            } catch (\Exception $e) {
                $this->state->failures[] = [
                    'sheet' => 'Quizzes',
                    'row' => $index + 2,
                    'errors' => [$e->getMessage()],
                    'data' => $row->toArray(),
                ];
            }
        }
    }

    protected function processQuestionsSheet(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            try {
                // FIX: use $this->state->quizzes
                if (!isset($this->state->quizzes[$row['quiz_title']])) {
                    $this->state->failures[] = [
                        'sheet' => 'Questions',
                        'row' => $index + 2,
                        'errors' => ['Quiz "' . $row['quiz_title'] . '" not found in Quizzes sheet'],
                        'data' => $row->toArray(),
                    ];
                    continue;
                }

                $questionType = strtolower($row['question_type'] ?? 'multiple_choice');
                if (!in_array($questionType, ['multiple_choice', 'true_false', 'short_answer'])) {
                    $this->state->failures[] = [
                        'sheet' => 'Questions',
                        'row' => $index + 2,
                        'errors' => ['Question Type must be one of: multiple_choice, true_false, short_answer'],
                        'data' => $row->toArray(),
                    ];
                    continue;
                }

                $displayOrder = (int)($row['display_order'] ?? 1);
                if ($displayOrder < 1) {
                    $this->state->failures[] = [
                        'sheet' => 'Questions',
                        'row' => $index + 2,
                        'errors' => ['Display Order must be at least 1'],
                        'data' => $row->toArray(),
                    ];
                    continue;
                }

                $question = QuizQuestion::create([
                    'quiz_id' => $this->state->quizzes[$row['quiz_title']]->id,
                    'question_text' => trim($row['question_text']),
                    'question_type' => $questionType,
                    'display_order' => $displayOrder,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $key = $row['quiz_title'] . '|' . $row['question_text'];
                $this->state->questions[$key] = $question;
                $this->state->successCount++;
            } catch (\Exception $e) {
                $this->state->failures[] = [
                    'sheet' => 'Questions',
                    'row' => $index + 2,
                    'errors' => [$e->getMessage()],
                    'data' => $row->toArray(),
                ];
            }
        }
    }

    protected function processOptionsSheet(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            try {
                $questionKey = $row['quiz_title'] . '|' . $row['question_text'];
                if (!isset($this->state->questions[$questionKey])) {
                    $this->state->failures[] = [
                        'sheet' => 'Options',
                        'row' => $index + 2,
                        'errors' => ['Question "' . $row['question_text'] . '" not found in Questions sheet'],
                        'data' => $row->toArray(),
                    ];
                    continue;
                }

                $isCorrect = strtolower($row['is_correct'] ?? 'no');
                if (!in_array($isCorrect, ['yes', 'no'])) {
                    $this->state->failures[] = [
                        'sheet' => 'Options',
                        'row' => $index + 2,
                        'errors' => ['Is Correct must be either "Yes" or "No"'],
                        'data' => $row->toArray(),
                    ];
                    continue;
                }

                $displayOrder = (int)($row['display_order'] ?? 1);
                if ($displayOrder < 1) {
                    $this->state->failures[] = [
                        'sheet' => 'Options',
                        'row' => $index + 2,
                        'errors' => ['Display Order must be at least 1'],
                        'data' => $row->toArray(),
                    ];
                    continue;
                }

                QuestionOption::create([
                    'question_id' => $this->state->questions[$questionKey]->id,
                    'option_text' => trim($row['option_text']),
                    'is_correct' => $isCorrect === 'yes',
                    'display_order' => $displayOrder,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->state->successCount++;
            } catch (\Exception $e) {
                $this->state->failures[] = [
                    'sheet' => 'Options',
                    'row' => $index + 2,
                    'errors' => [$e->getMessage()],
                    'data' => $row->toArray(),
                ];
            }
        }
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->state->failures[] = [
                'sheet' => $this->currentSheet,
                'row' => $failure->row(),
                'errors' => $failure->errors(),
                'data' => $failure->values(),
            ];
        }
    }

    public function getSuccessCount(): int
    {
        return $this->state->successCount;
    }

    public function failures(): \Illuminate\Support\Collection
    {
        return collect($this->state->failures);
    }

    public function onError(Throwable $e)
    {
        $this->state->failures[] = [
            'sheet' => $this->currentSheet,
            'row' => null,
            'errors' => [$e->getMessage()],
            'data' => [],
        ];
    }
}

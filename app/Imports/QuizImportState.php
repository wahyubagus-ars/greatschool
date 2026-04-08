<?php

namespace App\Imports;

class QuizImportState
{
    public array $quizzes = [];
    public array $questions = [];
    public int $successCount = 0;
    public array $failures = [];
}

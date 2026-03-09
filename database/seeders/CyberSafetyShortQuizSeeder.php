<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CyberSafetyShortQuizSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create a Short Quiz
        $quizId = DB::table('quizzes')->insertGetId([
            'title' => 'Quick Check: Digital Safety',
            'description' => 'A 3-minute check on your digital footprint and reporting skills.',
            'points_per_quiz' => 15,
            'category' => 'cyber-safety',
            'duration_minutes' => 3,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addWeeks(2),
            'created_at' => Carbon::now(),
        ]);

        // 2. Link to the TikTok Literacy Content (ID 5)
        DB::table('quiz_literacy_contents')->insert([
            ['quiz_id' => $quizId, 'literacy_content_id' => 5, 'created_at' => Carbon::now()],
        ]);

        // 3. Define 3 Questions
        $questions = [
            [
                'text' => 'What should you do if someone keeps sending you mean messages on social media?',
                'options' => [
                    ['text' => 'Reply with an even meaner message', 'correct' => false],
                    ['text' => 'Block them and report the account', 'correct' => true],
                    ['text' => 'Share your password with a friend for help', 'correct' => false],
                ]
            ],
            [
                'text' => 'Is it okay to share a private photo of a classmate without their permission?',
                'options' => [
                    ['text' => 'Yes, if it is just a joke', 'correct' => false],
                    ['text' => 'Yes, if they are your best friend', 'correct' => false],
                    ['text' => 'No, this is a violation of privacy and digital ethics', 'correct' => true],
                ]
            ],
            [
                'text' => 'Which feature on most apps helps you stop seeing content from a specific person?',
                'options' => [
                    ['text' => 'The "Like" button', 'correct' => false],
                    ['text' => 'The "Block" feature', 'correct' => true],
                    ['text' => 'The "Comment" section', 'correct' => false],
                ]
            ],
        ];

        // 4. Insert Questions and Options
        foreach ($questions as $index => $qData) {
            $questionId = DB::table('quiz_questions')->insertGetId([
                'quiz_id' => $quizId,
                'question_text' => $qData['text'],
                'question_type' => 'multiple_choice',
                'display_order' => $index + 1,
                'created_at' => Carbon::now(),
            ]);

            foreach ($qData['options'] as $optIndex => $oData) {
                DB::table('question_options')->insert([
                    'question_id' => $questionId,
                    'option_text' => $oData['text'],
                    'is_correct' => $oData['correct'],
                    'display_order' => $optIndex + 1,
                    'created_at' => Carbon::now(),
                ]);
            }
        }
    }
}

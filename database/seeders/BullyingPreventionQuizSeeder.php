<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BullyingPreventionQuizSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create the Quiz
        $quizId = DB::table('quizzes')->insertGetId([
            'title' => 'Anti-Bullying & Cyber Safety Essentials',
            'description' => 'Test your knowledge on how to handle physical and digital bullying based on the provided videos.',
            'points_per_quiz' => 50,
            'category' => 'anti-bullying',
            'duration_minutes' => 15,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addMonths(1),
            'created_at' => Carbon::now(),
        ]);

        // 2. Link to existing Literature Content (ID 4 and 5)
        DB::table('quiz_literacy_contents')->insert([
            ['quiz_id' => $quizId, 'literacy_content_id' => 4, 'created_at' => Carbon::now()],
            ['quiz_id' => $quizId, 'literacy_content_id' => 5, 'created_at' => Carbon::now()],
        ]);

        // 3. Define 10 Questions and Options
        $questions = [
            [
                'text' => 'According to Brooks Gibbs, what is the "dominant" way to stop a bully?',
                'options' => [
                    ['text' => 'Getting angry and fighting back', 'correct' => false],
                    ['text' => 'Remaining calm and not letting them upset you', 'correct' => true],
                    ['text' => 'Reporting them immediately to the principal', 'correct' => false],
                    ['text' => 'Ignoring them completely', 'correct' => false],
                ]
            ],
            [
                'text' => 'If a bully calls you a name, a resilient response would be:',
                'options' => [
                    ['text' => '"That’s not nice!"', 'correct' => false],
                    ['text' => '"You’re right, I am that, thanks for noticing!"', 'correct' => true],
                    ['text' => 'Staying silent and crying', 'correct' => false],
                    ['text' => 'Insulting them back twice as hard', 'correct' => false],
                ]
            ],
            [
                'text' => 'What is the first step you should take when experiencing cyberbullying?',
                'options' => [
                    ['text' => 'Delete your entire social media account', 'correct' => false],
                    ['text' => 'Argue with the person in the comments', 'correct' => false],
                    ['text' => 'Screen capture evidence and block the user', 'correct' => true],
                    ['text' => 'Post about them on your story', 'correct' => false],
                ]
            ],
            [
                'text' => 'Why is "getting upset" exactly what a bully wants?',
                'options' => [
                    ['text' => 'It gives them a sense of power and fun', 'correct' => true],
                    ['text' => 'It makes them feel sorry for you', 'correct' => false],
                    ['text' => 'It helps resolve the conflict', 'correct' => false],
                    ['text' => 'It shows you are a strong person', 'correct' => false],
                ]
            ],
            [
                'text' => 'On platforms like TikTok, what feature helps stop malicious users?',
                'options' => [
                    ['text' => 'Buying more followers', 'correct' => false],
                    ['text' => 'Using the "Report" and "Block" tools', 'correct' => true],
                    ['text' => 'Changing your profile picture', 'correct' => false],
                    ['text' => 'Liking their videos', 'correct' => false],
                ]
            ],
            [
                'text' => 'What is "Resilience" in the context of bullying?',
                'options' => [
                    ['text' => 'The ability to hide your feelings', 'correct' => false],
                    ['text' => 'The ability to recover quickly from difficult situations', 'correct' => true],
                    ['text' => 'Being physically stronger than the bully', 'correct' => false],
                    ['text' => 'Never going to school again', 'correct' => false],
                ]
            ],
            [
                'text' => 'What should a witness (bystander) do when they see bullying?',
                'options' => [
                    ['text' => 'Record it for entertainment', 'correct' => false],
                    ['text' => 'Join in to stay safe', 'correct' => false],
                    ['text' => 'Support the victim and report the incident', 'correct' => true],
                    ['text' => 'Pretend they didn’t see anything', 'correct' => false],
                ]
            ],
            [
                'text' => 'Which of these is a form of cyberbullying?',
                'options' => [
                    ['text' => 'Sending a friendly message', 'correct' => false],
                    ['text' => 'Spreading rumors about someone online', 'correct' => true],
                    ['text' => 'Sharing a funny cat video', 'correct' => false],
                    ['text' => 'Liking a friend’s photo', 'correct' => false],
                ]
            ],
            [
                'text' => 'Brooks Gibbs compares bullying to a "game." How do you win?',
                'options' => [
                    ['text' => 'By being the loudest person', 'correct' => false],
                    ['text' => 'By refusing to play (not reacting)', 'correct' => true],
                    ['text' => 'By getting the most people on your side', 'correct' => false],
                    ['text' => 'By telling a teacher immediately', 'correct' => false],
                ]
            ],
            [
                'text' => 'What is the long-term goal of anti-bullying education?',
                'options' => [
                    ['text' => 'To punish every student', 'correct' => false],
                    ['text' => 'To make everyone exactly the same', 'correct' => false],
                    ['text' => 'To create a safe and respectful school environment', 'correct' => true],
                    ['text' => 'To stop students from using the internet', 'correct' => false],
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

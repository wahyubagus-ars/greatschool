<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studentId = 1; // John Doe
        $literacyIds = [4, 5]; // The two video contents provided

        foreach ($literacyIds as $id) {
            // updateOrInsert prevents duplicate key errors if you run the seeder twice
            DB::table('student_literacy_progress')->updateOrInsert(
                [
                    'student_id' => $studentId,
                    'literacy_content_id' => $id
                ],
                [
                    'viewed_at' => Carbon::now()->subMinutes(rand(10, 60)),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}

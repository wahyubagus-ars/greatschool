<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::create([
            'nis' => '123456',
            'password_hash' => Hash::make('student123'),
            'full_name' => 'John Doe',
            'email' => 'john@student.com',
            'phone_number' => '08123456789',
            'total_points' => 0,
        ]);

        Student::create([
            'nis' => '789012',
            'password_hash' => Hash::make('student456'),
            'full_name' => 'Jane Smith',
            'email' => 'jane@student.com',
            'phone_number' => '08987654321',
            'total_points' => 50,
        ]);
    }
}

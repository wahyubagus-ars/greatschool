<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admins')->truncate();

        DB::table('admins')->insert([
            [
                'id' => 1,
                'username' => 'admin',
                'password_hash' => Hash::make('password'),
                'full_name' => 'System Administrator',
                'email' => 'admin@school.edu',
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'username' => 'superadmin',
                'password_hash' => Hash::make('superpassword'),
                'full_name' => 'Super Administrator',
                'email' => 'superadmin@school.edu',
                'created_at' => now(),
            ],
        ]);
    }
}

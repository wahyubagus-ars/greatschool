<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        $activities = $student->recentActivities; // Uses accessor from model

        return view('student.dashboard', compact('student', 'activities'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentManagementController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(Request $request)
    {
        $search = $request->query('search', '');

        $query = Student::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('full_name', 'asc')->paginate(15);

        return view('admin.students.index', compact('students', 'search'));
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        $student->load(['bullyingReports', 'facilityReports', 'quizResults']);

        return view('admin.students.show', compact('student'));
    }
}

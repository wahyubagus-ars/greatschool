<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StudentLoginController extends Controller
{
    public function showLoginForm()
    {
        // CRITICAL FIX: Redirect authenticated students to dashboard instead of showing login form
        if (Auth::guard('student')->check()) {
            return redirect()->route('student.dashboard');
        }

        return view('auth.student-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nis' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('student')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            // CRITICAL FIX: Use route name instead of hardcoded path for proper redirect
            return redirect()->intended(route('student.dashboard'));
        }

        throw ValidationException::withMessages([
            'nis' => __('auth.failed'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('student.login')->with('success', 'You have been logged out successfully.');
    }
}

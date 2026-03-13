<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        // DO NOT manipulate session here - preserves CSRF token
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'username.required' => 'Username is required',
            'username.max' => 'Username cannot exceed 50 characters',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
        ]);

        $this->handleRateLimiting($request);

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::clear($this->throttleKey($request));

            // Regenerate session AFTER successful authentication
            $request->session()->regenerate();

            $this->logAdminLogin(Auth::guard('admin')->user(), $request);

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back, ' . Auth::guard('admin')->user()->full_name);
        }

        RateLimiter::hit($this->throttleKey($request), 900);

        throw ValidationException::withMessages([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin) {
            $this->logAdminLogout($admin, $request);
        }

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'You have been successfully logged out.');
    }

    private function handleRateLimiting(Request $request): void
    {
        $key = $this->throttleKey($request);
        $maxAttempts = 5;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'username' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }
    }

    private function throttleKey(Request $request): string
    {
        return 'admin_login_' . $request->ip() . '|' . $request->input('username');
    }

    private function logAdminLogin($admin, Request $request): void
    {
        \Log::channel('admin_audit')->info('Admin login successful', [
            'admin_id' => $admin->id,
            'username' => $admin->username,
            'full_name' => $admin->full_name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    private function logAdminLogout($admin, Request $request): void
    {
        \Log::channel('admin_audit')->info('Admin logout', [
            'admin_id' => $admin->id,
            'username' => $admin->username,
            'ip_address' => $request->ip(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
}

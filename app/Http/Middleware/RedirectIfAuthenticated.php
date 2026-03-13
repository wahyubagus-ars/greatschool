<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            try {
                // Only check if guard is specified and user is authenticated
                if ($guard && Auth::hasGuard($guard)) {
                    if (Auth::guard($guard)->check()) {
                        if ($guard === 'student') {
                            return redirect()->route('student.dashboard');
                        } elseif ($guard === 'admin') {
                            return redirect()->route('admin.dashboard');
                        }
                        return redirect('/home');
                    }
                } elseif ($guard === null && Auth::check()) {
                    return redirect('/home');
                }
            } catch (\Exception $e) {
                // DO NOT flush session - this destroys CSRF token!
                // Just log the error and continue to login page
                \Log::warning('Auth check failed for guard: ' . ($guard ?? 'null'), [
                    'error' => $e->getMessage(),
                    'ip' => $request->ip(),
                ]);
                continue;
            }
        }

        return $next($request);
    }
}

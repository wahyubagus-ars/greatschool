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
            // CRITICAL: Handle student guard specifically
            if (Auth::guard($guard)->check()) {
                if ($guard === 'student') {
                    return redirect()->route('student.dashboard');
                }
                return redirect('/home');
            }
        }

        return $next($request);
    }

}

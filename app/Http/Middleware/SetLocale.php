<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('SetLocale middleware ran', [
            'has_session_locale' => Session::has('locale'),
            'session_locale' => Session::get('locale'),
            'current_app_locale_before' => App::getLocale(),
        ]);
        // Check if the user has a 'locale' saved in their session
        if (Session::has('locale')) {
            $locale = Session::get('locale');

            // Set both the application locale and the fallback locale
            App::setLocale($locale);
        }

        return $next($request);
    }
}

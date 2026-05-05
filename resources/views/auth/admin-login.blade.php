<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Admin Login') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-200 flex items-center justify-center p-4">
<div class="w-full max-w-md">

    <!-- Language Switcher -->
    <div class="flex justify-end mb-4 space-x-2 text-xs font-semibold uppercase tracking-wider">
        <a href="{{ route('lang.switch', 'en') }}"
           class="{{ app()->getLocale() == 'en' ? 'text-slate-800 border-b-2 border-slate-800' : 'text-slate-400 hover:text-slate-600' }}">
            EN
        </a>
        <span class="text-slate-300">|</span>
        <a href="{{ route('lang.switch', 'id') }}"
           class="{{ app()->getLocale() == 'id' ? 'text-slate-800 border-b-2 border-slate-800' : 'text-slate-400 hover:text-slate-600' }}">
            ID
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <!-- Header -->
        <div class="px-8 pt-8 pb-6 text-center border-b border-gray-100">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-slate-700 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">{{ __('Admin Portal') }}</h1>
            <p class="text-gray-500 mt-1">{{ __('Sign in to manage school operations') }}</p>
        </div>

        <!-- Form Section -->
        <div class="p-8">
            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-6">
            @csrf

            <!-- Username Field -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Username') }}</label>
                    <div class="relative">
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required autofocus
                               class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-all duration-200"
                               placeholder="{{ __('Enter your username') }}">
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Password') }}</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                               class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-all duration-200"
                               placeholder="{{ __('Enter your password') }}">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-slate-600 rounded border-gray-300">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">{{ __('Remember me on this device') }}</label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full bg-slate-700 hover:bg-slate-800 text-white font-medium py-3 px-4 rounded-lg transition-all duration-200 shadow-md">
                        {{ __('Sign In to Admin Portal') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Security Notice -->
        <div class="px-8 py-4 bg-amber-50 border-t border-amber-100">
            <div class="flex items-start">
                <p class="text-xs text-amber-800">
                    <strong>{{ __('Security Notice:') }}</strong> {{ __('This system is for authorized personnel only. All login attempts are monitored and logged.') }}
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-600">
                {{ __('Need help? Contact') }}
                <a href="mailto:it-support@school.edu" class="font-medium text-slate-600 hover:text-slate-500">
                    {{ __('IT Support') }}
                </a>
            </p>
        </div>
    </div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-200 flex items-center justify-center p-4">
<div class="w-full max-w-md">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <!-- Header -->
        <div class="px-8 pt-8 pb-6 text-center border-b border-gray-100">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 text-slate-700 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Admin Portal</h1>
            <p class="text-gray-500 mt-1">Sign in to manage school operations</p>
        </div>

        @if(session('success'))
            <div class="mb-6 mx-8 bg-green-50 text-green-700 px-4 py-3 rounded-lg text-sm border border-green-200">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 mx-8 bg-red-50 text-red-700 px-4 py-3 rounded-lg text-sm border border-red-200">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    {{ $errors->first() }}
                </div>
            </div>
    @endif

    <!-- Form -->
        <div class="p-8">
            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-6">
            @csrf

            <!-- Username Field -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1.5">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <input type="text"
                               name="username"
                               id="username"
                               value="{{ old('username') }}"
                               required
                               autofocus
                               autocomplete="username"
                               class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm hover:border-gray-400 @error('username') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                               placeholder="Enter your username">
                    </div>
                    @error('username')
                    <p class="mt-1 text-sm text-red-600 font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <input type="password"
                               name="password"
                               id="password"
                               required
                               autocomplete="current-password"
                               class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm hover:border-gray-400 @error('password') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                               placeholder="Enter your password">
                    </div>
                    @error('password')
                    <p class="mt-1 text-sm text-red-600 font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox"
                           name="remember"
                           id="remember"
                           class="h-4 w-4 text-slate-600 rounded focus:ring-slate-500 border-gray-300">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me on this device</label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                            class="w-full bg-slate-700 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 text-white font-medium py-3 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                        Sign In to Admin Portal
                    </button>
                </div>
            </form>
        </div>

        <!-- Security Notice -->
        <div class="px-8 py-4 bg-amber-50 border-t border-amber-100">
            <div class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-amber-600 mr-2 flex-shrink-0 mt-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                <p class="text-xs text-amber-800">
                    <strong>Security Notice:</strong> This system is for authorized personnel only. All login attempts are monitored and logged.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-600">
                Need help? Contact
                <a href="mailto:it-support@school.edu" class="font-medium text-slate-600 hover:text-slate-500 transition-colors">
                    IT Support
                </a>
            </p>
        </div>
    </div>

    <!-- System Status -->
    <div class="mt-6 text-center text-xs text-gray-500">
        <p>Laravel v{{ app()->version() }} • Secure Admin Connection • IP: {{ request()->ip() }}</p>
    </div>
</div>

<script>
    // Prevent form resubmission on refresh
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    // Clear password field on page load (security)
    document.addEventListener('DOMContentLoaded', function() {
        const passwordField = document.getElementById('password');
        if (passwordField) {
            passwordField.value = '';
        }
    });
</script>
</body>
</html>

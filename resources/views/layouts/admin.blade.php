<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('Admin Dashboard')) - {{ __('Admin Portal') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Prevent x-cloak flashes --}}
    <style>[x-cloak] { display: none !important; }</style>
</head>

<body
    x-data="{ sidebarOpen: false }"
    x-effect="document.body.classList.toggle('overflow-hidden', sidebarOpen)"
    class="bg-gray-50 font-sans antialiased min-h-screen flex flex-col"
>
<!-- MOBILE HEADER (hamburger only visible on small screens) -->
<header class="md:hidden bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="flex items-center justify-between px-4 py-3">
        <button
            @click="sidebarOpen = true"
            :aria-expanded="sidebarOpen"
            aria-controls="sidebar"
            aria-label="Open navigation menu"
            class="p-2 -ml-2 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>

        <h1 class="text-xl font-bold text-slate-700 truncate">{{ __('Admin Portal') }}</h1>

        <div class="w-9 h-9 rounded-full bg-slate-200 flex items-center justify-center text-slate-700 font-medium text-sm">
            {{ strtoupper(substr(Auth::guard('admin')->user()->full_name, 0, 1)) }}
        </div>
    </div>
</header>

<!-- LAYOUT WRAPPER -->
<div class="flex flex-1 overflow-hidden">

    <!-- SIDEBAR -->
    <aside
        id="sidebar"
        x-cloak
        :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }"
        class="fixed inset-y-0 left-0 z-50 w-64 max-w-[85vw] bg-white shadow-xl transform transition-transform duration-300 ease-in-out md:static md:translate-x-0 md:shadow-none md:border-r md:border-gray-200 flex flex-col"
        role="navigation"
        aria-label="Main navigation"
    >
        <!-- Logo & User -->
        <div class="p-5 border-b border-gray-200">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-7 h-7 text-slate-700 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                </svg>
                <h2 class="text-2xl font-bold text-slate-700">{{ __('Admin Portal') }}</h2>
            </div>
            <p class="text-sm text-gray-600 mt-2 truncate">{{ Auth::guard('admin')->user()->full_name }}</p>
            <p class="text-xs text-gray-400 mt-0.5">{{ Auth::guard('admin')->user()->username }}</p>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4 px-2">
            <a href="{{ route('admin.dashboard') }}"
               class="group flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-slate-50 hover:text-slate-700 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-slate-50 text-slate-700 font-medium' : '' }}"
               @click="sidebarOpen = false"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 mr-3 flex-shrink-0 text-gray-400 group-hover:text-slate-600 transition-colors" :class="request()->routeIs('admin.dashboard') ? 'text-slate-600' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span class="font-medium">{{ __('Dashboard') }}</span>
            </a>

            <a href="{{ route('admin.bullying-reports.index') }}"
               class="group flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-slate-50 hover:text-slate-700 transition-colors {{ request()->routeIs('admin.bullying-reports.*') ? 'bg-slate-50 text-slate-700 font-medium' : '' }}"
               @click="sidebarOpen = false"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 mr-3 flex-shrink-0 text-gray-400 group-hover:text-slate-600 transition-colors" :class="request()->routeIs('admin.bullying-reports.*') ? 'text-slate-600' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                <span class="font-medium">{{ __('Bullying Reports') }}</span>
                @if($pendingBullyingReports > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingBullyingReports }}</span>
                @endif
            </a>

            <a href="{{ route('admin.literacy-contents.index') }}"
               class="group flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-slate-50 hover:text-slate-700 transition-colors {{ request()->routeIs('admin.literacy-contents.*') ? 'bg-slate-50 text-slate-700 font-medium' : '' }}"
               @click="sidebarOpen = false"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 mr-3 flex-shrink-0 text-gray-400 group-hover:text-slate-600 transition-colors" :class="request()->routeIs('admin.literacy-contents.*') ? 'text-slate-600' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                <span class="font-medium">{{ __('Literacy Content') }}</span>
            </a>

            <a href="{{ route('admin.quizzes.index') }}"
               class="group flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-slate-50 hover:text-slate-700 transition-colors {{ request()->routeIs('admin.quizzes.*') ? 'bg-slate-50 text-slate-700 font-medium' : '' }}"
               @click="sidebarOpen = false"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 mr-3 flex-shrink-0 text-gray-400 group-hover:text-slate-600 transition-colors" :class="request()->routeIs('admin.quizzes.*') ? 'text-slate-600' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                </svg>
                <span class="font-medium">{{ __('Quizzes') }}</span>
            </a>

            <a href="{{ route('admin.students.index') }}"
               class="group flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-slate-50 hover:text-slate-700 transition-colors {{ request()->routeIs('admin.students.*') ? 'bg-slate-50 text-slate-700 font-medium' : '' }}"
               @click="sidebarOpen = false"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 mr-3 flex-shrink-0 text-gray-400 group-hover:text-slate-600 transition-colors" :class="request()->routeIs('admin.students.*') ? 'text-slate-600' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
                <span class="font-medium">{{ __('Students') }}</span>
            </a>

            <a href="{{ route('admin.redemptions.index') }}"
               class="group flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-slate-50 hover:text-slate-700 transition-colors {{ request()->routeIs('admin.redemptions.*') ? 'bg-slate-50 text-slate-700 font-medium' : '' }}"
               @click="sidebarOpen = false"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 mr-3 flex-shrink-0 text-gray-400 group-hover:text-slate-600 transition-colors" :class="request()->routeIs('admin.redemptions.*') ? 'text-slate-600' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
                <span class="font-medium">{{ __('Point Redemptions') }}</span>
            </a>
        </nav>

        <!-- Logout -->
        <div class="p-4 border-t border-gray-200 mt-auto">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                        class="group flex items-center w-full px-4 py-3 text-gray-700 rounded-xl hover:bg-red-50 hover:text-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2"
                        @click="sidebarOpen = false"
                        onclick="return confirm('{{ __('Are you sure you want to log out?') }}');"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 mr-3 flex-shrink-0 text-gray-400 group-hover:text-red-600 transition-colors">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    <span class="font-medium">{{ __('Logout') }}</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- BACKDROP (mobile only) -->
    <div
        x-cloak
        x-show="sidebarOpen"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/50 z-40 md:hidden"
        aria-hidden="true"
    ></div>

    <!-- MAIN CONTENT -->
    <main class="flex-1 overflow-y-auto pt-4 md:pt-0">
        <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
            <!-- Alert messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 flex-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 flex-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

        <!-- Page header -->
            @hasSection('page-header')
                <header class="mb-6 sm:mb-8">
                    @yield('page-header')
                </header>
            @endif

        <!-- Page content -->
            @yield('content')
        </div>
    </main>
</div>

<script>
    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.style.transition = 'opacity 0.3s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            }, 5000);
        });
    });
</script>

@stack('scripts')
</body>
</html>

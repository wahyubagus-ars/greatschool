@extends('layouts.admin')

@section('title', 'Student Profile')

@section('page-header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.students.index') }}"
               class="p-2 rounded-lg hover:bg-gray-100 transition-colors"
               title="Back to Students">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $student->full_name }}</h1>
                <p class="mt-1 text-gray-600">NIS: {{ $student->nis }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-indigo-100 text-indigo-700 border border-indigo-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ number_format($student->total_points) }} Points
            </span>
        </div>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Left Sidebar - Student Info (1/4 width on large screens) -->
        <div class="lg:col-span-1 space-y-6">

            <!-- Profile Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-br from-slate-600 to-slate-800 px-6 py-8">
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-bold text-3xl border-4 border-white/30">
                            {{ strtoupper(substr($student->full_name, 0, 1)) }}
                        </div>
                        <h2 class="mt-4 text-xl font-bold text-white text-center">{{ $student->full_name }}</h2>
                        <p class="text-slate-300 text-sm mt-1">NIS: {{ $student->nis }}</p>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    @if($student->email)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-slate-50 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Email</p>
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $student->email }}</p>
                            </div>
                        </div>
                    @endif

                    @if($student->phone_number)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-slate-50 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25Z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Phone</p>
                                <p class="text-sm font-medium text-gray-900">{{ $student->phone_number }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-slate-50 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Member Since</p>
                            <p class="text-sm font-medium text-gray-900">{{ $student->created_at->format('F d, Y') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-slate-50 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Last Activity</p>
                            <p class="text-sm font-medium text-gray-900">{{ $student->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-800">Quick Statistics</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Total Reports</span>
                        <span class="text-sm font-bold text-gray-900">{{ $stats['total_bullying_reports'] + $stats['total_facility_reports'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Pending Reports</span>
                        <span class="text-sm font-bold text-amber-600">{{ $stats['pending_bullying_reports'] + $stats['pending_facility_reports'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Quizzes Taken</span>
                        <span class="text-sm font-bold text-indigo-600">{{ $stats['quizzes_taken'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Avg Quiz Score</span>
                        <span class="text-sm font-bold text-green-600">{{ number_format($stats['average_quiz_score'], 1) }}%</span>
                    </div>
                    <div class="pt-3 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total Points Earned</span>
                            <span class="text-sm font-bold text-indigo-600">{{ number_format($stats['total_points_earned']) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 space-y-3">
                    <button type="button"
                            @click="$dispatch('open-reset-password-modal')"
                            class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-300 text-slate-700 font-medium rounded-lg transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                        Reset Password
                    </button>
                    <button type="button"
                            @click="$dispatch('open-add-points-modal')"
                            class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-indigo-50 hover:bg-indigo-100 border border-indigo-300 text-indigo-700 font-medium rounded-lg transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                        Add Points
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content (3/4 width on large screens) -->
        <div class="lg:col-span-3 space-y-6">

            <!-- Activity Overview Tabs -->
            <div x-data="{ activeTab: 'reports' }" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Tab Headers -->
                <div class="border-b border-gray-200">
                    <nav class="flex overflow-x-auto" aria-label="Tabs">
                        <button @click="activeTab = 'reports'"
                                :class="activeTab === 'reports' ? 'border-indigo-500 text-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap px-6 py-4 border-b-2 font-medium text-sm transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            Reports
                            <span class="ml-2 px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-600">
                                {{ $stats['total_bullying_reports'] + $stats['total_facility_reports'] }}
                            </span>
                        </button>
                        <button @click="activeTab = 'quizzes'"
                                :class="activeTab === 'quizzes' ? 'border-indigo-500 text-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap px-6 py-4 border-b-2 font-medium text-sm transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                            </svg>
                            Quizzes
                            <span class="ml-2 px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-600">
                                {{ $stats['quizzes_taken'] }}
                            </span>
                        </button>
                        <button @click="activeTab = 'points'"
                                :class="activeTab === 'points' ? 'border-indigo-500 text-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap px-6 py-4 border-b-2 font-medium text-sm transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Points
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    <!-- Reports Tab -->
                    <div x-show="activeTab === 'reports'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-cloak>

                        @if($student->bullyingReports->count() > 0 || $student->facilityReports->count() > 0)
                            <div class="space-y-6">
                                <!-- Bullying Reports -->
                                @if($student->bullyingReports->count() > 0)
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-red-600">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                            </svg>
                                            Bullying Reports ({{ $student->bullyingReports->count() }})
                                        </h4>
                                        <div class="space-y-3">
                                            @foreach($student->bullyingReports->take(5) as $report)
                                                <a href="{{ route('admin.bullying-reports.show', $report->id) }}"
                                                   class="block p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                                                    <div class="flex items-start justify-between gap-4">
                                                        <div class="flex-1 min-w-0">
                                                            <div class="flex items-center gap-2 mb-1">
                                                                <span class="text-sm font-medium text-gray-900">{{ $report->title }}</span>
                                                                @php
                                                                    $statusStyles = [
                                                                        'pending' => 'bg-red-100 text-red-700',
                                                                        'verified' => 'bg-green-100 text-green-700',
                                                                        'rejected' => 'bg-gray-100 text-gray-700',
                                                                    ];
                                                                @endphp
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $statusStyles[$report->status] }}">
                                                                    {{ ucfirst($report->status) }}
                                                                </span>
                                                            </div>
                                                            <p class="text-sm text-gray-600 truncate">{{ Str::limit($report->description, 80) }}</p>
                                                            <p class="text-xs text-gray-400 mt-1">{{ $report->created_at->diffForHumans() }}</p>
                                                        </div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400 flex-shrink-0">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                                        </svg>
                                                    </div>
                                                </a>
                                            @endforeach
                                            @if($student->bullyingReports->count() > 5)
                                                <a href="{{ route('admin.bullying-reports.index', ['search' => $student->nis]) }}"
                                                   class="block text-center text-sm font-medium text-indigo-600 hover:text-indigo-700 py-2">
                                                    View all {{ $student->bullyingReports->count() }} bullying reports →
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                            <!-- Facility Reports -->
                                @if($student->facilityReports->count() > 0)
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-amber-600">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Facility Reports ({{ $student->facilityReports->count() }})
                                        </h4>
                                        <div class="space-y-3">
                                            @foreach($student->facilityReports->take(5) as $report)
                                                <a href="{{ route('admin.facility-reports.show', $report->id) }}"
                                                   class="block p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                                                    <div class="flex items-start justify-between gap-4">
                                                        <div class="flex-1 min-w-0">
                                                            <div class="flex items-center gap-2 mb-1">
                                                                <span class="text-sm font-medium text-gray-900">{{ $report->title }}</span>
                                                                @php
                                                                    $statusStyles = [
                                                                        'pending' => 'bg-amber-100 text-amber-700',
                                                                        'verified' => 'bg-green-100 text-green-700',
                                                                        'rejected' => 'bg-gray-100 text-gray-700',
                                                                    ];
                                                                @endphp
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $statusStyles[$report->status] }}">
                                                                    {{ ucfirst($report->status) }}
                                                                </span>
                                                            </div>
                                                            <p class="text-sm text-gray-600 truncate">{{ Str::limit($report->description, 80) }}</p>
                                                            <p class="text-xs text-gray-400 mt-1">{{ $report->created_at->diffForHumans() }}</p>
                                                        </div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400 flex-shrink-0">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                                        </svg>
                                                    </div>
                                                </a>
                                            @endforeach
                                            @if($student->facilityReports->count() > 5)
                                                <a href="{{ route('admin.facility-reports.index', ['search' => $student->nis]) }}"
                                                   class="block text-center text-sm font-medium text-indigo-600 hover:text-indigo-700 py-2">
                                                    View all {{ $student->facilityReports->count() }} facility reports →
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gray-50 mx-auto mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">No reports submitted</h3>
                                <p class="text-gray-500">This student hasn't submitted any bullying or facility reports yet.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Quizzes Tab -->
                    <div x-show="activeTab === 'quizzes'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-cloak>

                        @if($student->quizResults->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Quiz</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Score</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Points</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                    @foreach($student->quizResults->take(10) as $result)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3">
                                                <p class="text-sm font-medium text-gray-900">{{ $result->quiz->title ?? 'N/A' }}</p>
                                            </td>
                                            <td class="px-4 py-3">
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                                        {{ $result->score >= 80 ? 'bg-green-100 text-green-700' : ($result->score >= 60 ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                                        {{ $result->score }}/{{ $result->total_questions }}
                                                    </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="text-sm font-medium text-indigo-600">+{{ $result->points_earned }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="text-sm text-gray-600">{{ $result->created_at->format('M d, Y') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @if($student->quizResults->count() > 10)
                                    <div class="text-center pt-4">
                                        <p class="text-sm text-gray-500">Showing 10 of {{ $student->quizResults->count() }} quiz results</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gray-50 mx-auto mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">No quizzes taken</h3>
                                <p class="text-gray-500">This student hasn't taken any quizzes yet.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Points Tab -->
                    <div x-show="activeTab === 'points'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-cloak>

                        @if($student->pointTransactions->count() > 0)
                            <div class="space-y-3">
                                @foreach($student->pointTransactions->take(15) as $transaction)
                                    <div class="flex items-center justify-between p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-lg {{ $transaction->points > 0 ? 'bg-green-50' : 'bg-red-50' }} flex items-center justify-center flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 {{ $transaction->points > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                    @if($transaction->points > 0)
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                                    @endif
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $transaction->description ?? $transaction->source }}</p>
                                                <p class="text-xs text-gray-500">{{ $transaction->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <span class="text-sm font-bold {{ $transaction->points > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $transaction->points > 0 ? '+' : '' }}{{ $transaction->points }}
                                        </span>
                                    </div>
                                @endforeach
                                @if($student->pointTransactions->count() > 15)
                                    <div class="text-center pt-4">
                                        <p class="text-sm text-gray-500">Showing 15 of {{ $student->pointTransactions->count() }} transactions</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gray-50 mx-auto mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">No point transactions</h3>
                                <p class="text-gray-500">This student hasn't earned or spent any points yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div x-data="{
        open: false,
        openModal() {
            this.open = true;
            document.body.style.overflow = 'hidden';
        },
        closeModal() {
            this.open = false;
            document.body.style.overflow = '';
        }
    }"
         x-show="open"
         @open-reset-password-modal.window="openModal()"
         @keydown.escape.window="closeModal()"
         x-cloak
         class="fixed inset-0 z-[60] overflow-y-auto"
         role="dialog"
         aria-modal="true">

        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="closeModal()"
             class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity">
        </div>

        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl relative z-[70]">

                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-amber-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-semibold text-gray-900">Reset Password</h3>
                        <p class="text-sm text-gray-500">Reset password for {{ $student->full_name }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.students.reset-password', $student->id) }}">
                    @csrf
                    @method('POST')

                    <div class="mb-4">
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1.5">New Password</label>
                        <input type="password"
                               name="new_password"
                               id="new_password"
                               required
                               minlength="8"
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                    </div>

                    <div class="flex gap-3">
                        <button type="button"
                                @click="closeModal()"
                                class="flex-1 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                            Cancel
                        </button>
                        <button type="submit"
                                class="flex-1 px-4 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-all duration-200">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Points Modal -->
    <div x-data="{
        open: false,
        openModal() {
            this.open = true;
            document.body.style.overflow = 'hidden';
        },
        closeModal() {
            this.open = false;
            document.body.style.overflow = '';
        }
    }"
         x-show="open"
         @open-add-points-modal.window="openModal()"
         @keydown.escape.window="closeModal()"
         x-cloak
         class="fixed inset-0 z-[60] overflow-y-auto"
         role="dialog"
         aria-modal="true">

        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="closeModal()"
             class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity">
        </div>

        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl relative z-[70]">

                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-indigo-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-semibold text-gray-900">Add Points</h3>
                        <p class="text-sm text-gray-500">Award points to {{ $student->full_name }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.students.add-points', $student->id) }}">
                    @csrf
                    @method('POST')

                    <div class="mb-4">
                        <label for="points" class="block text-sm font-medium text-gray-700 mb-1.5">Points</label>
                        <input type="number"
                               name="points"
                               id="points"
                               required
                               min="1"
                               max="1000"
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">Reason</label>
                        <textarea name="description"
                                  id="description"
                                  rows="3"
                                  required
                                  placeholder="e.g., Excellent participation, Academic achievement..."
                                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm resize-none"></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button"
                                @click="closeModal()"
                                class="flex-1 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                            Cancel
                        </button>
                        <button type="submit"
                                class="flex-1 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-all duration-200">
                            Add Points
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

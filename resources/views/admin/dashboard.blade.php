@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page-header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Welcome, {{ Auth::guard('admin')->user()->full_name }}!</h1>
            <p class="mt-1 text-gray-600">Here's an overview of pending reports and system activity.</p>
        </div>
        <div class="flex items-center bg-slate-100 text-slate-700 px-4 py-2 rounded-xl text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-1.5 flex-shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
            <span class="font-medium">Verified: {{ $verifiedByAdmin }}</span>
        </div>
    </div>
@endsection

@section('content')
    <!-- Critical Stats Cards (Pending Reports) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <!-- Pending Bullying Reports Card -->
        <a href="{{ route('admin.bullying-reports.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md hover:border-red-300 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-red-50 text-red-600 group-hover:bg-red-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Pending Bullying</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">{{ $pendingBullyingReports }}</p>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-300 group-hover:text-red-400 transition-colors">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </div>
        </a>

        <!-- Pending Facility Reports Card -->
        <a href="{{ route('admin.facility-reports.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md hover:border-amber-300 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-amber-50 text-amber-600 group-hover:bg-amber-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Pending Facility</p>
                        <p class="text-2xl font-bold text-amber-600 mt-1">{{ $pendingFacilityReports }}</p>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-300 group-hover:text-amber-400 transition-colors">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </div>
        </a>

        <!-- Total Students Card -->
        <a href="{{ route('admin.students.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md hover:border-slate-300 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-slate-50 text-slate-600 group-hover:bg-slate-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Students</p>
                        <p class="text-2xl font-bold text-slate-700 mt-1">{{ $totalStudents }}</p>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-300 group-hover:text-slate-400 transition-colors">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </div>
        </a>

        <!-- Total Quizzes Card -->
        <a href="{{ route('admin.quizzes.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md hover:border-indigo-300 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Quizzes</p>
                        <p class="text-2xl font-bold text-indigo-700 mt-1">{{ $totalQuizzes }}</p>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-300 group-hover:text-indigo-400 transition-colors">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </div>
        </a>
    </div>

    <!-- Two Column Layout for Reports -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Recent Pending Bullying Reports -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-red-50 text-red-600 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-800">Pending Bullying Reports</h2>
                </div>
                <a href="{{ route('admin.bullying-reports.index') }}" class="text-sm font-medium text-red-600 hover:text-red-700 transition-colors flex items-center">
                    View All
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($recentBullyingReports as $report)
                    <a href="{{ route('admin.bullying-reports.show', $report->id) }}" class="block hover:bg-gray-50 transition-colors">
                        <div class="px-5 py-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                            {{ $report->reporter_type }}
                                        </span>
                                        <span class="text-xs text-gray-400">{{ $report->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="font-medium text-gray-900 truncate">{{ $report->title }}</p>
                                    <p class="text-sm text-gray-600 truncate mt-0.5">{{ $report->student->full_name }} • {{ $report->location }}</p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-300 flex-shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="px-5 py-10 sm:py-14 text-center">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-green-50 mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-green-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-gray-800 mb-1">All caught up!</h3>
                        <p class="text-sm text-gray-500">No pending bullying reports</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Pending Facility Reports -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-amber-50 text-amber-600 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-800">Pending Facility Reports</h2>
                </div>
                <a href="{{ route('admin.facility-reports.index') }}" class="text-sm font-medium text-amber-600 hover:text-amber-700 transition-colors flex items-center">
                    View All
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($recentFacilityReports as $report)
                    <a href="{{ route('admin.facility-reports.show', $report->id) }}" class="block hover:bg-gray-50 transition-colors">
                        <div class="px-5 py-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                            Facility Issue
                                        </span>
                                        <span class="text-xs text-gray-400">{{ $report->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="font-medium text-gray-900 truncate">{{ $report->title }}</p>
                                    <p class="text-sm text-gray-600 truncate mt-0.5">{{ $report->student->full_name }} • {{ $report->location }}</p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-300 flex-shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="px-5 py-10 sm:py-14 text-center">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-green-50 mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-green-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-gray-800 mb-1">All caught up!</h3>
                        <p class="text-sm text-gray-500">No pending facility reports</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- System Overview Stats -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
        <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">System Overview</h2>
        </div>
        <div class="p-5 sm:p-6">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="text-center p-4 rounded-xl bg-gray-50">
                    <p class="text-2xl font-bold text-gray-800">{{ $totalBullyingReports }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total Bullying Reports</p>
                </div>
                <div class="text-center p-4 rounded-xl bg-gray-50">
                    <p class="text-2xl font-bold text-gray-800">{{ $totalFacilityReports }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total Facility Reports</p>
                </div>
                <div class="text-center p-4 rounded-xl bg-gray-50">
                    <p class="text-2xl font-bold text-gray-800">{{ $totalStudents }}</p>
                    <p class="text-xs text-gray-500 mt-1">Registered Students</p>
                </div>
                <div class="text-center p-4 rounded-xl bg-gray-50">
                    <p class="text-2xl font-bold text-gray-800">{{ $totalQuizzes }}</p>
                    <p class="text-xs text-gray-500 mt-1">Active Quizzes</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Breakdown -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <!-- Bullying Report Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Bullying Report Status</h2>
            </div>
            <div class="p-5 sm:p-6">
                <div class="space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Pending</span>
                            <span class="text-sm font-bold text-red-600">{{ $bullyingStatusBreakdown['pending'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-red-500 h-2.5 rounded-full" style="width: {{ $totalBullyingReports > 0 ? ($bullyingStatusBreakdown['pending'] / $totalBullyingReports) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Verified</span>
                            <span class="text-sm font-bold text-green-600">{{ $bullyingStatusBreakdown['verified'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $totalBullyingReports > 0 ? ($bullyingStatusBreakdown['verified'] / $totalBullyingReports) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Rejected</span>
                            <span class="text-sm font-bold text-gray-600">{{ $bullyingStatusBreakdown['rejected'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-gray-500 h-2.5 rounded-full" style="width: {{ $totalBullyingReports > 0 ? ($bullyingStatusBreakdown['rejected'] / $totalBullyingReports) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Facility Report Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Facility Report Status</h2>
            </div>
            <div class="p-5 sm:p-6">
                <div class="space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Pending</span>
                            <span class="text-sm font-bold text-amber-600">{{ $facilityStatusBreakdown['pending'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-amber-500 h-2.5 rounded-full" style="width: {{ $totalFacilityReports > 0 ? ($facilityStatusBreakdown['pending'] / $totalFacilityReports) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Verified</span>
                            <span class="text-sm font-bold text-green-600">{{ $facilityStatusBreakdown['verified'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $totalFacilityReports > 0 ? ($facilityStatusBreakdown['verified'] / $totalFacilityReports) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Rejected</span>
                            <span class="text-sm font-bold text-gray-600">{{ $facilityStatusBreakdown['rejected'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-gray-500 h-2.5 rounded-full" style="width: {{ $totalFacilityReports > 0 ? ($facilityStatusBreakdown['rejected'] / $totalFacilityReports) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions (Mobile optimized) -->
    <div class="mt-8 sm:hidden grid grid-cols-2 gap-4">
        <a href="{{ route('admin.bullying-reports.index') }}" class="flex flex-col items-center justify-center p-5 bg-white rounded-2xl border border-gray-200 hover:shadow-md transition-shadow">
            <div class="p-3 bg-red-50 rounded-xl mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-7 h-7 text-red-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700">Bullying Reports</span>
            @if($pendingBullyingReports > 0)
                <span class="text-xs font-bold text-red-600 mt-1">{{ $pendingBullyingReports }} pending</span>
            @endif
        </a>
        <a href="{{ route('admin.facility-reports.index') }}" class="flex flex-col items-center justify-center p-5 bg-white rounded-2xl border border-gray-200 hover:shadow-md transition-shadow">
            <div class="p-3 bg-amber-50 rounded-xl mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-7 h-7 text-amber-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700">Facility Reports</span>
            @if($pendingFacilityReports > 0)
                <span class="text-xs font-bold text-amber-600 mt-1">{{ $pendingFacilityReports }} pending</span>
            @endif
        </a>
    </div>
@endsection

@extends('layouts.student')

@section('title', 'Facility Reports')

@section('page-header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Facility Reports</h1>
            <p class="mt-1 text-gray-600">Report issues with school facilities and track their resolution</p>
        </div>
        <a href="{{ route('student.facility-reports.create') }}"
           class="inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 min-w-[140px]">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Report
        </a>
    </div>
@endsection

@section('content')
    @if($reports->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
            <div class="mx-auto w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">No facility reports</h3>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">
                Report broken equipment, cleanliness issues, or safety concerns to help maintain our school environment.
            </p>
            <a href="{{ route('student.facility-reports.create') }}"
               class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors shadow-sm">
                Report a Facility Issue
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <ul class="divide-y divide-gray-200">
                @foreach($reports as $report)
                    <li class="hover:bg-gray-50 transition-colors">
                        <a href="{{ route('student.facility-reports.show', $report) }}" class="block p-5 sm:p-6">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <p class="text-base font-semibold text-indigo-700 truncate">{{ $report->title }}</p>
                                        <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                        @if($report->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($report->status === 'verified') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ Str::limit($report->description, 80) }}</p>
                                    <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $report->location }}
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $report->created_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                <span class="inline-flex items-center text-indigo-600 text-sm font-medium">
                                    View Details
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>

            @if($reports->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $reports->links() }}
                </div>
            @endif
        </div>
    @endif
@endsection

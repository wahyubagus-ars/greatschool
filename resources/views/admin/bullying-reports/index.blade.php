@extends('layouts.admin')

@section('title', 'Bullying Reports Management')

@section('page-header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Bullying Reports</h1>
            <p class="mt-1 text-gray-600">Manage and verify student bullying reports</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-red-100 text-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                {{ $statusCounts['pending'] }} Pending
            </span>
        </div>
    </div>
@endsection

@section('content')
    <!-- Filters Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6">
        <form method="GET" action="{{ route('admin.bullying-reports.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Search -->
                <div class="lg:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1.5">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </div>
                        <input type="text"
                               name="search"
                               id="search"
                               value="{{ $search }}"
                               placeholder="Search title, description, student..."
                               class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm">
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                    <select name="status"
                            id="status"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-all duration-200 text-gray-900 shadow-sm bg-white">
                        <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="verified" {{ $status === 'verified' ? 'selected' : '' }}>Verified</option>
                        <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <!-- Sort By -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-1.5">Sort By</label>
                    <select name="sort"
                            id="sort"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-all duration-200 text-gray-900 shadow-sm bg-white">
                        <option value="created_at" {{ $sort === 'created_at' ? 'selected' : '' }}>Created Date</option>
                        <option value="incident_date" {{ $sort === 'incident_date' ? 'selected' : '' }}>Incident Date</option>
                        <option value="student_name" {{ $sort === 'student_name' ? 'selected' : '' }}>Student Name</option>
                        <option value="status" {{ $sort === 'status' ? 'selected' : '' }}>Status</option>
                    </select>
                </div>

                <!-- Order -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-1.5">Order</label>
                    <select name="order"
                            id="order"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-all duration-200 text-gray-900 shadow-sm bg-white">
                        <option value="desc" {{ $order === 'desc' ? 'selected' : '' }}>Newest First</option>
                        <option value="asc" {{ $order === 'asc' ? 'selected' : '' }}>Oldest First</option>
                    </select>
                </div>
            </div>

            <!-- Date Range -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1.5">From Date</label>
                    <input type="date"
                           name="date_from"
                           id="date_from"
                           value="{{ $dateFrom }}"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-all duration-200 text-gray-900 shadow-sm">
                </div>
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1.5">To Date</label>
                    <input type="date"
                           name="date_to"
                           id="date_to"
                           value="{{ $dateTo }}"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-all duration-200 text-gray-900 shadow-sm">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2.5 bg-slate-700 hover:bg-slate-800 text-white font-medium rounded-lg transition-all duration-200 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    Apply Filters
                </button>
                <a href="{{ route('admin.bullying-reports.index') }}"
                   class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium rounded-lg transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Reset
                </a>
                <span class="text-sm text-gray-500 ml-auto">
                    Total: <strong>{{ $statusCounts['all'] }}</strong> reports
                </span>
            </div>
        </form>
    </div>

    <!-- Status Filter Badges (Quick Filter) -->
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('admin.bullying-reports.index', array_merge($queryParams, ['status' => 'all'])) }}"
           class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $status === 'all' ? 'bg-slate-700 text-white shadow-md' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
            All
            <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ $status === 'all' ? 'bg-slate-600 text-white' : 'bg-gray-100 text-gray-600' }}">
                {{ $statusCounts['all'] }}
            </span>
        </a>
        <a href="{{ route('admin.bullying-reports.index', array_merge($queryParams, ['status' => 'pending'])) }}"
           class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $status === 'pending' ? 'bg-red-600 text-white shadow-md' : 'bg-white text-red-700 border border-red-300 hover:bg-red-50' }}">
            Pending
            <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ $status === 'pending' ? 'bg-red-500 text-white' : 'bg-red-100 text-red-600' }}">
                {{ $statusCounts['pending'] }}
            </span>
        </a>
        <a href="{{ route('admin.bullying-reports.index', array_merge($queryParams, ['status' => 'verified'])) }}"
           class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $status === 'verified' ? 'bg-green-600 text-white shadow-md' : 'bg-white text-green-700 border border-green-300 hover:bg-green-50' }}">
            Verified
            <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ $status === 'verified' ? 'bg-green-500 text-white' : 'bg-green-100 text-green-600' }}">
                {{ $statusCounts['verified'] }}
            </span>
        </a>
        <a href="{{ route('admin.bullying-reports.index', array_merge($queryParams, ['status' => 'rejected'])) }}"
           class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $status === 'rejected' ? 'bg-gray-600 text-white shadow-md' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
            Rejected
            <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ $status === 'rejected' ? 'bg-gray-500 text-white' : 'bg-gray-100 text-gray-600' }}">
                {{ $statusCounts['rejected'] }}
            </span>
        </a>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Report ID</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Student</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Incident Date</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Location</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Created</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse($reports as $report)
                    <tr class="hover:bg-slate-50 cursor-pointer transition-colors duration-150"
                        onclick="window.location.href='{{ route('admin.bullying-reports.show', $report->id) }}'">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-medium text-slate-600">#{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-700 font-medium text-xs mr-3">
                                    {{ strtoupper(substr($report->student->full_name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $report->student->full_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $report->student->nis }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900 truncate max-w-xs">{{ $report->title }}</p>
                            <p class="text-xs text-gray-500 truncate max-w-xs mt-0.5">{{ Str::limit($report->description, 50) }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-700">{{ $report->incident_date->format('M d, Y') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-700">{{ $report->location }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusStyles = [
                                    'pending' => 'bg-red-100 text-red-700 border-red-200',
                                    'verified' => 'bg-green-100 text-green-700 border-green-200',
                                    'rejected' => 'bg-gray-100 text-gray-700 border-gray-200',
                                ];
                                $statusIcons = [
                                    'pending' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />',
                                    'verified' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                    'rejected' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $statusStyles[$report->status] }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 mr-1">
                                        {!! $statusIcons[$report->status] !!}
                                    </svg>
                                    {{ ucfirst($report->status) }}
                                </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-700">{{ $report->created_at->format('M d, Y') }}</span>
                            <span class="text-xs text-gray-400 block">{{ $report->created_at->format('H:i') }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gray-50 mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">No reports found</h3>
                            <p class="text-gray-500 max-w-md mx-auto">
                                @if($search || $status !== 'all' || $dateFrom || $dateTo)
                                    Try adjusting your filters to find what you're looking for.
                                @else
                                    There are no bullying reports in the system yet.
                                @endif
                            </p>
                            @if($search || $status !== 'all' || $dateFrom || $dateTo)
                                <a href="{{ route('admin.bullying-reports.index') }}"
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-slate-700 hover:bg-slate-800 text-white font-medium rounded-lg transition-all duration-200">
                                    Clear Filters
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($reports->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-gray-600">
                        Showing <strong>{{ $reports->firstItem() ?? 0 }}</strong> to <strong>{{ $reports->lastItem() ?? 0 }}</strong> of <strong>{{ $reports->total() }}</strong> results
                    </p>
                    <div class="flex items-center gap-2">
                        {{ $reports->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Click Hint for Mobile -->
    <div class="mt-4 sm:hidden text-center text-xs text-gray-500">
        <p>Tap any row to view report details</p>
    </div>
@endsection

@section('scripts')
    <script>
        // Auto-submit form when date filters change
        document.addEventListener('DOMContentLoaded', function() {
            const dateFrom = document.getElementById('date_from');
            const dateTo = document.getElementById('date_to');

            if (dateFrom && dateTo) {
                dateFrom.addEventListener('change', function() {
                    if (dateTo.value) {
                        this.form.submit();
                    }
                });
                dateTo.addEventListener('change', function() {
                    if (dateFrom.value) {
                        this.form.submit();
                    }
                });
            }
        });
    </script>
@endsection

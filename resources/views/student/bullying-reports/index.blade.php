@extends('layouts.student')

@section('title', __('My Bullying Reports'))

@section('page-header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ __('My Bullying Reports') }}</h1>
            <p class="mt-1 text-gray-600">{{ __('View and track your submitted bullying reports') }}</p>
        </div>
        <a href="{{ route('student.bullying-reports.create') }}"
           class="inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 min-w-[140px]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            {{ __('New Report') }}
        </a>
    </div>
@endsection

@section('content')
    @if($reports->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
            <div class="mx-auto w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ __('No reports yet') }}</h3>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">
                {{ __('You haven\'t submitted any bullying reports. Reporting helps keep our school safe for everyone.') }}
            </p>
            <a href="{{ route('student.bullying-reports.create') }}"
               class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors shadow-sm">
                {{ __('Create Your First Report') }}
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">{{ __('Title') }}</th>
                        <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">{{ __('Date') }}</th>
                        <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">{{ __('Status') }}</th>
                        <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($reports as $report)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-medium text-gray-900">{{ $report->title }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ Str::limit($report->description, 40) }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $report->incident_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($report->status == 'pending')
                                    <span class="px-2.5 py-0.5 inline-flex text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                        {{ __('Pending') }}
                                    </span>
                                @elseif($report->status == 'verified')
                                    <span class="px-2.5 py-0.5 inline-flex text-xs font-medium rounded-full bg-green-100 text-green-800">
                                        {{ __('Verified') }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 inline-flex text-xs font-medium rounded-full bg-red-100 text-red-800">
                                        {{ __('Rejected') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('student.bullying-reports.show', $report) }}"
                                   class="text-indigo-600 hover:text-indigo-900 inline-flex items-center">
                                    {{ __('View Details') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 ml-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            @if($reports->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $reports->links() }}
                </div>
            @endif
        </div>
    @endif
@endsection

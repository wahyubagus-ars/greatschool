@extends('layouts.student')

@section('title', 'Report Details - ' . $bullyingReport->title)

@section('page-header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Bullying Report Details</h1>
            <p class="mt-1 text-gray-600">Report submitted on {{ $bullyingReport->created_at->format('M d, Y') }}</p>
        </div>
        <a href="{{ route('student.bullying-reports.index') }}"
           class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 min-w-[100px]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Back to List
        </a>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Status Banner -->
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center">
                <span class="text-sm font-medium text-gray-500 mr-2">Status:</span>
                @if($bullyingReport->status == 'pending')
                    <span class="px-3 py-1 inline-flex text-sm font-medium rounded-full bg-yellow-100 text-yellow-800">
                    Pending Review
                </span>
                @elseif($bullyingReport->status == 'verified')
                    <span class="px-3 py-1 inline-flex text-sm font-medium rounded-full bg-green-100 text-green-800">
                    Verified
                </span>
                @else
                    <span class="px-3 py-1 inline-flex text-sm font-medium rounded-full bg-red-100 text-red-800">
                    Rejected
                </span>
                @endif
            </div>
            <div class="text-sm text-gray-500 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                Submitted: {{ $bullyingReport->created_at->format('M d, Y \a\t h:i A') }}
            </div>
        </div>

        <!-- Details -->
        <div class="p-5 md:p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1.5">Reporter Type</h3>
                    <p class="text-base text-gray-800 font-medium capitalize">{{ $bullyingReport->reporter_type }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1.5">Incident Date</h3>
                    <p class="text-base text-gray-800 font-medium">{{ $bullyingReport->incident_date->format('F j, Y') }}</p>
                </div>
                <div class="md:col-span-2">
                    <h3 class="text-sm font-medium text-gray-500 mb-1.5">Title</h3>
                    <p class="text-lg text-gray-900 font-semibold">{{ $bullyingReport->title }}</p>
                </div>
                <div class="md:col-span-2">
                    <h3 class="text-sm font-medium text-gray-500 mb-1.5">Location</h3>
                    <p class="text-base text-gray-800">{{ $bullyingReport->location }}</p>
                </div>
                <div class="md:col-span-2">
                    <h3 class="text-sm font-medium text-gray-500 mb-1.5">Description</h3>
                    <div class="prose prose-gray max-w-none mt-1 text-gray-800 whitespace-pre-line">
                        {{ $bullyingReport->description }}
                    </div>
                </div>
            </div>

            <!-- Evidence Section -->
            @if($bullyingReport->evidence->count() > 0)
                <div class="pt-4 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Evidence Files</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($bullyingReport->evidence as $evidence)
                            <div class="border border-gray-200 rounded-xl p-4 flex flex-col items-center text-center hover:shadow transition-shadow">
                                <div class="flex-shrink-0 mb-3">
                                    @php
                                        $ext = strtolower(pathinfo($evidence->file_name, PATHINFO_EXTENSION));
                                    @endphp
                                    @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                        <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    @elseif(in_array($ext, ['mp4', 'mov', 'avi', 'wmv', 'flv']))
                                        <svg class="w-10 h-10 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <p class="text-sm font-medium text-gray-800 truncate max-w-full">{{ $evidence->file_name }}</p>
                                <a href="{{ Storage::url($evidence->file_path) }}"
                                   target="_blank"
                                   class="mt-2 inline-flex items-center text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-3.5 h-3.5 mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                    View File
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        <!-- Verification Notes -->
            @if($bullyingReport->verification_note || $bullyingReport->verified_at)
                <div class="pt-4 border-t border-gray-200">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-indigo-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-sm font-medium text-gray-500">Administrator Response</h3>
                            <div class="mt-2 bg-gray-50 rounded-lg p-4 text-gray-800">
                                {{ $bullyingReport->verification_note ?: 'No additional notes provided.' }}
                            </div>
                            @if($bullyingReport->verified_at)
                                <p class="mt-2 text-xs text-gray-500 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-3.5 h-3.5 mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Reviewed on {{ $bullyingReport->verified_at->format('M d, Y \a\t h:i A') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

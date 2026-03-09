@extends('layouts.student')

@section('title', 'Report Details')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Bullying Report Details</h1>
            <a href="{{ route('student.bullying-reports.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Back to List
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Status Banner -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
            <div>
                <span class="text-sm font-medium text-gray-500 mr-2">Status:</span>
                @if($bullyingReport->status == 'pending')
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending Review</span>
                @elseif($bullyingReport->status == 'verified')
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">Verified</span>
                @else
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                @endif
            </div>
            <div class="text-sm text-gray-500">
                Submitted: {{ $bullyingReport->created_at->format('M d, Y h:i A') }}
            </div>
        </div>

        <!-- Details -->
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Reporter Type</h3>
                    <p class="mt-1 text-base text-gray-800 capitalize">{{ $bullyingReport->reporter_type }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Incident Date</h3>
                    <p class="mt-1 text-base text-gray-800">{{ $bullyingReport->incident_date->format('F j, Y') }}</p>
                </div>
                <div class="md:col-span-2">
                    <h3 class="text-sm font-medium text-gray-500">Title</h3>
                    <p class="mt-1 text-base text-gray-800">{{ $bullyingReport->title }}</p>
                </div>
                <div class="md:col-span-2">
                    <h3 class="text-sm font-medium text-gray-500">Location</h3>
                    <p class="mt-1 text-base text-gray-800">{{ $bullyingReport->location }}</p>
                </div>
                <div class="md:col-span-2">
                    <h3 class="text-sm font-medium text-gray-500">Description</h3>
                    <p class="mt-1 text-base text-gray-800 whitespace-pre-line">{{ $bullyingReport->description }}</p>
                </div>
            </div>

            <!-- Evidence Section -->
            @if($bullyingReport->evidence->count() > 0)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-3">Evidence Files</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($bullyingReport->evidence as $evidence)
                            <div class="border border-gray-200 rounded-lg p-3 flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    @php
                                        $ext = pathinfo($evidence->file_name, PATHINFO_EXTENSION);
                                    @endphp
                                    @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
                                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    @elseif(in_array($ext, ['mp4', 'mov', 'avi']))
                                        <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-800 truncate">{{ $evidence->file_name }}</p>
                                    <a href="{{ Storage::url($evidence->file_path) }}" target="_blank" class="text-xs text-indigo-600 hover:text-indigo-800">View file</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        <!-- Verification Notes (if any) -->
            @if($bullyingReport->verification_note)
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Admin Notes</h3>
                    <div class="bg-gray-50 rounded-lg p-4 text-gray-700">
                        {{ $bullyingReport->verification_note }}
                    </div>
                    @if($bullyingReport->verified_at)
                        <p class="mt-2 text-xs text-gray-500">Verified on {{ $bullyingReport->verified_at->format('M d, Y h:i A') }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection

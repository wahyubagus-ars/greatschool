@extends('layouts.admin')

@section('title', __('Report Details'))

@section('page-header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.bullying-reports.index') }}"
               class="p-2 rounded-lg hover:bg-gray-100 transition-colors"
               title="{{ __('Back to Reports') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ __('Report #:id', ['id' => str_pad($bullyingReport->id, 5, '0', STR_PAD_LEFT)]) }}</h1>
                <p class="mt-1 text-gray-600">{{ $bullyingReport->title }}</p>
            </div>
        </div>
        <div>
            @php
                $statusStyles = [
                    'pending' => 'bg-red-100 text-red-700 border-red-200',
                    'verified' => 'bg-green-100 text-green-700 border-green-200',
                    'rejected' => 'bg-gray-100 text-gray-700 border-gray-200',
                ];
            @endphp
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium border {{ $statusStyles[$bullyingReport->status] }}">
                @if($bullyingReport->status === 'pending')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                @elseif($bullyingReport->status === 'verified')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @endif
                {{ __(ucfirst($bullyingReport->status)) }}
            </span>
        </div>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content (Left Column - 2/3 width) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Report Details Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-slate-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        {{ __('Report Information') }}
                    </h2>
                </div>
                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">{{ __('Reporter Type') }}</label>
                            <p class="text-sm font-medium text-gray-900 capitalize">{{ $bullyingReport->reporter_type }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">{{ __('Incident Date') }}</label>
                            <p class="text-sm font-medium text-gray-900">{{ $bullyingReport->incident_date->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">{{ __('Location') }}</label>
                            <p class="text-sm font-medium text-gray-900">{{ $bullyingReport->location }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">{{ __('Reported On') }}</label>
                            <p class="text-sm font-medium text-gray-900">{{ $bullyingReport->created_at->format('F d, Y \a\t H:i') }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">{{ __('Description') }}</label>
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-800 whitespace-pre-line">{{ $bullyingReport->description }}</p>
                        </div>
                    </div>

                    @if($bullyingReport->verification_note)
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">
                                {{ __('Admin Verification Note') }}
                                @if($bullyingReport->verifiedByAdmin)
                                    <span class="text-gray-400 normal-case">— {{ __('by') }} {{ $bullyingReport->verifiedByAdmin->full_name }}</span>
                                @endif
                            </label>
                            <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                                <p class="text-sm text-gray-800 whitespace-pre-line">{{ $bullyingReport->verification_note }}</p>
                            </div>
                            @if($bullyingReport->verified_at)
                                <p class="text-xs text-gray-500 mt-2">
                                    {{ __('Verified on') }} {{ $bullyingReport->verified_at->format('F d, Y \a\t H:i') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Evidence Card -->
            @if($bullyingReport->evidence->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-slate-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                            {{ __('Evidence') }} ({{ $bullyingReport->evidence->count() }})
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach($bullyingReport->evidence as $evidence)
                                <div class="group relative aspect-square rounded-lg overflow-hidden border border-gray-200 bg-gray-50">
                                    @php
                                        $extension = strtolower(pathinfo($evidence->file_name, PATHINFO_EXTENSION));
                                        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                    @endphp
                                    @if($isImage && $evidence->public_url)
                                        <img src="{{ $evidence->public_url }}"
                                             alt="{{ $evidence->file_name }}"
                                             class="w-full h-full object-cover cursor-pointer hover:opacity-75 transition-opacity"
                                             @click="$dispatch('open-image-modal', { src: '{{ $evidence->public_url }}', alt: '{{ $evidence->file_name }}' })">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-slate-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <a href="{{ $evidence->public_url ?? '#' }}"
                                           download="{{ $evidence->file_name }}"
                                           class="p-2 bg-white rounded-full hover:bg-gray-100 transition-colors"
                                           title="{{ __('Download') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-700">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="absolute bottom-0 left-0 right-0 bg-black/70 px-2 py-1">
                                        <p class="text-xs text-white truncate">{{ $evidence->file_name }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        <!-- Student Other Reports -->
            @if($studentOtherReports->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-slate-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9Z" />
                            </svg>
                            {{ __('Other Reports by This Student') }}
                        </h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach($studentOtherReports as $report)
                            <a href="{{ route('admin.bullying-reports.show', $report->id) }}"
                               class="block px-6 py-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $report->title }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $report->created_at->diffForHumans() }}</p>
                                    </div>
                                    @php
                                        $badgeStyles = [
                                            'pending' => 'bg-red-100 text-red-700',
                                            'verified' => 'bg-green-100 text-green-700',
                                            'rejected' => 'bg-gray-100 text-gray-700',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $badgeStyles[$report->status] }}">
                                        {{ __(ucfirst($report->status)) }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar (Right Column - 1/3 width) -->
        <div class="space-y-6">

            <!-- Student Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-slate-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        {{ __('Student Information') }}
                    </h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-slate-200 flex items-center justify-center text-slate-700 font-bold text-xl">
                            {{ strtoupper(substr($bullyingReport->student->full_name, 0, 1)) }}
                        </div>
                        <div class="ml-4">
                            <p class="text-lg font-semibold text-gray-900">{{ $bullyingReport->student->full_name }}</p>
                            <p class="text-sm text-gray-500">{{ __('NIS:') }} {{ $bullyingReport->student->nis }}</p>
                        </div>
                    </div>
                    <div class="space-y-3 pt-4 border-t border-gray-100">
                        @if($bullyingReport->student->email)
                            <div class="flex items-center text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                                <span class="text-gray-700">{{ $bullyingReport->student->email }}</span>
                            </div>
                        @endif
                        @if($bullyingReport->student->phone_number)
                            <div class="flex items-center text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25Z" />
                                </svg>
                                <span class="text-gray-700">{{ $bullyingReport->student->phone_number }}</span>
                            </div>
                        @endif
                        <div class="flex items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            <span class="text-gray-700">{{ __('Joined') }} {{ $bullyingReport->student->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.students.show', $bullyingReport->student->id) }}"
                       class="mt-4 w-full inline-flex items-center justify-center px-4 py-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-300 text-slate-700 font-medium rounded-lg transition-all duration-200">
                        {{ __('View Full Profile') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Action Card (Only for Pending Reports) -->
            @if($bullyingReport->status === 'pending')
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-slate-50 to-slate-100">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-slate-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l-2.25-2.25a2.652 2.625 0 00-3.782 0L2.25 15.75a2.652 2.652 0 000 3.782l3.127 3.127m9-10.695l-3.127-3.127" />
                            </svg>
                            {{ __('Take Action') }}
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Verify Button -->
                        <button type="button"
                                @click="$dispatch('open-verify-modal')"
                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-all duration-200 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('Verify Report') }}
                        </button>

                        <!-- Reject Button -->
                        <button type="button"
                                @click="$dispatch('open-reject-modal')"
                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 font-medium rounded-lg transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                            </svg>
                            {{ __('Reject Report') }}
                        </button>

                        <p class="text-xs text-gray-500 text-center pt-2">
                            {{ __('This action cannot be undone. Make sure you\'ve reviewed all evidence.') }}
                        </p>
                    </div>
                </div>
        @else
            <!-- Processed Status Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-slate-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('Report Status') }}
                        </h2>
                    </div>
                    <div class="p-6">
                        @if($bullyingReport->status === 'verified')
                            <div class="flex items-center p-4 bg-green-50 rounded-lg border border-green-200">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">{{ __('Report Verified') }}</p>
                                    <p class="text-xs text-green-600 mt-0.5">
                                        @if($bullyingReport->verifiedByAdmin)
                                            {{ __('by') }} {{ $bullyingReport->verifiedByAdmin->full_name }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-800">{{ __('Report Rejected') }}</p>
                                    <p class="text-xs text-gray-600 mt-0.5">
                                        @if($bullyingReport->verifiedByAdmin)
                                            {{ __('by') }} {{ $bullyingReport->verifiedByAdmin->full_name }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
        @endif

        <!-- Report Timeline -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-slate-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('Timeline') }}
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Report Created -->
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-slate-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <div class="flex-1 pt-1">
                                <p class="text-sm font-medium text-gray-900">{{ __('Report Submitted') }}</p>
                                <p class="text-xs text-gray-500">{{ $bullyingReport->created_at->format('M d, Y \a\t H:i') }}</p>
                                <p class="text-xs text-gray-600 mt-1">{{ __('by') }} {{ $bullyingReport->student->full_name }}</p>
                            </div>
                        </div>

                    @if($bullyingReport->verified_at)
                        <!-- Report Verified/Rejected -->
                            <div class="flex gap-3">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $bullyingReport->status === 'verified' ? 'bg-green-100' : 'bg-gray-100' }} flex items-center justify-center">
                                    @if($bullyingReport->status === 'verified')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 pt-1">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ __('Report') }} {{ __(ucfirst($bullyingReport->status)) }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $bullyingReport->verified_at->format('M d, Y \a\t H:i') }}</p>
                                    @if($bullyingReport->verifiedByAdmin)
                                        <p class="text-xs text-gray-600 mt-1">{{ __('by') }} {{ $bullyingReport->verifiedByAdmin->full_name }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Verify Modal -->
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
         @open-verify-modal.window="openModal()"
         @keydown.escape.window="closeModal()"
         x-cloak
         class="fixed inset-0 z-[60] overflow-y-auto"
         role="dialog"
         aria-modal="true"
         aria-labelledby="modal-title">

        <!-- Backdrop (Transparent with Blur) -->
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

        <!-- Modal Panel -->
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl relative z-[70]"
                 id="modal-title">

                <form method="POST" action="{{ route('admin.bullying-reports.verify', $bullyingReport->id) }}">
                    @csrf
                    @method('POST')

                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-gray-900">{{ __('Verify Report') }}</h3>
                            <p class="text-sm text-gray-500">{{ __('Confirm this report is valid') }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="verify_note" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Verification Note (Optional)') }}</label>
                        <textarea name="verification_note"
                                  id="verify_note"
                                  rows="3"
                                  placeholder="{{ __('Add any notes about this verification...') }}"
                                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm resize-none"></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button"
                                @click="closeModal()"
                                class="flex-1 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit"
                                class="flex-1 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-all duration-200">
                            {{ __('Confirm Verify') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
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
         @open-reject-modal.window="openModal()"
         @keydown.escape.window="closeModal()"
         x-cloak
         class="fixed inset-0 z-[60] overflow-y-auto"
         role="dialog"
         aria-modal="true"
         aria-labelledby="reject-modal-title">

        <!-- Backdrop (Transparent with Blur) -->
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

        <!-- Modal Panel -->
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl relative z-[70]"
                 id="reject-modal-title">

                <form method="POST" action="{{ route('admin.bullying-reports.reject', $bullyingReport->id) }}">
                    @csrf
                    @method('POST')

                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-gray-900">{{ __('Reject Report') }}</h3>
                            <p class="text-sm text-gray-500">{{ __('This action requires a reason') }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="reject_note" class="block text-sm font-medium text-gray-700 mb-1.5">
                            {{ __('Rejection Reason') }} <span class="text-red-500">*</span>
                        </label>
                        <textarea name="verification_note"
                                  id="reject_note"
                                  rows="4"
                                  required
                                  minlength="10"
                                  placeholder="{{ __('Explain why this report is being rejected...') }}"
                                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm resize-none"></textarea>
                        <p class="text-xs text-gray-500 mt-1">{{ __('Minimum 10 characters') }}</p>
                    </div>

                    <div class="flex gap-3">
                        <button type="button"
                                @click="closeModal()"
                                class="flex-1 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit"
                                class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-all duration-200">
                            {{ __('Confirm Reject') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div x-data="{
    open: false,
    src: '',
    alt: '',
    openModal(src, alt) {
        this.open = true;
        this.src = src;
        this.alt = alt;
        document.body.style.overflow = 'hidden';
    },
    closeModal() {
        this.open = false;
        document.body.style.overflow = '';
    }
}"
         x-show="open"
         @open-image-modal.window="openModal($event.detail.src, $event.detail.alt)"
         @keydown.escape.window="closeModal()"
         x-cloak
         class="fixed inset-0 z-[60] overflow-y-auto"
         role="dialog"
         aria-modal="true">

        <!-- Backdrop (Transparent with Blur) -->
        <div x-show="open"
             @click="closeModal()"
             class="fixed inset-0 bg-slate-900/50 backdrop-blur-md transition-opacity">
        </div>

        <!-- Modal Panel -->
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="open"
                 class="relative max-w-4xl max-h-[90vh]">
                <button @click="closeModal()"
                        class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <img :src="src" :alt="alt" class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl">
            </div>
        </div>
    </div>
@endsection

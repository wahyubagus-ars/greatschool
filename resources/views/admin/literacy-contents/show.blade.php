@extends('layouts.admin')

@section('title', $literacyContent->title)

@section('page-header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.literacy-contents.index') }}"
               class="p-2 rounded-lg hover:bg-gray-100 transition-colors"
               title="Back to Literacy Content">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $literacyContent->title }}</h1>
                <p class="mt-1 text-gray-600">{{ $literacyContent->category }}</p>
            </div>
        </div>
        <div>
            @php
                $typeStyles = [
                    'article' => 'bg-blue-100 text-blue-700 border-blue-200',
                    'video' => 'bg-purple-100 text-purple-700 border-purple-200',
                ];
            @endphp
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium border {{ $typeStyles[$literacyContent->type] }}">
                @if($literacyContent->type === 'article')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                    </svg>
                @endif
                {{ ucfirst($literacyContent->type) }}
            </span>
        </div>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content (Left Column - 2/3 width) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Content Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-slate-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        Content Details
                    </h2>
                </div>
                <div class="p-6 space-y-5">
                    @if($literacyContent->thumbnail)
                        <div class="w-full h-64 rounded-lg overflow-hidden">
                            <img src="{{ $literacyContent->thumbnail }}"
                                 alt="{{ $literacyContent->title }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endif

                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Description</label>
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                            @if($literacyContent->content)
                                <p class="text-sm text-gray-800 whitespace-pre-line">{{ $literacyContent->content }}</p>
                            @elseif($literacyContent->url)
                                <p class="text-sm text-gray-800">
                                    This is a {{ $literacyContent->type }} content. View the content at:
                                    <a href="{{ $literacyContent->url }}"
                                       target="_blank"
                                       class="text-indigo-600 hover:text-indigo-800 underline">
                                        {{ Str::limit($literacyContent->url, 50) }}
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>

                    @if($literacyContent->platform || $literacyContent->platform_id)
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Platform Information</label>
                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @if($literacyContent->platform)
                                        <div>
                                            <p class="text-xs text-gray-500">Platform</p>
                                            <p class="text-sm font-medium text-gray-900 capitalize">{{ $literacyContent->platform }}</p>
                                        </div>
                                    @endif
                                    @if($literacyContent->platform_id)
                                        <div>
                                            <p class="text-xs text-gray-500">Platform ID</p>
                                            <p class="text-sm font-medium text-gray-900">{{ $literacyContent->platform_id }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar (Right Column - 1/3 width) -->
        <div class="space-y-6">
            <!-- Content Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-slate-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        Content Information
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Category</p>
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $literacyContent->category }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Created On</p>
                            <p class="text-sm font-medium text-gray-900">{{ $literacyContent->created_at->format('F d, Y \a\t H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Last Updated</p>
                            <p class="text-sm font-medium text-gray-900">{{ $literacyContent->updated_at->format('F d, Y \a\t H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 space-y-3">
                    @if($literacyContent->url)
                        <a href="{{ $literacyContent->url }}"
                           target="_blank"
                           class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-indigo-50 hover:bg-indigo-100 border border-indigo-300 text-indigo-700 font-medium rounded-lg transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                            View Content
                        </a>
                    @endif
                    <a href="{{ route('admin.literacy-contents.edit', $literacyContent->id) }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-300 text-slate-700 font-medium rounded-lg transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                        Edit Content
                    </a>
                    <form action="{{ route('admin.literacy-contents.destroy', $literacyContent->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Are you sure you want to delete this literacy content?')"
                                class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-white hover:bg-red-50 border border-red-300 text-red-700 font-medium rounded-lg transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m12 0a48.11 48.11 0 003.478-.397M12 12v.003m-3.75 6.75h.008v.008H12v-.008m0 0H15.75v.008m-3.75 0a2.25 2.25 0 10-4.5 0 2.25 2.25 0 004.5 0zm2.25-10.5h.008v.008H15.75v-.008m0 0V6A2.25 2.25 0 0013.5 3.75h-1.875c-.536 0-.955.416-.955.938v1.314c0 .522.419.938.955.938h1.875z" />
                            </svg>
                            Delete Content
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

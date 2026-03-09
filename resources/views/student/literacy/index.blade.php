@extends('layouts.student')

@section('title', 'Digital Literacy Resources')

@section('content')
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Digital Literacy Resources</h1>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">
                    Educational content from trusted platforms to help you grow safely online
                </p>
            </div>
        </div>

        <!-- Category Filter -->
        <div class="mt-6 flex flex-wrap gap-2">
            @foreach($categories as $cat)
                @php
                    $isActive = ($category ?? 'all') === $cat['slug'];
                @endphp
                <a href="{{ $cat['slug'] === 'all' ? route('student.literacy.index') : route('student.literacy.index', ['category' => $cat['slug']]) }}"
                   class="{{ $isActive ? 'bg-indigo-50 text-indigo-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} px-3 py-1.5 rounded-full text-xs font-medium transition-colors">
                    {{ $cat['label'] }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @forelse($contents as $content)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200">
                <!-- Thumbnail with platform badge -->
                <div class="relative group">
                    @if($content->thumbnail)
                        <img src="{{ $content->thumbnail }}"
                             alt="{{ $content->title }}"
                             class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105">
                    @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.582-8.06-8.06-8.06S4.5 6.69 4.5 11.15c0 1.68.563 3.246 1.538 4.5" />
                            </svg>
                        </div>
                @endif

                <!-- Platform badge -->
                    <div class="absolute top-2 right-2">
                    <span class="px-2 py-1 text-[10px] font-medium text-white rounded-full
                        {{ $content->platform === 'youtube' ? 'bg-red-500' :
                           ($content->platform === 'tiktok' ? 'bg-black' :
                           ($content->platform === 'instagram' ? 'bg-gradient-to-r from-[#405de6] via-[#5851db] to-[#c13584]' :
                           ($content->platform === 'medium' ? 'bg-green-600' : 'bg-gray-500'))) }}">
                        {{ ucfirst($content->platform ?? 'External') }}
                    </span>
                    </div>
                </div>

                <!-- Content Info -->
                <div class="p-4">
                    <div class="flex items-center mb-2">
                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-{{ $content->type === 'video' ? 'blue' : 'green' }}-50 text-{{ $content->type === 'video' ? 'blue' : 'green' }}-700">
                        {{ ucfirst($content->type) }}
                    </span>
                        @if($content->category)
                            <span class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-700">
                            {{ $content->category === 'anti-bullying' ? 'Anti-Bullying' :
                                ($content->category === 'digital-literacy' ? 'Digital Literacy' :
                                ($content->category === 'mental-health' ? 'Mental Health' :
                                ($content->category === 'school-safety' ? 'School Safety' : ucfirst(str_replace('-', ' ', $content->category))))) }}
                        </span>
                        @endif
                    </div>

                    <h3 class="font-semibold text-gray-800 line-clamp-2 hover:text-indigo-600 transition-colors min-h-[48px]">
                        <a href="{{ route('student.literacy.redirect', ['url' => $content->url]) }}"
                           target="_blank"
                           rel="noopener noreferrer nofollow"
                           class="block">
                            {{ $content->title }}
                        </a>
                    </h3>

                    <p class="mt-2 text-sm text-gray-500 line-clamp-2 min-h-[40px]">
                        {{ Str::limit($content->content ?? 'Educational content to help students navigate digital spaces safely', 100) }}
                    </p>

                    <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                        <div class="flex items-center text-xs text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <time datetime="{{ $content->created_at->toISO8601String() }}">
                                {{ $content->created_at->format('M j, Y') }}
                            </time>
                        </div>
                        <a href="{{ route('student.literacy.redirect', ['url' => $content->url]) }}"
                           target="_blank"
                           rel="noopener noreferrer nofollow"
                           class="flex items-center text-indigo-600 hover:text-indigo-700 text-sm font-medium transition-colors">
                            View Content
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border-2 border-dashed border-gray-300 p-8 text-center">
                <div class="mx-auto w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-1">No literacy resources available</h3>
                <p class="text-gray-500 max-w-md mx-auto">
                    @if($category && $category !== 'all')
                        No resources found in the "{{ $category === 'anti-bullying' ? 'Anti-Bullying' : ucfirst(str_replace('-', ' ', $category)) }}" category. Try viewing <a href="{{ route('student.literacy.index') }}" class="text-indigo-600 hover:underline">all content</a>.
                    @else
                        Your school administrators will add educational content from trusted platforms soon. Check back later!
                    @endif
                </p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($contents->hasPages())
        <div class="mt-8">
            {{ $contents->links() }}
        </div>
    @endif

    <!-- Safety Notice -->
    <div class="mt-10 p-4 bg-blue-50 rounded-xl border border-blue-100">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12v-.008z" />
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm text-blue-700">
                    <strong>Safety Notice:</strong> All external content opens in a new tab. Remember to:
                    <span class="block mt-1">
                    • Never share personal information<br>
                    • Report inappropriate content to your teacher<br>
                    • Close tabs that make you uncomfortable
                </span>
                </p>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .pagination {
            @apply flex items-center justify-center flex-wrap gap-1 mt-6;
        }
        .pagination a, .pagination span {
            @apply px-3 py-1.5 rounded-lg text-sm font-medium transition-all;
        }
        .pagination a {
            @apply bg-white border border-gray-300 text-gray-700 hover:bg-gray-50;
        }
        .pagination span {
            @apply bg-indigo-600 text-white;
        }
        .pagination .disabled {
            @apply opacity-50 cursor-not-allowed;
        }
    </style>
@endpush

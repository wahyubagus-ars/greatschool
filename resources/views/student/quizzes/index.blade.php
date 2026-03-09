@extends('layouts.student')

@section('title', 'Quizzes')

@section('page-header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Quizzes</h1>
            <p class="mt-1 text-gray-600">Test your knowledge and earn points for correct answers</p>
        </div>
    </div>
@endsection

@section('content')
    @if($quizzes->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
            <div class="mx-auto w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">No quizzes available</h3>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">
                Quizzes will be available soon. Complete literacy materials to unlock them and earn points!
            </p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($quizzes as $quiz)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <h2 class="text-lg font-semibold text-gray-900 line-clamp-2 min-h-[44px]">{{ $quiz->title }}</h2>
                            @if(in_array($quiz->id, $takenQuizIds))
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800 flex-shrink-0">
                                Completed
                            </span>
                            @else
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 flex-shrink-0">
                                Available
                            </span>
                            @endif
                        </div>

                        @if($quiz->category)
                            <p class="text-sm text-indigo-600 mb-2">{{ $quiz->category }}</p>
                        @endif

                        <p class="text-gray-600 text-sm line-clamp-2 min-h-[40px] mb-4">
                            {{ Str::limit($quiz->description, 100) }}
                        </p>

                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500 mb-4 pt-3 border-t border-gray-100">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h13.5m-13.5 3.75h13.5m-13.5 3.75h13.5M3 16.25V8.75a4 4 0 014-4h10a4 4 0 014 4v7.5M19.5 12h-15" />
                                </svg>
                                <span>{{ $quiz->questions_count ?? 0 }} questions</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $quiz->duration_minutes }} min</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-1.5 text-amber-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $quiz->points_per_quiz ?? 10 }} pts/question</span>
                            </div>
                        </div>

                        <a href="{{ route('student.quizzes.show', $quiz) }}"
                           class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium text-sm group">
                            View Details
                            <svg class="ml-1.5 w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection

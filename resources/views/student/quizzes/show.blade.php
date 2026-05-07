@extends('layouts.student')

@section('title', __('Quiz Details - :title', ['title' => $quiz->title]))

@section('page-header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $quiz->title }}</h1>
            @if($quiz->category)
                <p class="mt-1 text-indigo-600 font-medium">{{ $quiz->category }}</p>
            @endif
        </div>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-5 md:p-6">
            <div class="prose prose-gray max-w-none text-gray-700">
                <p>{{ $quiz->description }}</p>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center text-gray-500 mb-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h13.5m-13.5 3.75h13.5m-13.5 3.75h13.5M3 16.25V8.75a4 4 0 014-4h10a4 4 0 014 4v7.5M19.5 12h-15" />
                        </svg>
                        <span class="text-sm font-medium">{{ __('Questions') }}</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $quiz->questions_count ?? 0 }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center text-gray-500 mb-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">{{ __('Duration') }}</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $quiz->duration_minutes }} {{ __('minutes') }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center text-gray-500 mb-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 mr-2 text-amber-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">{{ __('Points') }}</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $quiz->points_per_quiz ?? 10 }} {{ __('per question') }}</p>
                </div>
            </div>

            @if($quiz->literacyContents->count() > 0)
                <div class="mt-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Required Literacy Materials') }}</h2>
                    <div class="space-y-3">
                        @foreach($quiz->literacyContents as $literacy)
                            <div class="flex items-start p-4 bg-gray-50 rounded-xl">
                                <div class="flex-shrink-0 mt-0.5">
                                    @if(in_array($literacy->id, $completedLiteracyIds))
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-400"></div>
                                    @endif
                                </div>
                                <div class="ml-3 flex-1 min-w-0">
                                    <a href="{{ route('student.literacy.show', $literacy) }}"
                                       class="font-medium text-indigo-600 hover:text-indigo-800 hover:underline block">
                                        {{ $literacy->title }}
                                    </a>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ __(ucfirst($literacy->type)) }} •
                                        {{ $literacy->category ? Str::headline($literacy->category) : 'General' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mt-10 pt-6 border-t border-gray-200">
                @if($taken)
                    <div class="bg-green-50 rounded-xl p-5 text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-100 mb-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="text-lg font-medium text-green-800">{{ __('Quiz Completed') }}</p>
                        <p class="mt-2 text-gray-600">{{ __('You\'ve already completed this quiz. View your results below.') }}</p>
                        <a href="{{ route('student.quizzes.result', $quiz) }}"
                           class="mt-4 inline-flex items-center justify-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-colors shadow-sm">
                            {{ __('View Results') }}
                        </a>
                    </div>
                @else
                    @if($allCompleted)
                        <form action="{{ route('student.quizzes.start', $quiz) }}" method="POST" class="text-center">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center justify-center px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-lg rounded-xl shadow-md transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full sm:w-auto">
                                {{ __('Start Quiz') }}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 ml-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                                </svg>
                            </button>
                            <p class="mt-3 text-sm text-gray-500">
                                {{ __('You have :minutes minutes to complete this quiz', ['minutes' => $quiz->duration_minutes]) }}
                            </p>
                        </form>
                    @else
                        <div class="bg-yellow-50 rounded-xl p-5 text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-yellow-100 mb-4">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <p class="text-lg font-medium text-yellow-800">{{ __('Complete Required Materials First') }}</p>
                            <p class="mt-2 text-gray-600">
                                {{ __('You need to view all required literacy materials before taking this quiz.') }}
                            </p>
                            <a href="{{ route('student.literacy.index') }}"
                               class="mt-4 inline-flex items-center justify-center px-5 py-2.5 bg-yellow-100 hover:bg-yellow-200 text-yellow-800 font-medium rounded-xl transition-colors">
                                {{ __('View Literacy Materials') }}
                            </a>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection

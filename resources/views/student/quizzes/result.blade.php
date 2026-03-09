@extends('layouts.student')

@section('title', 'Quiz Results - ' . $quiz->title)

@section('page-header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Quiz Results</h1>
            <p class="mt-1 text-gray-600">{{ $quiz->title }}</p>
        </div>
        <a href="{{ route('student.quizzes.index') }}"
           class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 min-w-[120px]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            All Quizzes
        </a>
    </div>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header with Score -->
            <div class="px-5 py-6 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-2xl bg-white/20 backdrop-blur-sm mb-4 p-3">
                <span class="text-3xl md:text-4xl font-bold text-white">
                    {{ $result->score }}<span class="text-indigo-200 mx-1">/</span>{{ $result->total_questions }}
                </span>
                </div>
                <h2 class="text-xl md:text-2xl font-bold">{{ $quiz->title }}</h2>
                @php
                    $percentage = ($result->score / $result->total_questions) * 100;
                    $isPassing = $percentage >= 70;
                @endphp
                <div class="mt-3 flex items-center justify-center space-x-2">
                    <span class="text-3xl font-bold">{{ number_format($percentage, 0) }}%</span>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                    @if($isPassing) bg-green-100 text-green-800 @else bg-amber-100 text-amber-800 @endif">
                    {{ $isPassing ? 'Passed' : 'Needs Improvement' }}
                </span>
                </div>
            </div>

            <!-- Points Earned -->
            <div class="px-5 py-6 border-b border-gray-200 text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-50 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-7 h-7 text-green-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-lg font-bold text-gray-900">You earned <span class="text-green-600">{{ $result->points_earned }}</span> points!</p>
                <p class="mt-1 text-gray-600">
                    @if($result->score > 0)
                        {{ $result->score }} correct answer{{ $result->score > 1 ? 's' : '' }} × {{ $quiz->points_per_quiz ?? 10 }} pts each
                    @else
                        No correct answers this time. Review the materials and try again!
                    @endif
                </p>
            </div>

            <!-- Performance Summary -->
            <div class="p-5 md:p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-sm font-medium text-gray-500">Correct Answers</p>
                        <p class="mt-1 text-2xl font-bold text-green-600">{{ $result->score }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-sm font-medium text-gray-500">Total Questions</p>
                        <p class="mt-1 text-2xl font-bold text-gray-800">{{ $result->total_questions }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-sm font-medium text-gray-500">Points Earned</p>
                        <p class="mt-1 text-2xl font-bold text-indigo-600">{{ $result->points_earned }}</p>
                    </div>
                </div>

                <!-- Encouragement Message -->
                <div class="bg-{{ $isPassing ? 'green' : 'amber' }}-50 rounded-xl p-4 mb-6 border border-{{ $isPassing ? 'green' : 'amber' }}-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-{{ $isPassing ? 'green' : 'amber' }}-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-{{ $isPassing ? 'green' : 'amber' }}-800">
                                {{ $isPassing ? 'Great job!' : 'Keep practicing!' }}
                            </p>
                            <p class="mt-1 text-sm text-{{ $isPassing ? 'green' : 'amber' }}-700">
                                @if($isPassing)
                                    You've demonstrated strong understanding of this topic. Keep up the excellent work!
                                @else
                                    Don't worry—every expert was once a beginner. Review the literacy materials and try again to improve your score.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="space-y-3">
                    <a href="{{ route('student.dashboard') }}"
                       class="block w-full px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl text-center transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Return to Dashboard
                    </span>
                    </a>

                    <a href="{{ route('student.literacy.index') }}"
                       class="block w-full px-5 py-3 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium rounded-xl text-center transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                        Review Literacy Materials
                    </span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Points Updated Notification -->
        <div class="mt-6 bg-blue-50 rounded-xl p-4 border border-blue-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-blue-800">Points Updated</p>
                    <p class="mt-1 text-sm text-blue-700">
                        Your total points have been updated to
                        <span class="font-bold text-blue-900">{{ Auth::guard('student')->user()->total_points }}</span>
                        in your dashboard.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

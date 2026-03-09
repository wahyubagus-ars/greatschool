@extends('layouts.student')

@section('content')
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $quiz->title }}</h1>
                    @if($quiz->category)
                        <p class="text-sm text-gray-500 mt-1">{{ $quiz->category }}</p>
                    @endif
                </div>
                <div class="p-6">
                    <p class="text-gray-700">{{ $quiz->description }}</p>

                    <div class="mt-6 grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-500">Duration:</span>
                            <span class="ml-2 text-gray-900">{{ $quiz->duration_minutes }} minutes</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-500">Points:</span>
                            <span class="ml-2 text-gray-900">{{ $quiz->points_per_quiz }}</span>
                        </div>
                    </div>

                    @if($quiz->literacyContents->count() > 0)
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Required Literacy Materials</h3>
                            <div class="space-y-2">
                                @foreach($quiz->literacyContents as $literacy)
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <div class="flex-1">
                                            <a href="{{ route('student.literacy.show', $literacy) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                                {{ $literacy->title }}
                                            </a>
                                            <p class="text-xs text-gray-500">{{ ucfirst($literacy->type) }}</p>
                                        </div>
                                        @if(in_array($literacy->id, $completedLiteracyIds))
                                            <span class="text-green-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </span>
                                        @else
                                            <span class="text-gray-400">Not viewed</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-8">
                        @if($taken)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <p class="text-green-800">You have already completed this quiz.</p>
                                <a href="{{ route('student.quizzes.result', $quiz) }}" class="mt-2 inline-flex items-center text-indigo-600">
                                    View your result
                                </a>
                            </div>
                        @else
                            @if($allCompleted)
                                <form action="{{ route('student.quizzes.start', $quiz) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg hover:bg-indigo-700 transition">
                                        Start Quiz
                                    </button>
                                </form>
                            @else
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <p class="text-yellow-800">Complete all required literacy materials to unlock this quiz.</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

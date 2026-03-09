@extends('layouts.student')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Quizzes</h1>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($quizzes as $quiz)
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <h2 class="text-lg font-medium text-gray-900">{{ $quiz->title }}</h2>
                                @if(in_array($quiz->id, $takenQuizIds))
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Completed</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Available</span>
                                @endif
                            </div>
                            @if($quiz->category)
                                <p class="text-sm text-gray-500 mt-1">{{ $quiz->category }}</p>
                            @endif
                            <p class="text-sm text-gray-600 mt-3 line-clamp-2">{{ $quiz->description }}</p>
                            <div class="mt-4 flex justify-between text-sm text-gray-500">
                                <span>{{ $quiz->questions_count ?? 0 }} questions</span>
                                <span>{{ $quiz->duration_minutes }} min</span>
                            </div>
                            <a href="{{ route('student.quizzes.show', $quiz) }}" class="mt-4 inline-flex items-center text-indigo-600 hover:text-indigo-900">
                                View Details
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@extends('layouts.student')

@section('content')
    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-indigo-600 text-white">
                    <h2 class="text-xl font-bold">Quiz Result</h2>
                </div>
                <div class="p-6 text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-indigo-100 text-indigo-600 mb-4">
                        <span class="text-3xl font-bold">{{ $result->score }}/{{ $result->total_questions }}</span>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $quiz->title }}</h3>
                    <p class="mt-2 text-gray-600">You earned <span class="font-bold text-indigo-600">{{ $result->points_earned }}</span> points.</p>
                    <div class="mt-6">
                        <a href="{{ route('student.quizzes.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Back to Quizzes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

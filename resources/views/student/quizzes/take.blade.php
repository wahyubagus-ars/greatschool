@extends('layouts.student')

@section('title', 'Take Quiz - ' . $quiz->title)

@section('content')
    {{-- CRITICAL: Register component BEFORE x-data element --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('quizComponent', (initialSeconds, currentQuestionId, savedAnswers, storeAnswerUrl, csrfToken) => ({
                // CRITICAL FIX: Parse as integer to prevent floating-point errors
                time: parseInt(initialSeconds, 10),
                timerInterval: null,
                selectedOption: savedAnswers[currentQuestionId] || null,
                formattedTime: '',

                initTimer() {
                    this.updateFormattedTime();

                    // CRITICAL FIX: Clear any existing interval first (prevents multiple timers)
                    if (this.timerInterval) {
                        clearInterval(this.timerInterval);
                    }

                    this.timerInterval = setInterval(() => {
                        if (this.time <= 0) {
                            clearInterval(this.timerInterval);
                            document.getElementById('submit-form').submit();
                        } else {
                            // CRITICAL FIX: Decrement as integer only
                            this.time = Math.floor(this.time) - 1;
                            this.updateFormattedTime();
                        }
                    }, 1000);
                },

                updateFormattedTime() {
                    // CRITICAL FIX: Strict integer math for clean MM:SS display
                    const totalSeconds = Math.floor(this.time);
                    const mins = Math.floor(totalSeconds / 60);
                    const secs = totalSeconds % 60;
                    this.formattedTime = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
                },

                saveAnswer(questionId, optionId) {
                    this.selectedOption = optionId;

                    fetch(storeAnswerUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            question_id: questionId,
                            option_id: optionId
                        })
                    }).catch(error => {
                        console.warn('Failed to save answer:', error);
                    });
                },

                confirmSubmit() {
                    if (confirm('Are you sure you want to submit the quiz?\n\nYou cannot change answers after submission.')) {
                        document.getElementById('submit-form').submit();
                    }
                }
            }));
        });
    </script>

    <div class="py-6"
         x-data="quizComponent(
            {{ (int) $remainingSeconds }},  // CRITICAL: Cast to integer in PHP
            {{ $currentQuestion->id }},
            {{ json_encode($answers) }},
            '{{ route('student.quizzes.store-answer', $quiz) }}',
            '{{ csrf_token() }}'
         )"
         x-init="initTimer()">
        <!-- Rest of the view remains identical to your current version -->
        <div class="max-w-3xl mx-auto px-4">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Header with timer -->
                <div class="px-6 py-4 bg-indigo-600 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-xl font-bold">{{ $quiz->title }}</h1>
                        <p class="text-indigo-200 text-sm mt-1">Question {{ $currentIndex + 1 }} of {{ $totalQuestions }}</p>
                    </div>
                    <div class="text-2xl font-mono font-bold bg-indigo-700 px-4 py-2 rounded-lg"
                         :class="time <= 60 ? 'bg-red-500 animate-pulse' : ''"
                         x-text="formattedTime">
                    </div>
                </div>

                <!-- Question -->
                <div class="p-6">
                    <div class="mb-6">
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                            </svg>
                            Multiple Choice
                        </div>
                        <p class="text-gray-800 text-lg font-medium leading-relaxed">{{ $currentQuestion->question_text }}</p>
                    </div>

                    <!-- Options -->
                    <div class="space-y-3">
                        @foreach($currentQuestion->options->sortBy('display_order') as $option)
                            <label class="flex items-start p-4 border-2 rounded-xl cursor-pointer transition-all duration-200 hover:border-indigo-300"
                                   :class="selectedOption == {{ $option->id }}
                                       ? 'border-indigo-500 bg-indigo-50'
                                       : 'border-gray-200 hover:bg-gray-50'">
                                <input type="radio"
                                       name="option_{{ $currentQuestion->id }}"
                                       value="{{ $option->id }}"
                                       class="mt-1 h-5 w-5 text-indigo-600 focus:ring-indigo-500"
                                       :checked="selectedOption == {{ $option->id }}"
                                       @change="saveAnswer({{ $currentQuestion->id }}, {{ $option->id }})">
                                <span class="ml-3 text-gray-800 text-base">{{ $option->option_text }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Navigation -->
                <div class="px-6 py-4 bg-gray-50 border-t flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="text-sm text-gray-500">
                        <span class="font-medium">{{ $currentIndex + 1 }}</span> of <span class="font-medium">{{ $totalQuestions }}</span> questions
                    </div>

                    <div class="flex flex-wrap gap-3 justify-end">
                        @if($currentIndex > 0)
                            <form method="POST" action="{{ route('student.quizzes.navigate', $quiz) }}">
                                @csrf
                                <input type="hidden" name="direction" value="prev">
                                <button type="submit"
                                        class="px-4 py-2.5 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block mr-1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                    </svg>
                                    Previous
                                </button>
                            </form>
                        @endif

                        @if($currentIndex < $totalQuestions - 1)
                            <form method="POST" action="{{ route('student.quizzes.navigate', $quiz) }}">
                                @csrf
                                <input type="hidden" name="direction" value="next">
                                <button type="submit"
                                        class="px-4 py-2.5 bg-indigo-600 text-white rounded-xl font-medium hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Next
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block ml-1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </button>
                            </form>
                        @else
                            <button type="button"
                                    @click="confirmSubmit"
                                    class="px-4 py-2.5 bg-green-600 text-white rounded-xl font-medium hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Submit Quiz
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden form for auto-submit -->
        <form id="submit-form" method="POST" action="{{ route('student.quizzes.submit', $quiz) }}">@csrf</form>
    </div>

    {{-- Prevent accidental navigation --}}
    <script>
        window.addEventListener('beforeunload', (e) => {
            if (document.querySelector('[x-data="quizComponent"]')) {
                e.preventDefault();
                e.returnValue = 'You have an active quiz session. Are you sure you want to leave?';
            }
        });
    </script>
@endsection

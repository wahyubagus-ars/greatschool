@extends('layouts.student')

@section('title', 'Take Quiz - ' . $quiz->title)

@section('page-header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $quiz->title }}</h1>
            <p class="mt-1 text-gray-600">
                {{ $currentIndex + 1 }} of {{ $totalQuestions }} questions • {{ $quiz->duration_minutes }} minute{{ $quiz->duration_minutes > 1 ? 's' : '' }} remaining
            </p>
        </div>
        <div class="flex items-center bg-indigo-50 text-indigo-700 px-4 py-2 rounded-xl text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-1.5 flex-shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium">{{ $quiz->points_per_quiz ?? 10 }} pts/question</span>
        </div>
    </div>
@endsection

@section('content')
    {{-- CRITICAL: Register component BEFORE x-data element --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('quizComponent', (initialSeconds, currentQuestionId, savedAnswers, storeAnswerUrl, csrfToken) => ({
                time: parseInt(initialSeconds, 10),
                timerInterval: null,
                selectedOption: savedAnswers[currentQuestionId] || null,
                formattedTime: '',

                initTimer() {
                    this.updateFormattedTime();

                    if (this.timerInterval) {
                        clearInterval(this.timerInterval);
                    }

                    this.timerInterval = setInterval(() => {
                        if (this.time <= 0) {
                            clearInterval(this.timerInterval);
                            document.getElementById('submit-form').submit();
                        } else {
                            this.time = Math.floor(this.time) - 1;
                            this.updateFormattedTime();
                        }
                    }, 1000);
                },

                updateFormattedTime() {
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

    <div class="max-w-3xl mx-auto"
         x-data="quizComponent(
        {{ (int) $remainingSeconds }},
        {{ $currentQuestion->id }},
        {{ json_encode($answers) }},
        '{{ route('student.quizzes.store-answer', $quiz) }}',
        '{{ csrf_token() }}'
     )"
         x-init="initTimer()">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Progress Bar -->
            <div class="px-5 py-3 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">
                    Question {{ $currentIndex + 1 }} of {{ $totalQuestions }}
                </span>
                    <div class="text-sm font-medium text-indigo-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span x-text="formattedTime" :class="time <= 60 ? 'text-red-600 font-bold animate-pulse' : ''"></span>
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ (($currentIndex + 1) / $totalQuestions) * 100 }}%"></div>
                </div>
            </div>

            <!-- Question -->
            <div class="p-5 md:p-6">
                <div class="mb-6">
                    <div class="flex items-center text-sm text-indigo-600 font-medium mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Multiple Choice
                    </div>
                    <p class="text-lg md:text-xl font-semibold text-gray-900 leading-relaxed">
                        {{ $currentQuestion->question_text }}
                    </p>
                </div>

                <!-- Options -->
                <div class="space-y-3">
                    @foreach($currentQuestion->options->sortBy('display_order') as $option)
                        <label class="flex items-start p-4 border-2 rounded-xl cursor-pointer transition-all duration-200 hover:border-indigo-300"
                               :class="selectedOption == {{ $option->id }}
                                   ? 'border-indigo-500 bg-indigo-50'
                                   : 'border-gray-200 hover:bg-gray-50'">
                            <div class="flex-shrink-0 mt-0.5">
                                <input type="radio"
                                       name="option_{{ $currentQuestion->id }}"
                                       value="{{ $option->id }}"
                                       class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-0"
                                       :checked="selectedOption == {{ $option->id }}"
                                       @change="saveAnswer({{ $currentQuestion->id }}, {{ $option->id }})">
                            </div>
                            <span class="ml-3 text-gray-800 text-base font-medium">{{ $option->option_text }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Navigation -->
            <div class="px-5 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="text-sm text-gray-600">
                    <span class="font-medium text-gray-900">{{ $currentIndex + 1 }}</span> of <span class="font-medium text-gray-900">{{ $totalQuestions }}</span> questions
                </div>

                <div class="flex flex-wrap gap-3">
                    @if($currentIndex > 0)
                        <form method="POST" action="{{ route('student.quizzes.navigate', $quiz) }}">
                            @csrf
                            <input type="hidden" name="direction" value="prev">
                            <button type="submit"
                                    class="inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 min-w-[110px]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-1.5">
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
                                    class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 min-w-[110px]">
                                Next
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 ml-1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </button>
                        </form>
                    @else
                        <button type="button"
                                @click="confirmSubmit"
                                class="inline-flex items-center justify-center px-5 py-2.5 bg-green-600 text-white font-medium rounded-xl hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 min-w-[140px]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l7.5-7.5m-7.5 7.5v6.75m0-6.75h6.75" />
                            </svg>
                            Submit Quiz
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Safety Notice -->
        <div class="mt-6 bg-amber-50 rounded-xl p-4 border border-amber-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-amber-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-amber-800">Quiz Rules</p>
                    <ul class="mt-1 text-sm text-amber-700 space-y-1">
                        <li class="flex items-start">
                            <span class="inline-flex items-center justify-center w-1.5 h-1.5 mr-2 mt-1 rounded-full bg-amber-400"></span>
                            <span>You have {{ $quiz->duration_minutes }} minute{{ $quiz->duration_minutes > 1 ? 's' : '' }} to complete this quiz</span>
                        </li>
                        <li class="flex items-start">
                            <span class="inline-flex items-center justify-center w-1.5 h-1.5 mr-2 mt-1 rounded-full bg-amber-400"></span>
                            <span>Unanswered questions will be marked incorrect</span>
                        </li>
                        <li class="flex items-start">
                            <span class="inline-flex items-center justify-center w-1.5 h-1.5 mr-2 mt-1 rounded-full bg-amber-400"></span>
                            <span>Points are awarded only for correct answers ({{ $quiz->points_per_quiz ?? 10 }} pts each)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden form for auto-submit --}}
    <form id="submit-form" method="POST" action="{{ route('student.quizzes.submit', $quiz) }}">@csrf</form>

    {{-- Prevent accidental navigation --}}
    <script>
        window.addEventListener('beforeunload', (e) => {
            if (document.querySelector('[x-data="quizComponent"]')) {
                e.preventDefault();
                e.returnValue = 'You have an active quiz session. Are you sure you want to leave? Your progress will be lost.';
            }
        });
    </script>
@endsection

@extends('layouts.admin')

@section('title', __('Bulk Upload Quizzes'))

@section('page-header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.quizzes.index') }}"
               class="p-2 rounded-lg hover:bg-gray-100 transition-colors"
               title="{{ __('Back to Quizzes') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ __('Bulk Upload') }}</h1>
                <p class="mt-1 text-gray-600">{{ __('Import quizzes via Excel') }}</p>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Upload Form (2/3 width) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Upload Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-slate-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25a2.25 2.25 0 002.25 2.25h13.5a2.25 2.25 0 002.25-2.25V16.5m-3 0v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75m3 0V12a2.25 2.25 0 012.25-2.25h2.25A2.25 2.25 0 0113.5 12v4.5" />
                        </svg>
                        {{ __('Upload Excel File') }}
                    </h2>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.quizzes.upload') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- File Upload -->
                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Excel File (.xlsx, .xls, .csv)') }}
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-slate-500 transition-colors cursor-pointer"
                                 id="dropzone">
                                <div class="space-y-1 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto h-12 w-12 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-3 0v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75m3 0V12a2.25 2.25 0 012.25-2.25h2.25A2.25 2.25 0 0113.5 12v4.5" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="file-upload"
                                               class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                            <span>{{ __('Upload a file') }}</span>
                                            <input id="file-upload"
                                                   name="file"
                                                   type="file"
                                                   accept=".xlsx,.xls,.csv"
                                                   required
                                                   class="sr-only">
                                        </label>
                                        <p class="pl-1">{{ __('or drag and drop') }}</p>
                                    </div>
                                    <p class="text-xs text-gray-500">{{ __('XLSX, XLS, CSV up to 10MB') }}</p>
                                    <p id="file-name" class="text-sm font-medium text-slate-700 mt-2"></p>
                                </div>
                            </div>
                            @error('file')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Info Box -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h3 class="text-sm font-medium text-blue-800">{{ __('Important Information') }}</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>{{ __('Maximum 500 rows per upload') }}</li>
                                            <li>{{ __('Required fields: Quiz Title, Points Per Quiz') }}</li>
                                            <li>{{ __('Date format must be YYYY-MM-DD HH:MM') }}</li>
                                            <li>{{ __('Question Type options: multiple_choice, true_false, short_answer') }}</li>
                                            <li>{{ __('Is Correct options: Yes or No') }}</li>
                                            <li>{{ __('Failed rows can be downloaded as error report') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center gap-3">
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-3 bg-slate-700 hover:bg-slate-800 text-white font-medium rounded-lg transition-all duration-200 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                {{ __('Upload & Import') }}
                            </button>
                            <a href="{{ route('admin.quizzes.download-template') }}"
                               class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium rounded-lg transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                {{ __('Download Template') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Failed Import Report (if exists) -->
            @if(session('failed_count') && session('failed_count') > 0)
                <div class="bg-white rounded-xl shadow-sm border border-amber-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-amber-200 bg-amber-50">
                        <h2 class="text-lg font-semibold text-amber-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            {{ __('Import Warnings') }}
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-amber-700">
                                <strong>{{ session('failed_count') }}</strong> {{ __(':count rows failed validation and were not imported.', ['count' => session('failed_count')]) }}
                            </p>
                            <a href="{{ route('admin.quizzes.download-failed-report', ['sessionId' => session('failed_session_id')]) }}"
                               class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-lg transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                {{ __('Download Error Report') }}
                            </a>
                        </div>
                        <div class="mt-4 text-sm text-amber-700">
                            <p>{{ __('The error report will show which rows failed validation and why.') }}</p>
                            <p class="mt-2">{{ __('Common issues:') }}</p>
                            <ul class="list-disc pl-5 mt-1 space-y-1">
                                <li>{{ __('Quiz Title mismatch between sheets') }}</li>
                                <li>{{ __('Invalid Points Per Quiz value (must be 1-100)') }}</li>
                                <li>{{ __('Incorrect date format (must be YYYY-MM-DD HH:MM)') }}</li>
                                <li>{{ __('Invalid Question Type') }}</li>
                                <li>{{ __('Invalid Is Correct value (must be Yes/No)') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Instructions Sidebar (1/3 width) -->
        <div class="space-y-6">

            <!-- Quick Guide -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-800">{{ __('Quick Guide') }}</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 font-bold text-sm">1</div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ __('Download Template') }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ __('Get the pre-formatted Excel template') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 font-bold text-sm">2</div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ __('Fill in Data') }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ __('Add your quizzes following the format') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 font-bold text-sm">3</div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ __('Upload File') }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ __('Upload and validate your Excel file') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 font-bold text-sm">4</div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ __('Review Results') }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ __('Check success/failure report') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Field Requirements -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-800">{{ __('Field Requirements') }}</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700">{{ __('Quiz Title') }}</span>
                            <span class="text-red-600 font-medium">{{ __('Required') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700">{{ __('Description') }}</span>
                            <span class="text-green-600 font-medium">{{ __('Optional') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700">{{ __('Points Per Quiz') }}</span>
                            <span class="text-red-600 font-medium">{{ __('Required') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700">{{ __('Start Date') }}</span>
                            <span class="text-green-600 font-medium">{{ __('Optional') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700">{{ __('End Date') }}</span>
                            <span class="text-green-600 font-medium">{{ __('Optional') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700">{{ __('Duration (Minutes)') }}</span>
                            <span class="text-green-600 font-medium">{{ __('Optional') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700">{{ __('Category') }}</span>
                            <span class="text-green-600 font-medium">{{ __('Optional') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700">{{ __('Question Text') }}</span>
                            <span class="text-red-600 font-medium">{{ __('Required') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700">{{ __('Question Type') }}</span>
                            <span class="text-red-600 font-medium">{{ __('Required') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700">{{ __('Option Text') }}</span>
                            <span class="text-red-600 font-medium">{{ __('Required') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700">{{ __('Is Correct') }}</span>
                            <span class="text-red-600 font-medium">{{ __('Required') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Question Types -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-800">{{ __('Question Types') }}</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                            <span class="text-sm text-gray-700">multiple_choice</span>
                            <span class="text-xs text-gray-500 ml-auto">{{ __('Standard multiple choice') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                            <span class="text-sm text-gray-700">true_false</span>
                            <span class="text-xs text-gray-500 ml-auto">{{ __('True/False questions') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="text-sm text-gray-700">short_answer</span>
                            <span class="text-xs text-gray-500 ml-auto">{{ __('Short answer questions') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // File upload preview
        const fileInput = document.getElementById('file-upload');
        const fileNameDisplay = document.getElementById('file-name');
        const dropzone = document.getElementById('dropzone');

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                fileNameDisplay.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
                dropzone.classList.add('border-slate-500', 'bg-slate-50');
            }
        });

        // Drag and drop
        dropzone.addEventListener('dragover', function(e) {
            e.preventDefault();
            dropzone.classList.add('border-slate-500', 'bg-slate-50');
        });

        dropzone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            dropzone.classList.remove('border-slate-500', 'bg-slate-50');
        });

        dropzone.addEventListener('drop', function(e) {
            e.preventDefault();
            dropzone.classList.remove('border-slate-500', 'bg-slate-50');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                fileNameDisplay.textContent = files[0].name + ' (' + (files[0].size / 1024 / 1024).toFixed(2) + ' MB)';
            }
        });
    </script>
@endsection

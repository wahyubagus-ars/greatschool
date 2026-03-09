@extends('layouts.student')

@section('title', 'New Bullying Report')

@section('page-header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Submit Bullying Report</h1>
            <p class="mt-1 text-gray-600">Provide accurate information to help us address bullying incidents effectively.</p>
        </div>
        <a href="{{ route('student.bullying-reports.index') }}"
           class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 min-w-[100px]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Back
        </a>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-5 py-4">
            <h2 class="text-lg font-medium text-gray-800">Report Details</h2>
            <p class="mt-1 text-sm text-gray-600">All fields marked with <span class="text-red-500">*</span> are required</p>
        </div>

        <form method="POST" action="{{ route('student.bullying-reports.store') }}" enctype="multipart/form-data" class="p-5 md:p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                <!-- Reporter Type -->
                <div>
                    <label for="reporter_type" class="block text-sm font-medium text-gray-700 mb-1.5">
                        I am a <span class="text-red-500">*</span>
                    </label>
                    <select name="reporter_type" id="reporter_type"
                            class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5 text-gray-800"
                            required>
                        <option value="">Select your role...</option>
                        <option value="victim" {{ old('reporter_type') == 'victim' ? 'selected' : '' }}>Victim</option>
                        <option value="witness" {{ old('reporter_type') == 'witness' ? 'selected' : '' }}>Witness</option>
                    </select>
                    @error('reporter_type')
                    <p class="mt-1.5 text-sm text-red-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Incident Date -->
                <div>
                    <label for="incident_date" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Date of Incident <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="incident_date" id="incident_date"
                           value="{{ old('incident_date') }}"
                           max="{{ date('Y-m-d') }}"
                           class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5"
                           required>
                    @error('incident_date')
                    <p class="mt-1.5 text-sm text-red-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title"
                           value="{{ old('title') }}"
                           placeholder="Brief summary of the incident (e.g., 'Pushed in hallway during lunch')"
                           class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5"
                           required>
                    @error('title')
                    <p class="mt-1.5 text-sm text-red-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Location -->
                <div class="md:col-span-2">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Location <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="location" id="location"
                           value="{{ old('location') }}"
                           placeholder="Specific location (e.g., '2nd floor hallway near restroom', 'Cafeteria table #4')"
                           class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5"
                           required>
                    @error('location')
                    <p class="mt-1.5 text-sm text-red-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="6"
                              placeholder="Provide detailed information about what happened. Include:&#10;- What exactly occurred&#10;- Who was involved (names if known)&#10;- When it happened&#10;- Any witnesses present&#10;- How it made you feel"
                              class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5 font-sans"
                              required>{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-1.5 text-sm text-red-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">
                        Your report is confidential. Only authorized school staff will review this information.
                    </p>
                </div>

                <!-- Evidence Upload -->
                <div class="md:col-span-2">
                    <label for="evidence" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Evidence (Photos, Videos, Documents) <span class="text-gray-400">(Optional)</span>
                    </label>
                    <div class="mt-1 flex justify-center px-4 pt-4 pb-5 border-2 border-gray-300 border-dashed rounded-xl">
                        <div class="text-center">
                            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                            </svg>
                            <div class="mt-3 flex text-sm text-gray-600 justify-center">
                                <label for="evidence" class="relative cursor-pointer bg-white rounded-lg font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 px-3 py-1.5 border border-gray-300">
                                    <span>Upload files</span>
                                    <input id="evidence" name="evidence[]" type="file" multiple class="sr-only" accept="image/*,.pdf,.doc,.docx,.txt">
                                </label>
                                <p class="pl-2">or drag and drop</p>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                PNG, JPG, GIF, PDF, DOC, DOCX (max 10MB per file)
                            </p>
                        </div>
                    </div>
                    @error('evidence')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                    @error('evidence.*')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row sm:justify-end gap-3">
                <a href="{{ route('student.bullying-reports.index') }}"
                   class="inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 min-w-[140px]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.77 59.77 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>
                    Submit Report
                </button>
            </div>
        </form>

        <div class="border-t border-gray-200 bg-gray-50 px-5 py-4 rounded-b-xl">
            <div class="flex items-start text-sm text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-indigo-600 mr-2 flex-shrink-0 mt-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12v-.008z" />
                </svg>
                <span>
                <strong class="text-gray-800">Confidentiality Notice:</strong>
                All reports are handled with strict confidentiality. Your identity will be protected to the fullest extent possible under school policy.
            </span>
            </div>
        </div>
    </div>
@endsection

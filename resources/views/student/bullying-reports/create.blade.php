@extends('layouts.student')

@section('title', 'New Bullying Report')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Submit Bullying Report</h1>
        <p class="text-gray-600">Please provide accurate information to help us address the issue.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('student.bullying-reports.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Reporter Type -->
                <div>
                    <label for="reporter_type" class="block text-sm font-medium text-gray-700 mb-1">I am a <span class="text-red-500">*</span></label>
                    <select name="reporter_type" id="reporter_type" class="w-full rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5" required>
                        <option value="">Select...</option>
                        <option value="victim" {{ old('reporter_type') == 'victim' ? 'selected' : '' }}>Victim</option>
                        <option value="witness" {{ old('reporter_type') == 'witness' ? 'selected' : '' }}>Witness</option>
                    </select>
                    @error('reporter_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Incident Date -->
                <div>
                    <label for="incident_date" class="block text-sm font-medium text-gray-700 mb-1">Date of Incident <span class="text-red-500">*</span></label>
                    <input type="date" name="incident_date" id="incident_date" value="{{ old('incident_date') }}" max="{{ date('Y-m-d') }}" class="w-full rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5" required>
                    @error('incident_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Brief summary of the incident" class="w-full rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5" required>
                    @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div class="md:col-span-2">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location <span class="text-red-500">*</span></label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" placeholder="Where did it happen?" class="w-full rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5" required>
                    @error('location')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="5" placeholder="Provide details about what happened..." class="w-full rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5" required>{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Evidence Upload -->
                <div class="md:col-span-2">
                    <label for="evidence" class="block text-sm font-medium text-gray-700 mb-1">Evidence (Photos, Videos, Documents) <span class="text-gray-400">(Optional)</span></label>
                    <input type="file" name="evidence[]" id="evidence" multiple class="w-full rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="mt-1 text-xs text-gray-500">Allowed: jpeg, png, jpg, gif, mp4, mov, avi, pdf, doc, docx (max 10MB per file)</p>
                    @error('evidence.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('student.bullying-reports.index') }}" class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Cancel</a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors shadow-sm">Submit Report</button>
            </div>
        </form>
    </div>
@endsection

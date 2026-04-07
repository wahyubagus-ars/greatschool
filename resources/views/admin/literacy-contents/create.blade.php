@extends('layouts.admin')

@section('title', 'Create Literacy Content')

@section('page-header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.literacy-contents.index') }}"
               class="p-2 rounded-lg hover:bg-gray-100 transition-colors"
               title="Back to Literacy Content">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Create New Content</h1>
                <p class="mt-1 text-gray-600">Add educational resources for students</p>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-800">Content Information</h2>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('admin.literacy-contents.store') }}" class="space-y-6">
                @csrf

                <!-- Type and Category -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1.5">Content Type <span class="text-red-500">*</span></label>
                            <select name="type"
                                    id="type"
                                    required
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 shadow-sm bg-white">
                                <option value="">Select Type</option>
                                <option value="article">Article</option>
                                <option value="video">Video</option>
                            </select>
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1.5">Category <span class="text-red-500">*</span></label>
                            <input type="text"
                                   name="category"
                                   id="category"
                                   required
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 shadow-sm">
                        </div>
                    </div>

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">Title <span class="text-red-500">*</span></label>
                        <input type="text"
                               name="title"
                               id="title"
                               required
                               maxlength="255"
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 shadow-sm"
                               placeholder="Enter content title">
                    </div>

                    <!-- Content or URL -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1.5">Content</label>
                            <textarea name="content"
                                      id="content"
                                      rows="6"
                                      class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 shadow-sm resize-y"
                                      placeholder="Enter article content (if applicable)"></textarea>
                            <p class="mt-1 text-xs text-gray-500">Required if URL is not provided</p>
                        </div>

                        <div>
                            <label for="url" class="block text-sm font-medium text-gray-700 mb-1.5">URL</label>
                            <input type="url"
                                   name="url"
                                   id="url"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 shadow-sm"
                                   placeholder="https://example.com">
                            <p class="mt-1 text-xs text-gray-500">Required if content is not provided</p>
                        </div>
                    </div>

                    <!-- Thumbnail -->
                    <div>
                        <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1.5">Thumbnail URL</label>
                        <input type="url"
                               name="thumbnail"
                               id="thumbnail"
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 shadow-sm"
                               placeholder="https://example.com/image.jpg">
                        <p class="mt-1 text-xs text-gray-500">Recommended size: 1200x630 pixels</p>
                    </div>

                    <!-- Platform Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="platform" class="block text-sm font-medium text-gray-700 mb-1.5">Platform</label>
                            <select name="platform"
                                    id="platform"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 shadow-sm bg-white">
                                <option value="">Select Platform (Optional)</option>
                                <option value="youtube">YouTube</option>
                                <option value="vimeo">Vimeo</option>
                                <option value="coursera">Coursera</option>
                                <option value="udemy">Udemy</option>
                                <option value="medium">Medium</option>
                                <option value="blog">Blog</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="platform_id" class="block text-sm font-medium text-gray-700 mb-1.5">Platform ID</label>
                            <input type="text"
                                   name="platform_id"
                                   id="platform_id"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-900 shadow-sm"
                                   placeholder="Video ID or article slug">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end gap-3 pt-4">
                        <a href="{{ route('admin.literacy-contents.index') }}"
                           class="px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-all duration-200">
                            Create Content
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

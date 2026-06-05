@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-2xl font-bold text-gray-800">Create New Post</h2>
            <p class="text-gray-600 mt-1">Write your thoughts and ideas</p>
        </div>

        <form action="{{ route('posts.store') }}" method="POST" id="post-form" class="p-6">
            @csrf

            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Enter post title" required>
            </div>

            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                <textarea name="content" id="content" rows="10" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Write your post content here..." required>{{ old('content') }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                <div class="flex gap-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="draft" {{ old('status', 'draft') === 'draft' ? 'checked' : '' }} class="form-radio text-yellow-500">
                        <span class="ml-2">📝 Draft</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="published" {{ old('status') === 'published' ? 'checked' : '' }} class="form-radio text-green-500">
                        <span class="ml-2">🚀 Publish Now</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition-all">
                    Create Post
                </button>
                <a href="{{ route('posts.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg transition-all">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const contentTextarea = document.getElementById('content');
    const postForm = document.getElementById('post-form');

    window.addEventListener('load', () => {
        const savedContent = localStorage.getItem('post_content_draft');
        if (savedContent) {
            contentTextarea.value = savedContent;
        }
    });

    contentTextarea.addEventListener('input', () => {
        localStorage.setItem('post_content_draft', contentTextarea.value);
    });

    postForm.addEventListener('submit', () => {
        localStorage.removeItem('post_content_draft');
    });
</script>
@endsection
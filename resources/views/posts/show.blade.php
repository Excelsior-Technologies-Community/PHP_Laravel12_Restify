@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $post->title }}</h2>
                <div class="mt-2 flex gap-2">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($post->status) }}
                    </span>
                    @if($post->trashed())
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">In Trash</span>
                    @endif
                </div>
            </div>
            
            <div class="flex gap-2">
                <button onclick="copyPostContent()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-all text-sm">
                    Copy Content
                </button>
                @if(!$post->trashed())
                    <a href="{{ route('posts.edit', $post) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition-all text-sm">
                        Edit
                    </a>
                @endif
                <a href="{{ route('posts.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition-all text-sm">
                    Back
                </a>
            </div>
        </div>

        <div class="p-6">
            <div class="text-sm text-gray-500 mb-4">
                <p>Created: {{ $post->created_at->format('F j, Y g:i A') }}</p>
                @if($post->published_at)
                    <p>Published: {{ $post->published_at->format('F j, Y g:i A') }}</p>
                @endif
            </div>
            
            <div class="border-t border-gray-200 pt-4">
                <div id="post-content" class="text-gray-700 leading-relaxed whitespace-pre-wrap">
                    {{ $post->content }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyPostContent() {
        const content = document.getElementById('post-content').innerText;
        navigator.clipboard.writeText(content).then(() => {
            alert('Post content copied to clipboard!');
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    }
</script>
@endsection
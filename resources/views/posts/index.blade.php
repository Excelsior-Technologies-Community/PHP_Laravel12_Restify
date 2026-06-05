@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Blog Posts Manager</h2>
        <div class="flex gap-2">
            <a href="{{ route('posts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all">Create New</a>
            <button id="bulk-delete-btn" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-all">Delete Selected</button>
        </div>
    </div>

    <form action="{{ route('posts.index') }}" method="GET" class="mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..." 
               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
    </form>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3"><input type="checkbox" id="select-all"></th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($posts as $post)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4"><input type="checkbox" class="post-checkbox" value="{{ $post->id }}"></td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            {{ $post->title }}
                            @if($post->trashed()) <span class="text-xs text-red-500 block">(In Trash)</span> @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm space-x-3">
                            <a href="{{ route('posts.show', $post) }}" class="text-blue-600 font-semibold">View</a>
                            @if($post->trashed())
                                <form action="{{ route('posts.restore', $post->id) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-green-600 font-semibold">Restore</button>
                                </form>
                            @else
                                <a href="{{ route('posts.edit', $post) }}" class="text-yellow-600 font-semibold">Edit</a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 font-semibold" onclick="return confirm('Trash?')">Trash</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-10 text-center text-gray-500">No posts found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $posts->links() }}
        </div>
    </div>
</div>

<script>
    $('#select-all').click(function() { $('.post-checkbox').prop('checked', this.checked); });
    $('#bulk-delete-btn').click(function() {
        let ids = $('.post-checkbox:checked').map(function() { return $(this).val(); }).get();
        if(ids.length > 0 && confirm('Delete selected?')) {
            $.post("{{ route('posts.bulk-delete') }}", { _token: "{{ csrf_token() }}", ids: ids }, () => location.reload());
        }
    });
</script>
@endsection
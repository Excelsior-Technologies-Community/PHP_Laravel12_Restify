<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index(Request $request)
{
    $query = Post::withTrashed()->orderBy('created_at', 'desc');

    if ($request->has('search') && !empty($request->search)) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    $posts = $query->paginate(10)->withQueryString();
    return view('posts.index', compact('posts'));
}

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        if ($validator->fails()) {
            return redirect()->route('posts.create')
                           ->withErrors($validator)
                           ->withInput();
        }

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('posts.show', $post)
                        ->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        if ($validator->fails()) {
            return redirect()->route('posts.edit', $post)
                           ->withErrors($validator)
                           ->withInput();
        }

        $updateData = [
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
        ];

        if ($request->status === 'published' && !$post->isPublished()) {
            $updateData['published_at'] = now();
        }

        $post->update($updateData);

        return redirect()->route('posts.show', $post)
                        ->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')
                        ->with('success', 'Post moved to trash!');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        Post::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => true]);
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        return redirect()->route('posts.show', $post)
                        ->with('success', 'Post restored successfully!');
    }

    public function forceDelete($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->forceDelete();
        return redirect()->route('posts.index')
                        ->with('success', 'Post permanently deleted!');
    }
}
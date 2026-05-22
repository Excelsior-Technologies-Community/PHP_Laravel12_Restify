<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     */
    public function index()
    {
        $posts = Post::withTrashed()->orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created post.
     */
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

    /**
     * Display the specified post.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified post.
     */
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

    /**
     * Remove the specified post.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        
        return redirect()->route('posts.index')
                        ->with('success', 'Post moved to trash!');
    }

    /**
     * Restore a soft-deleted post.
     */
    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        
        return redirect()->route('posts.show', $post)
                        ->with('success', 'Post restored successfully!');
    }

    /**
     * Permanently delete a post.
     */
    public function forceDelete($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->forceDelete();
        
        return redirect()->route('posts.index')
                        ->with('success', 'Post permanently deleted!');
    }
}
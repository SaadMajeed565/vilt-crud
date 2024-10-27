<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return Inertia::render('Index', ['posts' => $posts]);
    }

    public function create()
    {
        return Inertia::render('Create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' =>  'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath; // Add the image path to validated data
        }

        // Create the post with the validated data
        Post::create($validatedData);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        return Inertia::render('Edit', ['post' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Handle the image upload if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath; // Add the image path to validated data
        }

        // Use updateOrCreate
        $post = Post::updateOrCreate(
            ['id' => $post->id], // Criteria for finding the existing record
            $validatedData // Data to be updated or created
        );

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    public function show(Post $post)
    {
        return Inertia::render('View', ['post' => $post]);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }
}

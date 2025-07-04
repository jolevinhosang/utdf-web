<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $images = [];
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('posts', $filename, 'public');
                $images[] = 'posts/' . $filename;
            }
        }

        // Generate unique slug
        $baseSlug = Str::slug($request->title);
        $slug = $baseSlug;
        $counter = 1;
        while (\App\Models\Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $post = Post::create([
            'date' => $request->date,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'images' => $images,
            'slug' => $slug
        ]);

        return redirect()->route('posts.show', $post->slug)->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        return view('posts.dynamic-post', compact('post'));
    }

    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function edit($id)
    {
        $post = \App\Models\Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = \App\Models\Post::findOrFail($id);
        $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $images = $post->images;
        
        if ($request->hasFile('images')) {
            // Delete old images
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }
            
            // Upload new images
            $images = [];
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('posts', $filename, 'public');
                $images[] = 'posts/' . $filename;
            }
        }

        // Generate unique slug
        $baseSlug = Str::slug($request->title);
        $slug = $baseSlug;
        $counter = 1;
        while (\App\Models\Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $post->update([
            'date' => $request->date,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'images' => $images,
            'slug' => $slug
        ]);

        return redirect()->route('admin.posts')->with('success', 'Post updated successfully!');
    }

    public function destroy($id)
    {
        $post = \App\Models\Post::findOrFail($id);
        // Delete images from storage
        foreach ($post->images as $image) {
            Storage::disk('public')->delete($image);
        }
        
        $post->delete();
        
        return redirect()->route('admin.posts')->with('success', 'Post deleted successfully!');
    }

    public function setHero($id)
    {
        // Unset previous hero
        \App\Models\Post::where('is_hero', true)->update(['is_hero' => false]);
        // Set new hero
        $post = \App\Models\Post::findOrFail($id);
        $post->is_hero = true;
        $post->save();
        return redirect()->route('admin.posts')->with('success', 'Hero post updated!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['author', 'tags'])
            ->withCount('comments')
            ->where('is_published', true);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->input('category') !== 'All') {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('tag')) {
            $tag = $request->input('tag');
            $query->whereHas('tags', fn ($q) => $q->where('name', $tag));
        }

        $posts = $query->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(6)
            ->withQueryString();

        $tags = Tag::orderBy('name')->get();

        return view('posts.index', compact('posts', 'tags'));
    }

    public function create()
    {
        abort_unless(auth()->user()?->author, 403);

        $tags = Tag::orderBy('name')->get();
        $categories = ['Announcement', 'Health', 'Peace & Order', 'Ayuda', 'Youth & Sports'];

        return view('posts.create', compact('tags', 'categories'));
    }

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();
        $isPublished = $request->boolean('is_published');

        $post = $request->user()->author->posts()->create([
            'title'        => $validated['title'],
            'body'         => $validated['body'],
            'category'     => $validated['category'],
            'is_published' => $isPublished,
            'is_pinned'    => false,
            'published_at' => $isPublished ? now() : null,
            'views'        => 0,
        ]);

        $post->tags()->sync($validated['tags']);

        return redirect()->route('posts.index')
            ->with('status', 'Post published successfully.');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $post->increment('views');

        $post->load([
            'author',
            'tags',
            'comments' => fn ($query) => $query->latest()->with('user'),
        ]);

        return view('posts.show', compact('post'));
    }
}
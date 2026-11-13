<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorController extends Controller
{
    public function show(Author $author)
    {
        $author->load([
            'posts' => fn ($query) => $query
                ->where('is_published', true)
                ->with(['tags', 'author'])
                ->withCount('comments')
                ->orderByDesc('is_pinned')
                ->latest('published_at'),
        ])->loadCount('comments');

        return view('authors.show', compact('author'));
    }
}
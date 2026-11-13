@extends('layouts.app')
@section('title', $post->title . ' - Barangay Bulletin: Purok Flores')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-700 hover:text-emerald-900 transition">
        &larr; Back to all announcements
    </a>

    <article class="bg-white border border-emerald-100 rounded-2xl shadow-xs p-6 sm:p-8 space-y-5">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-emerald-50 pb-4">
            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                {{ $post->category }}
            </span>
            @if ($post->is_pinned)
                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 border border-amber-300">
                    📌 Pinned Bulletin
                </span>
            @endif
        </div>

        <h1 class="text-2xl sm:text-3xl font-extrabold text-emerald-950 tracking-tight leading-tight">
            {{ $post->title }}
        </h1>

        <div class="flex flex-wrap items-center gap-3 text-xs font-mono text-emerald-700">
            <span>By <a href="{{ route('authors.show', $post->author) }}" class="font-bold underline hover:text-emerald-950">{{ $post->author->name }}</a></span>
            <span>&middot;</span>
            <span>Published: {{ $post->published_at ? $post->published_at->format('F d, Y h:i A') : 'Draft' }}</span>
            <span>&middot;</span>
            <span>Views: {{ $post->views }}</span>
        </div>

        <div class="flex flex-wrap gap-1.5">
            @foreach($post->tags as $tag)
                <a href="{{ route('posts.index', ['tag' => $tag->name]) }}"
                   class="text-xs font-semibold px-2.5 py-0.5 rounded-md bg-emerald-50 text-emerald-800 border border-emerald-200 hover:bg-emerald-100 transition">
                    #{{ $tag->name }}
                </a>
            @endforeach
        </div>

        <div class="prose max-w-none text-slate-700 leading-relaxed text-sm sm:text-base border-t border-emerald-50 pt-5">
            {!! nl2br(e($post->body)) !!}
        </div>
    </article>

    <!-- Comments Section -->
    <section class="bg-white border border-emerald-100 rounded-2xl shadow-xs p-6 sm:p-8 space-y-6">
        <h2 class="text-lg font-extrabold text-emerald-950">
            Resident Comments ({{ $post->comments->count() }})
        </h2>

        @auth
            @if ($errors->any())
                <div class="rounded-xl bg-red-50 border border-red-200 p-3.5 text-xs text-red-800 space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('comments.store', $post) }}" class="space-y-3">
                @csrf
                <div>
                    <label for="body" class="block text-xs font-bold text-emerald-900 mb-1">Leave a comment as {{ auth()->user()->name }}</label>
                    <textarea id="body" name="body" rows="3" placeholder="Write your reply or question for Purok Flores..."
                        class="w-full rounded-xl border {{ $errors->has('body') ? 'border-red-400' : 'border-emerald-200' }} p-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition">
                    Post Comment
                </button>
            </form>
        @else
            <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-center text-xs text-emerald-800">
                <a href="{{ route('login') }}" class="font-bold underline hover:text-emerald-950">Sign in to comment</a> on this Purok Flores announcement.
            </div>
        @endauth

        <div class="divide-y divide-emerald-100">
            @forelse($post->comments as $comment)
                <div class="py-4 space-y-1">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-emerald-950">{{ $comment->user->name }}</span>
                        <span class="text-emerald-600">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-slate-700">{{ $comment->body }}</p>
                </div>
            @empty
                <p class="py-4 text-xs text-emerald-600">No comments yet. Be the first resident to reply!</p>
            @endforelse
        </div>
    </section>
</div>
@endsection
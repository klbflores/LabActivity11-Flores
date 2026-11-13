@extends('layouts.app')
@section('title', $author->name . ' - Barangay Bulletin: Purok Flores')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-700 hover:text-emerald-900">
        &larr; Back to Bulletin
    </a>

    <div class="bg-white border border-emerald-200 rounded-2xl p-6 sm:p-8 shadow-xs flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600">{{ $author->position }}</span>
            <h1 class="text-2xl sm:text-3xl font-black text-emerald-950 mt-1">{{ $author->name }}</h1>
            <p class="text-xs text-emerald-700 mt-1">{{ $author->email }}</p>
        </div>
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3 text-center">
            <span class="block text-xl font-black text-emerald-900">{{ $author->comments_count }}</span>
            <span class="text-xs font-semibold text-emerald-700">{{ $author->comments_count }} {{ Str::plural('comment', $author->comments_count) }} received</span>
        </div>
    </div>

    <h2 class="text-lg font-extrabold text-emerald-950">Published Announcements ({{ $author->posts->count() }})</h2>

    <div class="space-y-4">
        @forelse($author->posts as $post)
            <article class="bg-white border border-emerald-100 rounded-2xl p-5 shadow-xs space-y-2">
                <div class="flex items-center justify-between text-xs text-emerald-700">
                    <span class="font-semibold">{{ $post->category }}</span>
                    <span>{{ $post->published_at?->format('M d, Y') }} &middot; {{ $post->comments_count }} comments</span>
                </div>
                <h3 class="text-lg font-bold text-emerald-950">
                    <a href="{{ route('posts.show', $post->id) }}" class="hover:text-emerald-700">{{ $post->title }}</a>
                </h3>
                <div class="flex flex-wrap gap-1.5">
                    @foreach($post->tags as $tag)
                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded bg-emerald-50 text-emerald-800 border border-emerald-200">#{{ $tag->name }}</span>
                    @endforeach
                </div>
            </article>
        @empty
            <p class="text-sm text-emerald-700">This author has no published posts yet.</p>
        @endforelse
    </div>
</div>
@endsection
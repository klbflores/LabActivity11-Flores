@extends('layouts.app')
@section('title', 'Barangay Bulletin: Purok Flores')

@section('content')
<div class="space-y-6">
    <!-- Page Intro Header -->
    <div class="border-b border-emerald-800 pb-4">
        <h1 class="text-3xl font-black text-white tracking-tight">Community Announcements</h1>
        <p class="text-sm font-medium text-emerald-200 mt-1">Updates, health drives, and notices for Purok Flores residents.</p>
    </div>

    <!-- Search, Category & Tag Filters -->
    <form method="GET" action="{{ route('posts.index') }}" class="bg-white border border-emerald-100 rounded-2xl p-4 shadow-md flex flex-col md:flex-row gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Purok Flores announcements..."
            class="flex-1 rounded-xl border border-emerald-200 px-3.5 py-2 text-sm text-[#3b4e47] placeholder-[#6b7f77] focus:text-[#283832] focus:outline-none focus:ring-2 focus:ring-emerald-500">

        <select name="category" class="rounded-xl border border-emerald-200 px-3.5 py-2 text-sm text-[#3b4e47] bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <option value="All">All Categories</option>
            @foreach(['Announcement', 'Health', 'Peace & Order', 'Ayuda', 'Youth & Sports'] as $cat)
                <option value="{{ $cat }}" @selected(request('category') === $cat)>{{ $cat }}</option>
            @endforeach
        </select>

        <select name="tag" class="rounded-xl border border-emerald-200 px-3.5 py-2 text-sm text-[#3b4e47] bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <option value="">All Tags</option>
            @foreach($tags as $tag)
                <option value="{{ $tag->name }}" @selected(request('tag') === $tag->name)>#{{ $tag->name }}</option>
            @endforeach
        </select>

        <div class="flex gap-2">
            <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm px-5 py-2 rounded-xl transition cursor-pointer">
                Filter
            </button>
            @if(request()->hasAny(['search', 'category', 'tag']))
                <a href="{{ route('posts.index') }}" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-semibold text-sm px-4 py-2 rounded-xl border border-emerald-200 transition">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($posts as $post)
            <article class="bg-white border {{ $post->is_pinned ? 'border-amber-300 ring-2 ring-amber-300/60' : 'border-emerald-100' }} rounded-2xl p-5 shadow-lg flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                            {{ $post->category }}
                        </span>
                        @if($post->is_pinned)
                            <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-300">
                                📌 Pinned
                            </span>
                        @endif
                    </div>

                    <h2 class="text-lg font-extrabold text-emerald-950 leading-snug">
                        <a href="{{ route('posts.show', $post->id) }}" class="hover:text-emerald-700 transition">
                            {{ $post->title }}
                        </a>
                    </h2>

                    <p class="text-xs text-emerald-700">
                        By <a href="{{ route('authors.show', $post->author) }}" class="font-bold underline hover:text-emerald-950">{{ $post->author->name }}</a>
                        &middot; {{ $post->published_at?->format('M d, Y') }}
                    </p>

                    <p class="text-sm text-slate-600 line-clamp-3">
                        {{ Str::limit($post->body, 130) }}
                    </p>

                    <div class="flex flex-wrap gap-1.5 pt-1">
                        @foreach($post->tags as $tag)
                            <a href="{{ route('posts.index', ['tag' => $tag->name]) }}"
                               class="text-[11px] font-semibold px-2 py-0.5 rounded-md bg-emerald-50/80 text-emerald-800 border border-emerald-200 hover:bg-emerald-100 transition">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="pt-3 border-t border-emerald-50 flex items-center justify-between text-xs text-emerald-700 font-medium">
                    <span>{{ $post->views }} views &middot; {{ $post->comments_count }} {{ Str::plural('comment', $post->comments_count) }}</span>
                    <a href="{{ route('posts.show', $post->id) }}" class="font-bold text-emerald-700 hover:text-emerald-900">
                        Read &rarr;
                    </a>
                </div>
            </article>
        @empty
            <div class="col-span-full bg-white border border-emerald-100 rounded-2xl p-10 text-center text-emerald-800 font-medium">
                No announcements matched your filter.
            </div>
        @endforelse
    </div>

    <div class="pt-2">
        {{ $posts->links() }}
    </div>
</div>
@endsection
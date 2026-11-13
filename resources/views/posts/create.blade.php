@extends('layouts.app')
@section('title', 'New Announcement - Barangay Bulletin: Purok Flores')

@section('content')
<div class="max-w-2xl mx-auto bg-white border border-emerald-200 rounded-2xl shadow-sm p-6 sm:p-8 space-y-6">
    <div>
        <a href="{{ route('posts.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-900">&larr; Back to Bulletin</a>
        <h1 class="text-2xl font-black text-emerald-950 mt-2">Publish New Announcement</h1>
        <p class="text-xs text-emerald-700">Posting as {{ auth()->user()->author->name }}</p>
    </div>

    @if ($errors->any())
        <div class="rounded-xl bg-red-50 border border-red-200 p-4 text-xs text-red-800 space-y-1">
            <p class="font-bold">Please fix the following errors:</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('posts.store') }}" class="space-y-5">
        @csrf

        <div>
            <label for="title" class="block text-xs font-bold text-emerald-900 mb-1">Announcement Title</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}"
                class="w-full rounded-xl border {{ $errors->has('title') ? 'border-red-400' : 'border-emerald-200' }} px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
            @error('title')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="category" class="block text-xs font-bold text-emerald-900 mb-1">Category</label>
            <select id="category" name="category"
                class="w-full rounded-xl border {{ $errors->has('category') ? 'border-red-400' : 'border-emerald-200' }} px-3.5 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <option value="">-- Select a Category --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" @selected(old('category') === $cat)>{{ $cat }}</option>
                @endforeach
            </select>
            @error('category')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <span class="block text-xs font-bold text-emerald-900 mb-2">Tags (Select at least 1)</span>
            <div class="flex flex-wrap gap-3">
                @foreach($tags as $tag)
                    <label class="inline-flex items-center gap-2 text-xs font-semibold text-emerald-900 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-lg cursor-pointer">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                            @checked(in_array($tag->id, old('tags', [])))
                            class="rounded text-emerald-600 focus:ring-emerald-500">
                        #{{ $tag->name }}
                    </label>
                @endforeach
            </div>
            @error('tags')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
            @error('tags.*')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="body" class="block text-xs font-bold text-emerald-900 mb-1">Content (min. 20 characters)</label>
            <textarea id="body" name="body" rows="6"
                class="w-full rounded-xl border {{ $errors->has('body') ? 'border-red-400' : 'border-emerald-200' }} px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('body') }}</textarea>
            @error('body')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" id="is_published" name="is_published" value="1" @checked(old('is_published', true))
                class="rounded text-emerald-600 focus:ring-emerald-500">
            <label for="is_published" class="text-xs font-semibold text-emerald-900">Publish immediately to Purok Flores bulletin</label>
        </div>

        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm py-3 rounded-xl transition">
            Save Announcement
        </button>
    </form>
</div>
@endsection
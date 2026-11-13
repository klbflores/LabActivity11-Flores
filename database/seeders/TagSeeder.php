<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tagNames = [
            'Purok Flores',
            'Urgent',
            'Libre',
            'Schedule',
            'Bayanihan',
        ];

        $tags = collect($tagNames)->map(fn ($name) => Tag::create(['name' => $name]));

        $posts = Post::all();
        foreach ($posts as $post) {
            if ($post->is_pinned) {
                $pinnedTagIds = Tag::whereIn('name', ['Purok Flores', 'Urgent'])->pluck('id');
                $post->tags()->sync($pinnedTagIds);
            } else {
                $randomTagIds = $tags->random(rand(1, 3))->pluck('id');
                $post->tags()->attach($randomTagIds);
            }
        }
    }
}
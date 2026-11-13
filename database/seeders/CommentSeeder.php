<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $lola  = User::where('email', 'lola.flores@bulletin.test')->first();

        // Give every published non-pinned post 0-5 random comments
        $publishedPosts = Post::where('is_published', true)->where('is_pinned', false)->get();
        foreach ($publishedPosts as $post) {
            $count = rand(0, 5);
            if ($count > 0) {
                Comment::factory()->count($count)
                    ->sequence(fn () => ['user_id' => $users->random()->id])
                    ->create(['post_id' => $post->id]);
            }
        }

        // Give the pinned post at least 3 seeded comments
        $pinnedPost = Post::where('is_pinned', true)->first();
        if ($pinnedPost && $lola) {
            Comment::create([
                'post_id' => $pinnedPost->id,
                'user_id' => $lola->id,
                'body'    => 'Salamat kaayo Kagawad Kauri! Magdala ko og silhig ug sako unya.',
            ]);

            Comment::factory()->count(3)
                ->sequence(fn () => ['user_id' => $users->random()->id])
                ->create(['post_id' => $pinnedPost->id]);
        }
    }
}
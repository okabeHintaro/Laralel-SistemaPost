<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Arr;

class DummyDataSeeder extends Seeder
{

public function run()
{
    // Cria 10 usuários
    User::factory(10)->create();

    // Cria 50 posts
    Post::factory(50)->create()->each(function ($post) {
        // Adiciona entre 1 a 3 tags por post
        $tagNames = ['tecnologia', 'futebol', 'notícia', 'filmes', 'games', 'viagem'];
        $tagIds = [];

        foreach (Arr::random($tagNames, rand(1, 3)) as $name) {
            $tag = Tag::firstOrCreate(['name' => $name]);
            $tagIds[] = $tag->id;
        }

        $post->tags()->sync($tagIds);
    });

    // Likes falsos
    foreach (Post::all() as $post) {
    $users = User::inRandomOrder()->take(rand(0, 5))->get();
    foreach ($users as $user) {
        if (!$post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->create(['user_id' => $user->id]);
            $post->user->addEcos(2, 'Recebeu curtida no seeder');
        }
    }
}

}

}

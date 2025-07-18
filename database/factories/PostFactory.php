<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
{
    return [
        'title' => $this->faker->sentence,
        'content' => $this->faker->paragraph,
        'user_id' => \App\Models\User::inRandomOrder()->first()->id,
        'created_at' => now()->subDays(rand(0, 30)),
    ];
}

}

<?php

namespace Database\Factories;

use App\Models\Eco;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EcoFactory extends Factory
{
    protected $model = Eco::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(), // pega usuário aleatório ou cria
            'amount' => $this->faker->numberBetween(1, 5), // ecos de 1 a 5
            'reason' => $this->faker->randomElement([
                'curtida', 'post criado', 'comentário', 'outro motivo'
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

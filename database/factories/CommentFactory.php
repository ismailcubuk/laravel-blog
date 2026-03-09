<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        $user = User::query()->inRandomOrder()->first();

        return [
            'post_id' => Post::query()->inRandomOrder()->value('id') ?? Post::factory(),
            'user_id' => $user?->id,
            'name' => $user?->name ?? fake()->name(),
            'email' => $user?->email ?? fake()->unique()->safeEmail(),
            'message' => fake()->paragraph(),
            'status' => fake()->randomElement(['approved', 'approved', 'approved', 'pending', 'spam']),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'title' => $title,

            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(100,9999),

            'content' => fake()->paragraphs(3, true),

            'image' => null,

            'category_id' => Category::inRandomOrder()->first()->id 
                ?? Category::factory(),

            'user_id' => User::inRandomOrder()->first()->id
                ?? User::factory(),
        ];
    }
}

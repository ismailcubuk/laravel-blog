<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Category::factory(5)->create();

        Post::factory(20)->create();

        User::factory(5)->create();

    }
}

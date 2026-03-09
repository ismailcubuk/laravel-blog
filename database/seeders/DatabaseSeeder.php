<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\RoleUserSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PostSeeder::class,
            CommentSeeder::class,
            RoleUserSeeder::class,
        ]);
    }
}

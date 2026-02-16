<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PostSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(PostSeeder::class);
    }
}

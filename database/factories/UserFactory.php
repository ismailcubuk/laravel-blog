<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $avatars = [
            'assets/images/avatars/emma-carter.png',
            'assets/images/avatars/noah-bennett.png',
            'assets/images/avatars/mia-brooks.png',
            'assets/images/avatars/reader-one.png',
            'assets/images/avatars/reader-two.png',
        ];

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'avatar_path' => fake()->randomElement($avatars),
            'remember_token' => Str::random(10),
        ];
    }
}

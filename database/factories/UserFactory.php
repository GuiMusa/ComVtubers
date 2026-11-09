<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->userName(),
            'photo_de_profil' => $this->faker->imageUrl(200, 200, 'people', true, 'vtuber'),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => $this->faker->randomElement(['user', 'moderator']), // 'admin' est rare
            'is_admin' => false,
            'status' => $this->faker->randomElement(['actif', 'inactif', 'banni']), // Nouveau champ
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
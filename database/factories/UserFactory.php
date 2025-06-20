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
        return (function () {
            $number = fake()->unique()->numerify('#####'); // Generate a 5-digit number
            return [
                'username' => fake()->name(),
                'email' => $number . '@siswa.unimas.my',
                'email_verified_at' => now(),
                'password' => Hash::make('Student000#'),
                'usertype' => 'user',
                'status' => 'active',
                'user_id' => (int) $number, // Use the same number as user_id
                'remember_token' => Str::random(10),
            ];
        })();

    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

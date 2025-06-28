<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Application;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sessionId = 2; // or make this dynamic if needed

        // Step 1: Find a user with no application for this session
        $user = User::where('usertype', 'user')
            ->whereDoesntHave('application', function ($query) use ($sessionId) {
                $query->where('session_id', $sessionId);
            })
            ->inRandomOrder()
            ->first();

        // Step 2: If no such user, create a new one
        if (!$user) {
            $userId = fake()->unique()->numerify('#####');
            $user = User::factory()->create([
                'usertype' => 'user',
                'email' => $userId . '@siswa.unimas.my',
                'user_id' => $userId,
                'status' => 'active',
            ]);
        }

        $gender = fake()->randomElement(['male', 'female']);
        $blockOptions = $gender === 'male' ? ['C', 'D', 'E', 'F', 'G'] : ['H', 'I', 'J', 'K', 'L', 'M', 'N'];

        return [
            'user_id' => $user->id,
            'session_id' => $sessionId,
            'name' => $user->username,
            'student_id' => $user->user_id,
            'email' => $user->email, // <- safe to reuse because 1 application per session only
            'gender' => $gender,
            'faculty' => fake()->randomElement(['FEB', 'FE', 'FACA', 'FCSHD', 'FMHS', 'FSSH', 'FRST', 'FCSIT', 'FLC', 'FBE']),
            'program' => fake()->word(),
            'year_of_study' => fake()->numberBetween(1, 4),
            'contact_no' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'application_reason' => 'This is example application reason for testing purpose',
            'preferred_room_feature' => json_encode([
                'block' => fake()->randomElement($blockOptions),
                'floor' => fake()->randomElement(['G', '1', '2']),
                'room_type' => fake()->randomElement(['Single', 'Double', '4 Person']),
            ]),
            'application_status' => fake()->boolean(10) ? 'rejected' : 'approved',
        ];
    }


    
}

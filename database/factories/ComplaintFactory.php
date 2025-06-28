<?php

namespace Database\Factories;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ComplaintFactory extends Factory
{
    protected $model = Complaint::class;

    public function definition(): array
    {
        // Get or create a user with usertype 'resident'
        $user = User::where('usertype', 'resident')
            ->inRandomOrder()
            ->first() ?? User::factory()->create(['usertype' => 'resident']);

        // Category and conditional room name
        $category = $this->faker->randomElement(['house_room', 'other']);
        $roomName = $category === 'house_room'
            ? $this->faker->regexify('AG/\d{2}(/[A-Z])?') // Matches pattern like AG/01/A
            : null;

        return [
            'user_id'         => $user->id,
            'identify_number' => $user->user_id, // Student ID
            'name'            => $user->username ?? $this->faker->name(),
            'type'            => $this->faker->randomElement([
                'electrical', 'water_supply', 'civil', 'security', 'furniture', 'cleanliness', 'internet', 'other_type'
            ]),
            'description'     => 'This is example complaint description for testing purpose.',
            'category'        => $category,
            'room_name'       => $roomName,
            'appendix'      => json_encode([
                'attachments/XvixEanC8j6lDqFUC87nenbvWWezqA500Xw3RTmy.png',
                'attachments/XvixEanC8j6lDqFUC87nenbvWWezqA500Xw3RTmy.png',
            ]),
            'status'          => 'completed',
            'feedback'        => json_encode([
                [
                    'time' => Carbon::now()->toDateTimeString(),
                    'feedback' => 'this is example feedback for testing purpose',
                ],
            ]),
        ];
    }
}



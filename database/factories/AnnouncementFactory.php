<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Announcement>
 */
class AnnouncementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Announcement::class;
    
    public function definition(): array
    {
        $status = $this->faker->randomElement(['draft', 'published', 'scheduled']);

        return [
            'title' => 'Announcement ' . $this->faker->unique()->numberBetween(1, 100),
            'description' => 'This is example announcement description for testing purpose.',
            'status' => $status,
            'scheduled_at' => $status === 'scheduled' ? $this->faker->dateTimeBetween('+1 day', '+1 week') : null,
            'attachment' => $this->faker->boolean(70)
                ? json_encode([
                    'attachments/' . $this->faker->word() . '.pdf',
                    'attachments/' . $this->faker->word() . '.jpg'
                ])
                : null,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(['draft', 'published', 'scheduled']);

        return [
            'title' => 'Announcement ' . $this->faker->unique()->numberBetween(1, 100),
            'description' => 'This is example announcement description for testing purpose.',
            'status' => $status,
            'scheduled_at' => $status === 'scheduled'
                ? $this->faker->dateTimeBetween('+1 day', '+1 week')
                : null,
            'attachment' => json_encode([
                'attachments\FjMeo8x6yFdAbnQZJTSvOEK7tzB81P8jKbbzV0O4.png',
                'attachments\XvixEanC8j6lDqFUC87nenbvWWezqA500Xw3RTmy.png'
            ]),
        ];
    }
}

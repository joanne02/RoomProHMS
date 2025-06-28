<?php

namespace Database\Factories;

use App\Models\Facility;
use App\Models\FacilityType;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacilityFactory extends Factory
{
    protected $model = Facility::class;

    public function definition(): array
    {
        // Try to get a random existing FacilityType or create one if none exist
        $facilityType = FacilityType::inRandomOrder()->first() 
            ?? FacilityType::factory()->create();

        return [
            'name' => 'Facility ' . $this->faker->unique()->numberBetween(1, 100),
            'facility_type_id' => $facilityType->id,
            'description' => 'This is example facility description for testing purpose.',
            'status' => $this->faker->randomElement(['Good', 'Under Maintenance', 'Closed']),
            'image' => 'assets/images/others/placeholder.jpg',
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'name' => 'Ruangan '.fake()->unique()->numerify('##'),
            'code' => fake()->unique()->bothify('R-##'),
            'latitude' => fake()->randomFloat(7, -6.4120000, -6.3920000),
            'longitude' => fake()->randomFloat(7, 108.3620000, 108.3820000),
        ];
    }
}

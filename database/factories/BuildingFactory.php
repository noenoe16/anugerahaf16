<?php

namespace Database\Factories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Building>
 */
class BuildingFactory extends Factory
{
    protected $model = Building::class;

    public function definition(): array
    {
        $name = 'Gedung '.fake()->unique()->word();

        return [
            'name' => $name,
            'code' => fake()->unique()->bothify('B-###'),
            'latitude' => fake()->randomFloat(7, -6.4120000, -6.3920000),
            'longitude' => fake()->randomFloat(7, 108.3620000, 108.3820000),
            'address' => 'Kilang Pertamina Internasional RU VI Balongan',
        ];
    }
}

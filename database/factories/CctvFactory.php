<?php

namespace Database\Factories;

use App\Models\Cctv;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Cctv>
 */
class CctvFactory extends Factory
{
    protected $model = Cctv::class;

    public function definition(): array
    {
        $octet = fake()->numberBetween(10, 250);

        return [
            'name' => 'CCTV '.fake()->unique()->numerify('###'),
            'ip_address' => "rtsp://admin:password.123@10.56.236.$octet/streaming/channels/",
            'status' => fake()->randomElement(['online', 'offline', 'maintenance']),
            'location_note' => fake()->sentence(3),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => '+62 '.fake()->numberBetween(1000000000, 9999999999),
            'whatsapp' => '+62 '.fake()->numberBetween(80000000000, 89999999999),
            'address' => 'Refinery Unit VI Balongan',
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'remaining_tickets' => fake()->numberBetween(0, 400),
            'is_published' => fake()->randomElement([0, 1]),
            'event_name' => fake()->name(),
            'event_description' => fake()->text(),
            'countrey' => fake()->country(),
            'state' => fake()->city(),
            'street' => fake()->streetName(),
            'place' => fake()->name(),
            'event_type' => fake()->randomElement(['medical', 'cultural', 'sport', 'technical', 'scientific', 'artistic', 'entertaining', 'commercial']),
            'start_date' => fake()->date('Y-m-d'),
            'end_date' => fake()->date('Y-m-d'),
            'tickets_number' => fake()->numberBetween(400, 800),
            'ticket_price' => fake()->numberBetween(1, 30),
            'is_done' => fake()->randomElement([0, 1]),
            'organization_id' => Organization::inRandomOrder()->first()->organization_id,
            // 'admin_id' => Admin::inRandomOrder()->first()->id

        ];
    }
}

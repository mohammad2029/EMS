<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\Speaker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Organization_speakerFactory extends Factory
{


    public function definition(): array
    {
        return [
            'speaker_start_date' => fake()->date('Y-m-d'),
            'speaker_id' => Speaker::inRandomOrder()->first()->speaker_id,
            'organization_id' => Organization::inRandomOrder()->first()->organization_id,
        ];
    }
}

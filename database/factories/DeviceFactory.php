<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid,
            'language_id' => \App\Models\Language::first()?->id ?: \App\Models\Language::factory()->lazy(),
            'operating_system_id' => \App\Models\OperatingSystem::first()?->id ?: \App\Models\OperatingSystem::factory()->lazy(),
        ];
    }
}

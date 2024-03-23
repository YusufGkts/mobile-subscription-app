<?php

namespace Database\Factories;

use App\Enums\PurchaseStatus;
use App\Enums\SubscriptionStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'app_id' => \App\Models\App::first()?->id ?: \App\Models\App::factory()->lazy(),
            'device_id' => \App\Models\Device::first()?->id ?: \App\Models\Device::factory()->lazy(),
            'client_token' => $this->faker->uuid,
            'status' => $this->faker->randomElement(SubscriptionStatus::cases()),
            'expires_at' => now()->addDay(),
        ];
    }
}

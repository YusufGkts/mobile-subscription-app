<?php

namespace Database\Factories;

use App\Enums\PurchaseStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subscription_id' => \App\Models\Subscription::first()?->id ?: \App\Models\Subscription::factory()->lazy(),
            'receipt' => $this->faker->text,
            'status' => $this->faker->randomElement(PurchaseStatus::cases()),
            'expires_at' => now()->addDay(),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'supplier_name' => fake()->name(),
            'item_code' => fake()->name(),
            'quantity' => 1,
            'status' => 'pending',
            'date_schedule' => '111',
            'barcode' => '1234'
        ];
    }
}

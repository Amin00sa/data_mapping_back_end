<?php

namespace Database\Factories;

use App\Models\Entry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DataEntry>
 */
class DataEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $entry = Entry::factory()->create()->id;
        return [
            'id' => fake()->uuid,
            'key' => fake()->name,
            'value' => fake()->name,
            'entry_id' => $entry
        ];
    }
}

<?php

namespace Database\Factories;

use App\Enums\TypeDataEnum;
use App\Models\Entry;
use App\Models\ExternalDataBase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Entry>
 */
class EntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ExternalDataBases = ExternalDataBase::factory()->create()->id;
        return [
            'id' => fake()->uuid,
            'name' => fake()->name,
            'type' => fake()->randomElement(getEnumValues(TypeDataEnum::class)),
            'external_data_base_id' => $ExternalDataBases
        ];
    }
}

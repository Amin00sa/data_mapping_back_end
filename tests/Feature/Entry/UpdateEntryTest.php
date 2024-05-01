<?php

use App\Models\Entry;
use Illuminate\Http\Response;
use App\Enums\TypeDataEnum;

it('update an entry', function () {

    $entry = Entry::factory()->create();

    $updatedData = [
        'name' => fake()->word,
        'type' => fake()->randomElement(getEnumValues(TypeDataEnum::class))
    ];

    $this->putJson(route('entries.update', $entry->id), $updatedData)
        ->assertStatus(Response::HTTP_OK)
        ->assertOk();
});

it('update an entry with missing param', function () {
    $entry = Entry::factory()->create();

    $updatedData = [];

    $this->putJson(route('entries.update', $entry->id), $updatedData)
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonStructure(['errors']);
});

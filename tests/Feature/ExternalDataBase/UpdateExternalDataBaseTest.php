<?php

use App\Models\Entry;
use App\Models\ExternalDataBase;
use Illuminate\Http\Response;
use App\Enums\TypeDataEnum;

it('update an externalDataBase', function () {

    $externalDataBase = ExternalDataBase::factory()->create();
    $entry = Entry::factory()->create();

    $updatedData = [
        'name' => fake()->name,
        'entries' => [
            [
                'name' => fake()->word,
                'type' => fake()->randomElement(getEnumValues(TypeDataEnum::class)),
                'id' => null,
            ], [
                'name' => $entry->name,
                'type' => fake()->randomElement(getEnumValues(TypeDataEnum::class)),
                'id' => $entry->id,
            ]
        ],
        'entriesToBeDeleted' => []
    ];

    $this->postJson(route('databases.update', $externalDataBase->id), $updatedData)
        ->assertStatus(Response::HTTP_OK)
        ->assertOk();
});

it('update an externalDataBase with missing param', function () {
    $externalDataBase = ExternalDataBase::factory()->create();

    $updatedData = [];

    $this->postJson(route('databases.update', $externalDataBase->id), $updatedData)
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonStructure(['errors']);
});

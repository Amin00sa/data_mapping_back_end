<?php

use App\Enums\TypeDataEnum;
use Illuminate\Http\Response;

it('create a new externalDataBase', function () {
    $externalDataBase = [
        'name'    => fake()->word,
        'entries' => [
            [
                'name' => fake()->word,
                'type' => fake()->randomElement(getEnumValues(TypeDataEnum::class)),
            ],
        ],
    ];

    $this->postJson(route('databases.store'), $externalDataBase)
        ->assertStatus(Response::HTTP_CREATED)
        ->assertJsonStructure(
            [
                'externalDataBase' => [
                    'id',
                    'name',
                    'created_at',
                ],
            ]
        );
});

it('create a new externalDataBase with missing param', function () {
    $externalDataBase = [];

    $this->postJson(route('databases.store'), $externalDataBase)
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonStructure(['errors']);
});

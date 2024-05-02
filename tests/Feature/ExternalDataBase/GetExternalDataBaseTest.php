<?php

use App\Models\ExternalDataBase;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

it('get an existing externalDataBase', function () {
    $externalDataBase = ExternalDataBase::factory()->create();

    $this->getJson(route('databases.show', $externalDataBase->id))
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'externalDataBase' => [
                    'id',
                    'name',
                    'created_at',
                ],
            ]
        )
        ->assertOk();
});

it('get an non existing externalDataBase', function () {
    $this->getJson(route('databases.show', Str::uuid()))
        ->assertStatus(Response::HTTP_NOT_FOUND)
        ->assertNotFound();
});

<?php

use App\Models\ExternalDataBase;
use Illuminate\Http\Response;

it('get all externalDatabases with entries and entriesCount and dataEntriesCount', function () {
    ExternalDataBase::factory()->count(5)->create();

    $data = [
        'filter[name]' => fake()->name,
        'includes' => "entries,entriesCount,dataEntriesCount",
    ];

    $this->getJson(route('databases.index', $data))
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'externalDataBases' => [
                    '*' => [
                        'id',
                        'name',
                        'created_at',
                        'entries',
                        'entries_count',
                        'data_entries_count'
                    ]]
            ])
        ->assertOk();
});

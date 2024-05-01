<?php

use App\Models\ExternalDataBase;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

it('delete an existing database', function () {
    $database = ExternalDataBase::factory()->create();

    $this->deleteJson(route('databases.destroy', $database->id))
        ->assertStatus(Response::HTTP_OK)
        ->assertOk();

    $this->assertSoftDeleted($database);
});

it('delete an non existing database', function () {
    $this->deleteJson(route('databases.destroy', Str::uuid()))
        ->assertStatus(Response::HTTP_NOT_FOUND)
        ->assertNotFound();
});

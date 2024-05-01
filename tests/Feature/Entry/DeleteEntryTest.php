<?php

use App\Models\Entry;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

it('delete an existing entry', function () {
    $entry = Entry::factory()->create();

    $this->deleteJson(route('entries.destroy', $entry->id))
        ->assertStatus(Response::HTTP_OK)
        ->assertOk();

    $this->assertSoftDeleted($entry);
});

it('delete an non existing entry', function () {
    $this->deleteJson(route('entries.destroy', Str::uuid()))
        ->assertStatus(Response::HTTP_NOT_FOUND)
        ->assertNotFound();
});

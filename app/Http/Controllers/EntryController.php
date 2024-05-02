<?php

namespace App\Http\Controllers;

use App\Actions\Entry\CreateEntryAction;
use App\Actions\Entry\DeleteEntryAction;
use App\Actions\Entry\GetDataEntriesAction;
use App\Actions\Entry\UpdateEntryAction;
use App\Http\Requests\EntryStoreRequest;
use App\Http\Resources\Entry\EntryResource;
use App\Models\Entry;
use Illuminate\Http\JsonResponse;

class EntryController extends Controller
{
    /**
     * @param EntryStoreRequest $entryStoreRequest
     * @param CreateEntryAction $createEntryAction
     *
     * @return EntryResource
     */
    public function store(EntryStoreRequest $entryStoreRequest, CreateEntryAction $createEntryAction): EntryResource
    {
        return EntryResource::make($createEntryAction->execute($entryStoreRequest->validated()));
    }

    /**
     * @param Entry $entry
     * @param EntryStoreRequest $entryStoreRequest
     * @param UpdateEntryAction $updateEntryAction
     *
     * @return JsonResponse
     */
    public function update(
        Entry $entry,
        EntryStoreRequest $entryStoreRequest,
        UpdateEntryAction $updateEntryAction
    ): JsonResponse {
        return response()->json(
            [
                'status' => $updateEntryAction->execute($entry, $entryStoreRequest->validated()),
            ]
        );
    }

    /**
     * @param Entry $entry
     * @param DeleteEntryAction $deleteExternalDataBaseAction
     *
     * @return JsonResponse
     */
    public function destroy(Entry $entry, DeleteEntryAction $deleteExternalDataBaseAction): JsonResponse
    {
        return response()->json(
            [
                'status' => $deleteExternalDataBaseAction->execute($entry),
            ]
        );
    }

    /**
     * @param Entry $entry
     * @param GetDataEntriesAction $getDataEntriesAction
     *
     * @return EntryResource
     */
    public function show(Entry $entry, GetDataEntriesAction $getDataEntriesAction): EntryResource
    {
        return EntryResource::make($getDataEntriesAction->execute($entry));
    }
}

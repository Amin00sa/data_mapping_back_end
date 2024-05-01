<?php

namespace App\Http\Controllers;

use App\Actions\DataEntries\DeleteDataEntriesAction;
use App\Actions\DataEntries\UpdateDataEntriesAction;
use App\Http\Requests\UpdateDataEntriesRequest;
use Illuminate\Http\JsonResponse;

class DataEntryController extends Controller
{
    /**
     * @param UpdateDataEntriesRequest $updateDataEntriesRequest
     * @param UpdateDataEntriesAction $updateEntriesAction
     * @return JsonResponse
     */
    public function update(UpdateDataEntriesRequest $updateDataEntriesRequest, UpdateDataEntriesAction $updateEntriesAction): JsonResponse
    {
        return response()->json([
            'status' => $updateEntriesAction->execute($updateDataEntriesRequest->validated()),
        ]);
    }

    /**
     * @param UpdateDataEntriesRequest $deleteDataEntriesRequest
     * @param DeleteDataEntriesAction $deleteDataEntriesAction
     * @return JsonResponse
     */
    public function delete(UpdateDataEntriesRequest $deleteDataEntriesRequest, DeleteDataEntriesAction $deleteDataEntriesAction): JsonResponse
    {

        return response()->json([
            'status' => $deleteDataEntriesAction->execute($deleteDataEntriesRequest->validated()),
        ]);
    }
}

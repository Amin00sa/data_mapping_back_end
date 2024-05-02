<?php

namespace App\Http\Controllers;

use App\Actions\ExternalDataBase\CreateExternalDataBaseAction;
use App\Actions\ExternalDataBase\DeleteExternalDataBaseAction;
use App\Actions\ExternalDataBase\GetAllExternalDataBaseAction;
use App\Actions\ExternalDataBase\GetDataEntriesAction;
use App\Actions\ExternalDataBase\GetExternalDataBaseAction;
use App\Actions\ExternalDataBase\UpdateExternalDataBaseAction;
use App\Http\Requests\ExternalDataBaseStoreRequest;
use App\Http\Requests\FilterDataEntriesRequest;
use App\Http\Requests\UpdateEntriesOfExternalDataBaseRequest;
use App\Http\Resources\ExternalDataBase\ExternalDataBaseCollection;
use App\Http\Resources\ExternalDataBase\ExternalDataBaseResource;
use App\Models\ExternalDataBase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ExternalDataBaseController extends Controller
{
    /**
     * @param Request $request
     * @param GetAllExternalDataBaseAction $getAllExternalDataBaseAction
     *
     * @return ExternalDataBaseCollection
     */
    public function index(
        Request $request,
        GetAllExternalDataBaseAction $getAllExternalDataBaseAction
    ): ExternalDataBaseCollection {
        return ExternalDataBaseCollection::make($getAllExternalDataBaseAction->execute($request->query()));
    }

    /**
     * @param ExternalDataBaseStoreRequest $externalDataBaseStoreRequest
     * @param CreateExternalDataBaseAction $createExternalDataBaseAction
     *
     * @return ExternalDataBaseResource
     */
    public function store(
        ExternalDataBaseStoreRequest $externalDataBaseStoreRequest,
        CreateExternalDataBaseAction $createExternalDataBaseAction
    ): ExternalDataBaseResource {
        return ExternalDataBaseResource::make(
            $createExternalDataBaseAction->execute($externalDataBaseStoreRequest->validated())
        );
    }

    /**
     * @param ExternalDataBase $externalDataBase
     * @param GetExternalDataBaseAction $getExternalDataBaseAction
     *
     * @return ExternalDataBaseResource
     */
    public function show(
        ExternalDataBase $externalDataBase,
        GetExternalDataBaseAction $getExternalDataBaseAction
    ): ExternalDataBaseResource {
        return ExternalDataBaseResource::make($getExternalDataBaseAction->execute($externalDataBase));
    }

    /**
     * @param ExternalDataBase $externalDataBase
     * @param UpdateEntriesOfExternalDataBaseRequest $updateEntriesOfExternalDataBaseRequest
     * @param UpdateExternalDataBaseAction $updateExternalDataBaseAction
     *
     * @return JsonResponse
     */
    public function update(
        ExternalDataBase $externalDataBase,
        UpdateEntriesOfExternalDataBaseRequest $updateEntriesOfExternalDataBaseRequest,
        UpdateExternalDataBaseAction $updateExternalDataBaseAction
    ): JsonResponse {
        return response()->json(
            [
                'status' => $updateExternalDataBaseAction->execute(
                    $externalDataBase,
                    $updateEntriesOfExternalDataBaseRequest->validated()
                ),
            ]
        );
    }

    /**
     * @param ExternalDataBase $externalDataBase
     * @param DeleteExternalDataBaseAction $deleteExternalDataBaseAction
     *
     * @return JsonResponse
     */
    public function destroy(
        ExternalDataBase $externalDataBase,
        DeleteExternalDataBaseAction $deleteExternalDataBaseAction
    ): JsonResponse {
        return response()->json(
            [
                'status' => $deleteExternalDataBaseAction->execute($externalDataBase),
            ]
        );
    }

    /**
     * @param ExternalDataBase $externalDataBase
     * @param GetDataEntriesAction $getDataEntriesAction
     * @param FilterDataEntriesRequest $filterDataEntriesRequest
     *
     * @return LengthAwarePaginator
     */
    public function getDataEntries(
        ExternalDataBase $externalDataBase,
        GetDataEntriesAction $getDataEntriesAction,
        FilterDataEntriesRequest $filterDataEntriesRequest
    ): LengthAwarePaginator {
        return $getDataEntriesAction->execute($externalDataBase, $filterDataEntriesRequest->validated());
    }
}

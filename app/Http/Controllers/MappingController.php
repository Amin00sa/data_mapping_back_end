<?php

namespace App\Http\Controllers;

use App\Actions\Mapping\AddDataToDataBase;
use App\Http\Requests\MappingStoreRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class MappingController extends Controller
{
    /**
     * @throws Exception
     */
    public function store(MappingStoreRequest $mappingStoreRequest, AddDataToDataBase $addDataToDataBase): JsonResponse
    {
        return response()->json(
            [
                'status' => $addDataToDataBase->execute($mappingStoreRequest->validated()),
            ]
        );
    }
}

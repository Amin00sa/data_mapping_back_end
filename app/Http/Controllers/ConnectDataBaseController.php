<?php

namespace App\Http\Controllers;

use App\Actions\Connexion\ConnectDataBaseAction;
use App\Actions\Connexion\StoreDataBaseAction;
use App\Http\Requests\ConnexionStoreRequest;
use App\Http\Requests\StoreDataBaseRequest;
use Doctrine\DBAL\Exception;
use Illuminate\Http\JsonResponse;


/**
 *
 */
class ConnectDataBaseController extends Controller
{
    /**
     * @param StoreDataBaseRequest $storeDataBaseRequest
     * @param StoreDataBaseAction $storeDataBaseAction
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function downloadExternalTablesAsSqlFiles(
        StoreDataBaseRequest $storeDataBaseRequest,
        StoreDataBaseAction $storeDataBaseAction
    ): JsonResponse {
        $storeDataBaseRequest['password'] = $storeDataBaseRequest['password'] ?? '';

        return response()->json(
            [
                'status' => $storeDataBaseAction->execute($storeDataBaseRequest->validated()),
            ]
        );
    }

    /**
     * @param ConnexionStoreRequest $connexionStoreRequest
     * @param ConnectDataBaseAction $connectDataBaseAction
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function connectToExternalDataBase(
        ConnexionStoreRequest $connexionStoreRequest,
        ConnectDataBaseAction $connectDataBaseAction
    ): JsonResponse {
        $connexionStoreRequest['password'] = $connexionStoreRequest['password'] ?? '';

        return response()->json(
            [
                'status' => $connectDataBaseAction->execute($connexionStoreRequest->validated()),
            ]
        );
    }
}

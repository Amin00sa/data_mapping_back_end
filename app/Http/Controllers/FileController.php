<?php

namespace App\Http\Controllers;

use App\Actions\File\CreateFileAction;
use App\Actions\File\GetAllFileAction;
use App\Actions\File\GetFileAction;
use App\Exceptions\UploadFileException;
use App\Http\Requests\FileStoreRequest;
use App\Http\Resources\File\FileCollection;
use App\Http\Resources\File\FileResource;
use App\Models\File;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * @param Request $request
     * @param GetAllFileAction $getAllFileAction
     * @return FileCollection
     */
    public function index(Request $request, GetAllFileAction $getAllFileAction): FileCollection
    {
        return FileCollection::make($getAllFileAction->execute($request->query()));
    }

    /**
     * @param File $file
     * @param GetFileAction $getFileAction
     * @return FileResource
     */
    public function show(File $file, GetFileAction $getFileAction): FileResource
    {
        return FileResource::make($getFileAction->execute($file));
    }
    /**
     * @throws UploadFileException|Exception
     */
    public function store(FileStoreRequest $fileStoreRequest, CreateFileAction $createFileAction): JsonResponse
    {
        return response()->json([
            'status' => $createFileAction->execute($fileStoreRequest->validated())
        ]);
    }
}

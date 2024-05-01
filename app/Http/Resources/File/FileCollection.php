<?php

namespace App\Http\Resources\File;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FileCollection extends ResourceCollection
{
    public static $wrap = 'files';
    public $collects = FileResource::class;

    /**
     * Transform the resource collection into an array.
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}

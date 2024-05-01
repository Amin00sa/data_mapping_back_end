<?php

namespace App\Http\Resources\ExternalDataBase;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ExternalDataBaseCollection extends ResourceCollection
{
    public static $wrap = 'externalDataBases';
    public $collects = ExternalDataBaseResource::class;

    /**
     * Transform the resource collection into an array.
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}

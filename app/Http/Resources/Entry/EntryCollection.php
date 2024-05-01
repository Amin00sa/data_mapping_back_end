<?php

namespace App\Http\Resources\Entry;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EntryCollection extends ResourceCollection
{
    public static $wrap = 'entries';
    public $collects = EntryResource::class;

    /**
     * Transform the resource collection into an array.
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}

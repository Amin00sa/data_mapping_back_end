<?php

namespace App\Http\Resources\DataEntry;

use App\Models\DataEntry;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DataEntryCollection extends ResourceCollection
{
    public static $wrap = 'dataEntries';
    public $collects = DataEntry::class;

    /**
     * Transform the resource collection into an array.
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}

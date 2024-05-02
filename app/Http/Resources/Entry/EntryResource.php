<?php

namespace App\Http\Resources\Entry;

use App\Http\Resources\DataEntry\DataEntryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EntryResource extends JsonResource
{
    public static $wrap = 'entry';

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'type'        => $this->type,
            'dataEntries' => DataEntryResource::collection($this->whenLoaded('dataEntries')),
        ];
    }
}

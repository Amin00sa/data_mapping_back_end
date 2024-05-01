<?php

namespace App\Http\Resources\ExternalDataBase;

use App\Http\Resources\Entry\EntryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ExternalDataBaseResource extends JsonResource
{
    public static $wrap = 'externalDataBase';

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'entries' => EntryResource::collection($this->whenLoaded('entries')),
            'entries_count' => $this->whenCounted('entries'),
            'data_entries_count' => $this->whenCounted('dataEntries'),
        ];
    }
}

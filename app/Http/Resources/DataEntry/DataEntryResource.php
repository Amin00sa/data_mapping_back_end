<?php

namespace App\Http\Resources\DataEntry;

use Illuminate\Http\Resources\Json\JsonResource;

class DataEntryResource extends JsonResource
{
    public static $wrap = 'dataEntry';

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}

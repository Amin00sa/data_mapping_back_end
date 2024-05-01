<?php

namespace App\Http\Resources\File;

use App\Http\Resources\Entry\EntryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    public static $wrap = 'file';

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'path_file' => $this->path_file,
            'headers' => $this->headers,
            'created_at' => $this->created_at,
        ];
    }
}

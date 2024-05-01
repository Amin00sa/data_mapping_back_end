<?php

namespace App\Services;

use App\Models\Entry;

class Mapping
{
    /**
     * @param $attributesEntry
     * @param $data
     * @return void
     */
    public function map($attributesEntry, $data): void
    {
        foreach ($attributesEntry['object'] as $entries) {
            foreach ($data->chunk(1000) as $chunk) {
                $collectionValues = collect($chunk)->map(function ($row) use ($entries) {
                    $row = collect($row);
                    return [
                        'key' => $entries['header'],
                        'value' => $row[$entries['header']]
                    ];
                });
                Entry::findOrFail($entries['entryId'])->dataEntries()->createMany($collectionValues);
            }
        }
    }
}


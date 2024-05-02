<?php

namespace App\Actions\DataEntries;

use App\Models\DataEntry;

class UpdateDataEntriesAction
{
    /**
     * @param array $validatedEntries
     *
     * @return bool
     */
    public function execute(array $validatedEntries): bool
    {
        $mappedArrays = array_map(function ($arr) {
            return [
                'id'    => $arr['id'],
                'key'   => '',
                'value' => $arr['value'],
            ];
        }, $validatedEntries['dataEntries']);

        return DataEntry::query()->upsert($mappedArrays, ['id'], ['value']);
    }
}


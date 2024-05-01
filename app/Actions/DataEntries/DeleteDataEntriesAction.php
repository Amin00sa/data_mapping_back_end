<?php

namespace App\Actions\DataEntries;

use App\Models\DataEntry;

class DeleteDataEntriesAction
{
    /**
     * @param array $validatedEntries
     * @return bool
     */
    public function execute(array $validatedEntries): bool
    {
        $collection = collect($validatedEntries['dataEntries']);
        $pluckedIds = $collection->pluck('id')->toArray();
        return DataEntry::destroy($pluckedIds);
    }
}


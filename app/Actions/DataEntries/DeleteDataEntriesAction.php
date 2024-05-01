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
        return DataEntry::destroy($validatedEntries['dataEntries']);
    }
}


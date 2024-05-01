<?php

namespace App\Actions\Entry;

use App\Models\Entry;

class UpdateEntryAction
{
    /**
     * @param Entry $entry
     * @param array $attributesEntry
     * @return bool
     */
    public function execute(Entry $entry, array $attributesEntry): bool
    {
        return $entry->update($attributesEntry);
    }
}


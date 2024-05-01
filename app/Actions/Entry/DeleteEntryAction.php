<?php

namespace App\Actions\Entry;

use App\Models\Entry;

class DeleteEntryAction
{
    /**
     * @param Entry $entry
     * @return bool
     */
    public function execute(Entry $entry): bool
    {
        return $entry->delete();
    }
}

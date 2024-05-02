<?php

namespace App\Actions\Entry;

use App\Models\Entry;
use Illuminate\Database\Eloquent\Builder;

class GetDataEntriesAction
{
    /**
     * @param Entry $entry
     *
     * @return Builder|Entry
     */
    public function execute(Entry $entry): Builder|Entry
    {
        return Entry::with('dataEntries')->find($entry->id);
    }
}

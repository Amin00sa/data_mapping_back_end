<?php

namespace App\Actions\Entry;

use App\Models\Entry;
use App\Models\ExternalDataBase;
use Illuminate\Database\Eloquent\Builder;

class CreateEntryAction
{
    /**
     * @param array $attributesEntry
     *
     * @return Builder|ExternalDataBase
     */
    public function execute(array $attributesEntry): Builder|Entry
    {
        return Entry::query()->create($attributesEntry);
    }
}

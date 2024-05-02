<?php

namespace App\Actions\ExternalDataBase;

use App\Filters\FilterByName;
use App\Models\ExternalDataBase;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\QueryBuilder;

class GetAllExternalDataBaseAction
{
    /**
     * @return LengthAwarePaginator
     */
    public function execute(): LengthAwarePaginator
    {
        return QueryBuilder::for(ExternalDataBase::class)
            ->allowedIncludes(
                [
                    'entries',
                    AllowedInclude::count('entriesCount'),
                    AllowedInclude::count('dataEntriesCount'),
                ]
            )
            ->allowedFilters(
                [
                    AllowedFilter::custom('name', new FilterByName())->nullable(),
                ]
            )
            ->defaultSort('-created_at')
            ->paginate(5)
            ->onEachSide(1);
    }
}

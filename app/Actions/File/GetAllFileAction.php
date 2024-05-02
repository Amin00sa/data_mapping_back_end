<?php

namespace App\Actions\File;

use App\Filters\FilterByName;
use App\Models\File;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetAllFileAction
{
    /**
     * @return LengthAwarePaginator
     */
    public function execute(): LengthAwarePaginator
    {
        return QueryBuilder::for(File::class)
            ->allowedFilters(
                [
                    AllowedFilter::custom('name', new FilterByName())->nullable(),
                ]
            )
            ->defaultSort('-created_at')
            ->paginate(4)
            ->onEachSide(1);
    }
}

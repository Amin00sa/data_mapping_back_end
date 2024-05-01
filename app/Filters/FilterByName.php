<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByName implements Filter
{
    public function __invoke(Builder $query, $value, string $property): void
    {
        $query->where('name', 'Like', '%' . $value . '%');
    }
}

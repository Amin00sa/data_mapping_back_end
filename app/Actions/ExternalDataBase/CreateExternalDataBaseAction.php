<?php

namespace App\Actions\ExternalDataBase;

use App\Models\ExternalDataBase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CreateExternalDataBaseAction
{
    /**
     * @param array $validatedData
     * @return Builder|ExternalDataBase
     */
    public function execute(array $validatedData): Builder|ExternalDataBase
    {
        return DB::transaction(function () use ($validatedData) {
            $externalDataBase = ExternalDataBase::query()->create(['name' => $validatedData['name']]);
            $externalDataBase->entries()->createMany($validatedData['entries']);

            return $externalDataBase;
        });
    }
}

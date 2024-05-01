<?php

namespace App\Actions\ExternalDataBase;

use App\Models\Entry;
use App\Models\ExternalDataBase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpdateExternalDataBaseAction
{
    /**
     * @param ExternalDataBase $externalDataBase
     * @param array $validatedData
     * @return bool
     */
    public function execute(ExternalDataBase $externalDataBase, array $validatedData): bool
    {
        return DB::transaction(function () use ($externalDataBase, $validatedData) {
            $mappedArrays = array_map(function ($arr) use ($externalDataBase) {
                return [
                    'id' => $arr['id'] ?? Str::uuid()->toString(),
                    'name' => $arr['name'],
                    'type' => $arr['type'],
                    'external_data_base_id' => $externalDataBase->id,
                ];
            }, $validatedData['entries']);

            Entry::query()->upsert($mappedArrays, 'id', ['type', 'name']);
            $externalDataBase->update(['name' => $validatedData['name']]);
            return true;
        });
    }
}


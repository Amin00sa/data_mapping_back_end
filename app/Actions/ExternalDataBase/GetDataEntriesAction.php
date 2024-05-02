<?php

namespace App\Actions\ExternalDataBase;

use App\Models\ExternalDataBase;
use App\Services\DataEntryTransformer;
use Illuminate\Pagination\LengthAwarePaginator;

class GetDataEntriesAction
{
    /**
     * @var DataEntryTransformer
     */
    protected DataEntryTransformer $dataEntryTransformer;

    /**
     * @param DataEntryTransformer $dataEntryTransformer
     */
    public function __construct(DataEntryTransformer $dataEntryTransformer)
    {
        $this->dataEntryTransformer = $dataEntryTransformer;
    }

    /**
     * @param ExternalDataBase $externalDataBase
     * @param array $validatedData
     *
     * @return LengthAwarePaginator
     */
    public function execute(ExternalDataBase $externalDataBase, array $validatedData): LengthAwarePaginator
    {
        return $this->dataEntryTransformer->getDataEntries(
            $externalDataBase->entries()->with('dataEntries')->get(),
            $validatedData
        );
    }
}

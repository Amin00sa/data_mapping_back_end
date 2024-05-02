<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class DataEntryTransformer
{
    /**
     * @param $dataEntries
     * @param $validatedData
     *
     * @return LengthAwarePaginator
     */
    public function getDataEntries($dataEntries, $validatedData): LengthAwarePaginator
    {
        $data = $this->makeTransposedData($dataEntries);
        if ($validatedData && $validatedData['type'] && $validatedData['name']) {
            $data = $this->filterByKeyValue($data, $validatedData);
        }

        return $this->makePagination($data, 12);
    }

    /**
     * @param $dataEntries
     *
     * @return array
     */
    private function makeTransposedData($dataEntries): array
    {
        $transposedData = collect($dataEntries)->map(function ($externalDataBase) {
            return $externalDataBase['externalDataBase']['entries']->map(function ($entry) use ($externalDataBase) {
                return array_map(function ($dataEntry) use ($entry) {
                    return ['id' => $dataEntry['id'], 'value' => $dataEntry['value'], 'key' => $entry['name']];
                }, $entry['dataEntries']->toArray());
            });
        })->flatten(1)->unique()->values()->toArray();
        $newTransposedData = [];
        foreach ($transposedData as $subArray) {
            foreach ($subArray as $key => $value) {
                $newTransposedData[$key][] = $value;
            }
        }

        return $newTransposedData;
    }

    /**
     * @param $data
     * @param $validatedData
     *
     * @return array
     */
    private function filterByKeyValue($data, $validatedData): array
    {
        $newFilteredArray = [];
        foreach ($data as $transposedDatum) {
            foreach ($transposedDatum as $value) {
                if ($value['key'] === $validatedData['type'] && str_contains(
                        strtolower($value['value']),
                        strtolower($validatedData['name'])
                    )) {
                    $newFilteredArray[] = $transposedDatum;
                }
            }
        }

        return $newFilteredArray;
    }

    /**
     * @param $data
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
    private function makePagination($data, int $perPage): LengthAwarePaginator
    {
        $page = Paginator::resolveCurrentPage();
        $total = count($data);
        $options = [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ];
        $result = Collection::make($data)->forPage($page, $perPage);

        return new LengthAwarePaginator($result, $total, $perPage, $page, $options);
    }
}

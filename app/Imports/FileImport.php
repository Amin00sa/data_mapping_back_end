<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class FileImport implements ToCollection, WithHeadingRow
{
    public array $headers;
    public Collection $data;

    public function collection(Collection $collection): void
    {
        $this->headers = array_keys($collection->take(1)->toArray()[0]);
        $this->data = $collection;
    }
}

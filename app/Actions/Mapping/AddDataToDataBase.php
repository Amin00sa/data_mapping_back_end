<?php

namespace App\Actions\Mapping;

use App\Imports\FileImport;
use App\Models\File;
use App\Services\Mapping;
use App\Services\SqlTransformer;
use App\Services\XmlTransformer;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

/**
 *
 */
class AddDataToDataBase
{
    /**
     * @param SqlTransformer $sqlTransformer
     * @param XmlTransformer $xmlTransformer
     * @param Mapping $mapping
     */
    public function __construct(
        private readonly SqlTransformer $sqlTransformer,
        private readonly XmlTransformer $xmlTransformer,
        private readonly Mapping $mapping
    ) {
    }

    /**
     * @param array $attributesEntry
     *
     * @return true
     * @throws Exception
     */
    public function execute(array $attributesEntry): bool
    {
        $file = File::query()->findOrFail($attributesEntry['fileId']);
        $pathInfo = pathinfo(public_path('storage/' . $file->path_file));
        $extension = $pathInfo['extension'];
        $data = match ($extension) {
            "csv", "xls", "xlsx" => $this->getDataExcel($file),
            "sql" => $this->getDataSQL($file),
            "xml" => $this->getDataXML($file),
            default => throw new Exception('Unexpected value'),
        };
        $this->mapping->map($attributesEntry, $data);

        return true;
    }

    /**
     * @param $file
     *
     * @return Collection
     */
    private function getDataExcel($file): Collection
    {
        Excel::import($fileImport = new FileImport, public_path('storage/' . $file->path_file));

        return $fileImport->data;
    }

    /**
     * @param $file
     *
     * @return Collection
     * @throws Exception
     */
    private function getDataSQL($file): Collection
    {
        $sql = public_path('storage/' . $file->path_file);
        $sqlString = file_get_contents($sql);
        $headers = $this->sqlTransformer->getAttribute($sqlString);

        return collect($this->sqlTransformer->getData($sqlString, $headers));
    }

    /**
     * @param $file
     *
     * @return Collection
     * @throws Exception
     */
    private function getDataXML($file): Collection
    {
        $xml = public_path('storage/' . $file->path_file);
        $xmlString = file_get_contents($xml);
        $headers = $this->xmlTransformer->getAttribute($xmlString);

        return collect($this->xmlTransformer->getData($xmlString, $headers));
    }
}

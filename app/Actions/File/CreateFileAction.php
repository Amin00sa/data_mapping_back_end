<?php

namespace App\Actions\File;

use App\Exceptions\UploadFileException;
use App\Imports\FileImport;
use App\Models\File;
use App\Services\SqlTransformer;
use App\Services\XmlTransformer;
use Exception;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class CreateFileAction
{

    /**
     * @param SqlTransformer $sqlTransformer
     * @param XmlTransformer $xmlTransformer
     */
    public function __construct(
        private readonly SqlTransformer $sqlTransformer,
        private readonly XmlTransformer $xmlTransformer
    ) {
    }

    /**
     * @param array $attributesEntry
     *
     * @return bool
     * @throws UploadFileException|Exception
     */
    public function execute(array $attributesEntry): bool
    {
        foreach ($attributesEntry['files'] as $file) {
            try {
                $filename = $file->getClientOriginalName();
                $headers = match ($file->extension()) {
                    "xml" => $this->makeHeadersXML($file),
                    "csv", "xls", "xlsx" => $this->makeHeadersExcel($file),
                    "txt" => $this->makeHeadersSQL($filename, $file),
                    default => throw new Exception('Unexpected value'),
                };
                $this->saveFile($filename, $headers, $file);
            } catch (UploadFileException) {
                throw new Exception('File not uploaded');
            }
        }

        return true;
    }

    /**
     * @param $file
     *
     * @return array
     * @throws Exception
     */
    private function makeHeadersXML($file): array
    {
        $xmlString = file_get_contents($file);

        return $this->xmlTransformer->getAttribute($xmlString);
    }


    /**
     * @param $file
     *
     * @return array
     */
    private function makeHeadersExcel($file): array
    {
        Excel::import($fileImport = new FileImport, $file);

        return $fileImport->headers;
    }

    /**
     * @param $filename
     * @param $file
     *
     * @return array
     * @throws Exception
     */
    private function makeHeadersSQL($filename, $file): array
    {
        if (pathinfo($filename, PATHINFO_EXTENSION) === 'sql') {
            $sql = file_get_contents($file);
            file_put_contents("storage/files/" . $filename, $sql);

            return $this->sqlTransformer->getAttribute($sql);
        } else {
            throw new Exception('Unexpected value');
        }
    }

    /**
     * @param $filename
     * @param $headers
     * @param $file
     *
     * @return void
     */
    private function saveFile($filename, $headers, $file): void
    {
        $path = $file->extension() === "txt" ? 'files/' . $filename : Storage::disk('public')->put("files", $file);
        File::query()->create(
            [
                'name'      => $filename,
                'path_file' => $path,
                'headers'   => json_encode($headers),
            ]
        );
    }
}

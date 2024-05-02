<?php

namespace App\Services;

use App\Models\File;
use DateTime;
use Exception;

class ExportTable
{
    /**
     * @param $connection
     * @param $tableName
     *
     * @return bool|Exception
     */
    public function exportTableToSqlFile($connection, $tableName): bool|Exception
    {
        try {
            $columnsHeader = array_map(function ($item) {
                return $item['name'];
            }, $connection->getSchemaBuilder()->getColumns($tableName));
            $data = $this->getData($connection, $tableName);
            $columnsType = $this->getType($connection->getSchemaBuilder()->getColumns($tableName));
            $sql = $this->createSqlFile($tableName, $columnsHeader, $columnsType, $data);

            return $this->saveSqlFile($sql, $tableName, $columnsHeader);
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * @param array $columns
     *
     * @return array
     */
    public function getType(array $columns): array
    {
        return array_map(function ($column) {
            $type = $column['type_name'];

            return $column['name'] . " " . $this->getTypeName($type);
        }, $columns);
    }

    /**
     * @param $typeName
     *
     * @return string
     */
    private function getTypeName($typeName): string
    {
        switch ($typeName) {
            case 'object':
                if ($typeName instanceof DateTime) {
                    $typeName = 'DATETIME';
                }
                break;
            case 'double':
                $typeName = 'FLOAT';
                break;
            case 'string':
            case 'char':
                $typeName = 'VARCHAR(255)';
                break;
            case 'boolean':
                $typeName = 'BOOLEAN';
                break;
            case 'NULL':
                $typeName = 'varchar(255) DEFAULT NULL';
                break;
        }

        return $typeName;
    }

    /**
     * @param $connection
     * @param $tableName
     *
     * @return array
     */
    private function getData($connection, $tableName): array
    {
        $rowsToInsert = [];
        foreach ($connection->table($tableName)->get() as $row) {
            $rowsToInsert[] = $row;
        }

        return $rowsToInsert;
    }

    /**
     * @param $tableName
     * @param $columnsWithType
     * @param $rowsToInsert
     *
     * @return string
     */
    private function createSqlFile($tableName, $columnsHeader, $columnsType, $rowsToInsert): string
    {
        $sql = "CREATE TABLE $tableName ( \n" . implode(', ', $columnsType) . "\n ); \n \n \n";
        $sql .= "INSERT INTO $tableName (" . implode(', ', $columnsHeader) . ") VALUES \n";
        $values = [];
        foreach ($rowsToInsert as $row) {
            $rowValues = array_map(function ($value) {
                if (is_null($value)) {
                    return 'NULL';
                } else {
                    return "'" . addslashes($value) . "'";
                }
            }, (array)$row); // Cast $row to an array to handle both array and object inputs

            $values[] = '(' . implode(', ', $rowValues) . ')';
        }

        $sql .= implode(",\n", $values) . ";";

        return $sql;
    }

    /**
     * @param $sql
     * @param $tableName
     * @param $columnsHeader
     *
     * @return bool
     */
    public static function saveSqlFile($sql, $tableName, $columnsHeader): bool
    {
        $filename = str()->uuid() . $tableName . ".sql";
        file_put_contents("storage/files/" . $filename, $sql);
        File::query()->create(
            [
                'name'      => $tableName . ".sql",
                'path_file' => 'files/' . $filename,
                'headers'   => json_encode($columnsHeader),
            ]
        );

        return true;
    }
}

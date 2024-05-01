<?php

namespace App\Actions\Connexion;

use App\Services\DatabaseConfig;
use App\Services\ExportTable;
use Exception;
use Illuminate\Support\Facades\DB;

class StoreDataBaseAction
{
    /**
     * @param DatabaseConfig $databaseConfig
     * @param ExportTable $exportTable
     */
    public function __construct(
        private readonly DatabaseConfig $databaseConfig,
        private readonly ExportTable    $exportTable
    )
    {
    }

    /**
     * @param array $validatedData
     * @return bool|Exception|string
     * @throws \Doctrine\DBAL\Exception
     */
    public function execute(array $validatedData): bool|Exception|array
    {
        $this->databaseConfig->configure($validatedData);
        try {
            $connection = DB::connection('remote_server_mysql');
            $connection->getSchemaBuilder()->blueprintResolver(function () {
                return new \Illuminate\Database\Schema\Grammars\MySqlGrammar;
            });
            $connection->getSchemaBuilder()->getConnection()->setPdo($connection->getPdo());
            $connection->getSchemaBuilder()->getTables();
            $tableName = $validatedData['name'];
            return $this->exportTable->exportTableToSqlFile($connection, $tableName);
        } catch (\Illuminate\Database\QueryException $e) {
            return ['errors' => $e->getMessage()];
        }
    }
}

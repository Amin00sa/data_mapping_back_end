<?php

namespace App\Actions\Connexion;

use App\Services\DatabaseConfig;
use Illuminate\Support\Facades\DB;

class ConnectDataBaseAction
{
    /**
     * @param DatabaseConfig $databaseConfig
     */
    public function __construct(
        private readonly DatabaseConfig $databaseConfig
    ) {
    }

    /**
     * @param array $validatedData
     *
     * @return string|array
     * @throws Exception
     */
    public function execute(array $validatedData): bool|array
    {
        $this->databaseConfig->configure($validatedData);
        try {
            $connection = DB::connection('remote_server_mysql');
            $connection->getSchemaBuilder()->blueprintResolver(function () {
                return new \Illuminate\Database\Schema\Grammars\MySqlGrammar;
            });
            $connection->getSchemaBuilder()->getConnection()->setPdo($connection->getPdo());
            $connection->getSchemaBuilder()->getTables();

            return true;
        } catch (\Illuminate\Database\QueryException $e) {
            return ['errors' => $e->getMessage()];
        }
    }
}

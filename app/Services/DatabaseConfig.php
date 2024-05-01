<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;

class DatabaseConfig
{
    /**
     * @param $validatedData
     * @return void
     */
    public function configure($validatedData): void
    {
        Config::set('database.connections.remote_server_mysql', [
            "driver" => $validatedData['driver'],
            "host" => $validatedData['host'],
            "port" => $validatedData['port'],
            "database" => $validatedData['database'],
            "username" => $validatedData['username'],
            "password" => $validatedData['password'],
        ]);
    }
}

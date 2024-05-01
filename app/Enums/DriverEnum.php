<?php

namespace App\Enums;

enum DriverEnum: string
{
     case MYSQL = 'mysql';
     case SQLLITE = 'sqlite';
     case PGSQL = 'pgsql';
     case SQLSRV = 'sqlsrv';
}

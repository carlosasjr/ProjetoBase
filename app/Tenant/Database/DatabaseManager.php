<?php

namespace App\Tenant\Database;

use App\Models\Company;
use Illuminate\Support\Facades\DB;

class DatabaseManager
{
    public function createDatabase(Company $company)
    {
        $schemaName = $company->db_database;
        $charset = config("database.connections.tenant.charset",'utf8mb4');
        $collation = config("database.connections.tenant.collation",'utf8mb4_unicode_ci');

        $query = "CREATE DATABASE `{$schemaName}` CHARACTER SET $charset COLLATE $collation";

        return DB::statement($query);
    }
}



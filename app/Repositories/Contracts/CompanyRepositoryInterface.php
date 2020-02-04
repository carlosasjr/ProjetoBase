<?php

namespace App\Repositories\Contracts;

use App\Models\Company;

interface CompanyRepositoryInterface
{
    public function databaseGenerator(Company $company, bool $createDataBase);
    public function subDomainExists($subDomain);
}


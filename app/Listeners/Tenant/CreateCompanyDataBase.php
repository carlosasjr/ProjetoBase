<?php

namespace App\Listeners\Tenant;

use App\Events\Tenant\CompanyCreated;
use App\Events\Tenant\DatabaseCreated;
use App\Tenant\Database\DatabaseManager;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateCompanyDataBase
{
    private $database;

    /**
     * CreateCompanyDataBase constructor.
     * @param DatabaseManager $database
     */
    public function __construct(DatabaseManager $database)
    {
        $this->database = $database;
    }

    /**
     * @param CompanyCreated $event
     * @throws \Exception
     */
    function handle(CompanyCreated $event)
    {
        $company = $event->company();

       if (!$this->database->createDatabase($company)) {
           throw new \Exception('Error create database');
       }

       event(new DatabaseCreated($company));
    }
}

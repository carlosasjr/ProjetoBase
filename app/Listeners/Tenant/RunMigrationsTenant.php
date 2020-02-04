<?php

namespace App\Listeners\Tenant;

use App\Events\Tenant\DatabaseCreated;
use App\Mail\SendMailCompany;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class RunMigrationsTenant
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param DatabaseCreated $event
     * @return void
     */
    public function handle(DatabaseCreated $event)
    {
        $company = $event->company();

        $migration = Artisan::call('tenants:migrations', [
            'id' => $company->id
        ]);


        if ($migration === 0) {
            $senha = uniqid(date('YmdHis'));

            User::create([
                'name' => $company->name,
                'email' => $company->email,
                'password' => bcrypt($senha)
            ]);

            Mail::to($company->email)->send(new SendMailCompany($company, $senha));
        }


        return $migration === 0;
    }
}

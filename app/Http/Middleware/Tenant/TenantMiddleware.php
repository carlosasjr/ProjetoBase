<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Company;
use App\Tenant\ManagerTenant;
use Carbon\Carbon;
use Closure;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * Registrar o middleware em Kernel.php
     */
    private function getCompany($subdomain)
    {
        return Company::where('subdomain', '=', $subdomain)->first();
    }

    /**
     * @param Company $company
     * @return bool
     */
    private function testExpired(Company $company)
    {
        $value = Carbon::now()->diffInDays($company->created_at);

        if ($value >= 7 && $company->payment_status == 'testing') {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    private function subDomain()
    {
        $piecesHost = explode('.', request()->getHost());
        $tenant = $piecesHost[0];
        return $tenant;
    }

    /**
     * @param $company
     */
    private function setSessionCompany($company)
    {
        session()->put('company', $company);
    }

    /**
     * @param $route
     * @return bool
     */
    private function getRoute($route)
    {
        $piecesRoute = explode('/', request()->url());

        return in_array($route, $piecesRoute);
    }


    /**
     * @param $manager
     * @param $company
     */
    private function setConnection($manager, $company): void
    {
        if (!$this->getRoute('plans') && (!$this->getRoute('paypal'))) {
            $manager->setConnection($company);
        }
    }


    public function handle($request, Closure $next)
    {
        $manager = app(ManagerTenant::class);

        if ($manager->domainIsMain()) {
            return $next($request);
        }

        //se for um subdominio
        $company = $this->getCompany($this->subDomain());

        if (!$company && $request->url() != route('404.tenant')) {
            return redirect()->route('404.tenant');
        }


        if ($request->url() != route('404.tenant')) {

            $this->setSessionCompany($company->only([
                'name',
                'uuid',
                'subdomain',
            ]));


            if ($this->testExpired($company) && (!$this->getRoute('plans')) &&
                (!$this->getRoute('paypal'))) {
                return redirect()->route('plans.choosePlan');
            }

            $this->setConnection($manager, $company);
        }


        return $next($request);
    }



}

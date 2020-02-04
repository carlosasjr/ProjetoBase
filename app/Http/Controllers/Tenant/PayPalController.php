<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\PayPal\PayPalAgreement;

class PayPalController extends Controller
{
    public function createAgreement($companyUuid, $paypalID)
    {
        $agreement = new PayPalAgreement();

        $result = $agreement->create($paypalID);


        if (!$result['status']) {
            return redirect()->back()
                ->with('message', 'Erro inesperado');
        }

        $identify = $result['identify'];

        $company = Company::where('uuid', $companyUuid)->first();

        if (!$company) {
            return redirect()->back()
                ->with('message', 'Cliente não identificado');
        }

        $plan = Plan::where('key_paypal', $paypalID)->first();

        $company->identify = $identify;
        $company->plan_id = $plan->id;
        $company->save();

        return redirect()->away($result['url_paypal']);
    }

    public function returnPayPal(Request $request)
    {
        $success = ($request->success == 'true') ? true : false;
        $token = $request->token;

        if (!session()->has('company')) {
            return redirect()->route('index')->withErrors( 'Falha de autenticação');
        }

        $company = session()->get('company');
        $company = Company::where('uuid', $company['uuid'])->first();
        $site = 'http://' . $company->subdomain . env('APP_SUBDOMAIN');

        if (!$success) {
            return redirect()->away($site)->withErrors( 'Solicitação cancelada');
        }

        if (empty($token)) {
            return redirect()->away($site)->withErrors( 'Falha de autenticação');
        }

        return $this->executeAgreement($token, $company, $site);
    }

    public function detailAgreement($id)
    {
        $agreement = new PayPalAgreement();
        dd($agreement->detailAgreement($id));
    }

    /**
     * @param $token
     * @param $company
     * @param string $site
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function executeAgreement($token, $company, string $site): \Illuminate\Http\RedirectResponse
    {
        $agreement = new PayPalAgreement();
        $response = $agreement->execute($token);

        if ($response['payment_id']) {

            $this->activeCompany($company, $response);

            return redirect()->away($site);
        }
    }

    /**
     * @param $company
     * @param array $response
     */
    protected function activeCompany($company, array $response): void
    {
        $company->payment_status = 'active';
        $company->payment_id = $response['payment_id'];
        $company->save();

        session()->forget('company');
    }
}

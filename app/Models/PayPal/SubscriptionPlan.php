<?php

namespace App\Models\PayPal;

use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Common\PayPalModel;

class SubscriptionPlan extends PayPal
{
    protected $plano;
    protected $type;

    /*     * ************************************************ */
    /*     * ************* METODOS PRIVADOS ***************** */
    /*     * ************************************************ */
    /**
     * @return Plan
     */
    protected function Plan(): Plan
    {
        $plan = new Plan();

        $this->type = ($this->plano->cycles == 0) ? 'infinite' : 'fixed';

        $plan->setName($this->plano->description)
            ->setDescription($this->plano->description)
            ->setType($this->type);
        return $plan;
    }

    /**
     * @return PaymentDefinition
     */
    protected function PaymentDefinition(): PaymentDefinition
    {
        $paymentDefinition = new PaymentDefinition();

        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency($this->plano->frequency)
            ->setFrequencyInterval($this->plano->frequency_interval)
            ->setCycles($this->plano->cycles)
            ->setAmount(new Currency(array('value' => $this->plano->price, 'currency' => 'BRL')));

        return $paymentDefinition;
    }

    /**
     * @return ChargeModel
     */
    protected function ChargeModel(): ChargeModel
    {
        $chargeModel = new ChargeModel();
        $chargeModel->setType('SHIPPING')
                    ->setAmount(new Currency(array('value' => 0, 'currency' => 'BRL')));
        return $chargeModel;
    }

    /**
     * @return MerchantPreferences
     */
    protected function MerchantPreferences(): MerchantPreferences
    {
        $merchantPreferences = new MerchantPreferences();

        $baseRoute = route('return.paypal');

        $merchantPreferences->setReturnUrl("{$baseRoute}/?success=true")
            ->setCancelUrl("{$baseRoute}/?success=false")
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0")
            ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'BRL')));
        return $merchantPreferences;
    }

    /**
     * @param $id
     */
    protected function Plano($id): void
    {
        $plano = \App\Models\Plan::find($id);
        $this->plano = $plano;
    }


    /**
     * @param Patch $patch
     * @param Plan $createdPlan
     */
    protected function patchRequest(Patch $patch, Plan $createdPlan): void
    {
        $patchRequest = new PatchRequest();
        $patchRequest->addPatch($patch);

        $createdPlan->update($patchRequest, $this->apiContext);
    }

    /**
     * @return Patch
     */
    protected function patch(): Patch
    {
        $patch = new Patch();

        $value = new PayPalModel('{
	       "state":"ACTIVE"
	     }');

        $patch->setOp('replace')
            ->setPath('/')
            ->setValue($value);
        return $patch;
    }

    /*     * ************************************************ */
    /*     * ************* METODOS PUBLICOS ***************** */
    /*     * ************************************************ */


    /**
     * @param $id
     * @return Plan
     */
    public function create($id)
    {
        $this->Plano($id);

        $plan = $this->Plan();

        $paymentDefinition = $this->PaymentDefinition();
       // $chargeModel = $this->ChargeModel();
        //$paymentDefinition->setChargeModels(array($chargeModel));
        $merchantPreferences = $this->MerchantPreferences();

        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        $output = $plan->create($this->apiContext);

        $this->id = $output->getId();

        return $output;
    }


    /**
     * @return \PayPal\Api\PlanList
     */
    public function listPlan()
    {
        $params = array('page_size' => '10');

        $planList = Plan::all($params, $this->apiContext);

        return $planList;
    }

    /**
     * @param $id
     * @return Plan
     */
    public function planDetail($id)
    {
        $plan = Plan::get($id, $this->apiContext);
        return $plan;
    }

    public function activate($id)
    {
        $createdPlan = $this->planDetail($id);

        $patch = $this->patch();

        $this->patchRequest($patch, $createdPlan);

        $plan = Plan::get($createdPlan->getId(), $this->apiContext);

        return $plan;
    }




}

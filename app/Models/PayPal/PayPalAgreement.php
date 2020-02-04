<?php

/**
 * .class [ TIPO ]
 *
 * @copyright (c) 2018, Carlos Junior
 */
namespace App\Models\PayPal;

use Carbon\Carbon;
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;
use PayPal\Exception\PayPalConnectionException;

class PayPalAgreement extends PayPal
{
    /*     * ************************************************ */
    /*     * ************* METODOS PRIVADOS ***************** */
    /*     * ************************************************ */

    /**
     * @param $id
     * @return Plan
     */
    protected function plan($id): Plan
    {
        $plan = new Plan();
        $plan->setId($id);
        return $plan;
    }

    /**
     * @return Payer
     */
    protected function payer(): Payer
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        return $payer;
    }

    /**
     * @return ShippingAddress
     */
    protected function shippingAddress(): ShippingAddress
    {
        $shippingAddress = new ShippingAddress();
        $shippingAddress->setLine1('111 First Street')
            ->setCity('Saratoga')
            ->setState('CA')
            ->setPostalCode('95070')
            ->setCountryCode('US');
        return $shippingAddress;
    }


    /**
     * @param $id
     * @return string
     */
    protected function agreement($id): string
    {
        $startdate = Carbon::now()->add(1, 'day')->toAtomString();

        $agreement = new Agreement();
        $agreement->setName('SoftPro - Contrato de Licença de Uso')
                  ->setDescription('Contrato de Licença de Uso')
                  ->setStartDate($startdate);

        $agreement->setPlan($this->plan($id));
        $agreement->setPayer($this->payer());
       // $agreement->setShippingAddress($this->shippingAddress());

        $agreement = $agreement->create($this->apiContext);

        return $agreement->getApprovalLink();
    }



    /*     * ************************************************ */
    /*     * ************* METODOS PUBLICOS ***************** */
    /*     * ************************************************ */

    public function create($id)
    {
        try {

            $url_paypal = $this->agreement($id);

            return [
                'status'     => true,
                'url_paypal' => $url_paypal,
                'identify'   => $this->identify
            ];

        } catch (PayPalConnectionException  $ex) {
            dd($ex);
            return [
                'status'    => false,
                'message'   => $ex->getMessage()
            ];

        }
    }

    public function execute($token)
    {
        $agreement = new Agreement();
        $agreement->execute($token, $this->apiContext);

        return [
            'status'      => true,
            'state'       =>  $agreement->getState(),
            'payment_id'  =>  $agreement->getId(),
        ];
    }

    public function detailAgreement($id)
    {
        $agreement = Agreement::get($id, $this->apiContext);

        return $agreement;
    }
}

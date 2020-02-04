<?php

namespace App\Repositories\Core\DigitalPayments\PayPal;

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

/**
 * .class [ TIPO ]
 *
 * @copyright (c) 2018, Carlos Junior
 */
class PayPal
{
    protected $apiContext;
    protected $id;
    protected $identify;

    /*     * ************************************************ */
    /*     * ************* METODOS PRIVADOS ***************** */
    /*     * ************************************************ */


    /*     * ************************************************ */
    /*     * ************* METODOS PUBLICOS ***************** */
    /*     * ************************************************ */

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(config('paypal.client_id'),
                config('paypal.secret_id'))
        );

        $this->apiContext->setConfig(config('paypal.settings'));

        $this->identify = bcrypt(uniqid(date('YmdHis')));
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}

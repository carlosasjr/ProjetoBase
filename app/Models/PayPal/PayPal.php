<?php

namespace App\Models\PayPal;

use Illuminate\Database\Eloquent\Model;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;


class PayPal extends Model
{
    protected $apiContext;
    protected $id;
    protected $identify;


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

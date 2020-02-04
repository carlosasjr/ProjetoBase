<?php
namespace App\Repositories\Core\DigitalPayments;


use App\Repositories\Contracts\SubscriptionRepositoryInterface;

/**
 * .class [ TIPO ]
 *
 * @copyright (c) 2018, Carlos Junior
 */
class SubscriptionPlan implements SubscriptionRepositoryInterface
{
    protected $subscription;
    /*     * ************************************************ */
    /*     * ************* METODOS PRIVADOS ***************** */
    /*     * ************************************************ */


    /*     * ************************************************ */
    /*     * ************* METODOS PUBLICOS ***************** */
    /*     * ************************************************ */

    public function __construct(SubscriptionRepositoryInterface $subscription)
    {
        $this->subscription = $subscription;
    }

    public function create($id)
    {
      return $this->subscription->create($id);
    }

    public function listPlan()
    {
        return $this->listPlan();
    }

    public function planDetail($id)
    {
        return $this->subscription->planDetail($id);
    }

    public function activate($id)
    {
       return $this->subscription->activate($id);
    }

    public function createActivate($id)
    {
        return $this->subscription->createActivate($id);
    }
}

<?php

namespace App\Repositories\Contracts;

interface SubscriptionRepositoryInterface
{
    public function create($id);
    public function listPlan();
    public function planDetail($id);
    public function activate($id);
    public function createActivate($id);
}

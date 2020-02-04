<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'description',
        'price',
        'frequency',
        'frequency_interval',
        'cycles',
        'key_paypal',
        'key_pagseguro',
        'state_paypal',
        'state_pagseguro',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plan_details()
    {
        return $this->hasMany(PlanDetail::class);
    }
}

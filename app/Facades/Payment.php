<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\Payments\Contracts\PaymentContract;

class Payment extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return PaymentContract::class;
    }
}

<?php

namespace App\Services\Payments\Contracts;

interface PaymentContract
{
    public function processRequest($requests = []);

    public function successTransaction(array $requests = []);
}

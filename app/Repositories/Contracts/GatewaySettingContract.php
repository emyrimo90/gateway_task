<?php

namespace App\Repositories\Contracts;

interface GatewaySettingContract extends BaseContract
{
    public function getCurrentGatewaySettings();
    public function setGatewayNameCookie();
    public function updateAllGateways($status);
}


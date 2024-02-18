<?php

namespace App\Repositories\SQL;

use App\Exceptions\GatewayConfigurationException;
use App\Models\GatewaySetting;
use App\Repositories\Contracts\GatewaySettingContract;
use Illuminate\Support\Facades\Cookie;

class GatewaySettingRepository extends BaseRepository implements GatewaySettingContract
{
    /**
     * GatewaySettingRepository constructor.
     * @param GatewaySetting $model
     */
    public function __construct(GatewaySetting $model)
    {
        parent::__construct($model);
    }

    public function getCurrentGatewaySettings()
    {
        return $this->model->ofStatus(true)->first();
    }

    public function updateAllGateways($status):void
    {
        $this->model->whereStatus(!$status)->update(['status'=> $status]);
    }
    public function setGatewayNameCookie(): void
    {
        $setting = $this->getCurrentGatewaySettings();
        if (!$setting) {
            throw new GatewayConfigurationException(__("gateway_configuration_not_found"));
        }
        Cookie::queue(Cookie::make('gateway_name', $setting->name, 14400));
        $after = Cookie::get('gateway_name');
        if ($setting->name != $after) {
            Cookie::make('gateway_name', $setting->name, 14400);
        }
    }
}

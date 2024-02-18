<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\GatewaySettingContract;
use App\Services\Payments\Contracts\PaymentContract;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind('gatewayName', function () {
            if(!Cookie::has('gateway_name')){
                try{
                    app(GatewaySettingContract::class)->setGatewayNameCookie();
                }catch (\Exception $e){
                 logger()->channel('transactions.info')->info("Not Database Connection");
                }

            }
            return  Cookie::get('gateway_name');
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $class =  ucfirst(app('gatewayName'));
        $this->app->bind(PaymentContract::class,"App\Services\Payments\\{$class}");
    }
}

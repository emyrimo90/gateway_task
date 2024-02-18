<?php

namespace App\Services\Payments;

use App\Exceptions\GatewayConfigurationException;
use App\Models\GatewaySetting;
use App\Repositories\Contracts\GatewaySettingContract;
use App\Services\Payments\Contracts\PaymentContract;
use Illuminate\Http\Response;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use function PHPUnit\Framework\throwException;

class Paypal implements PaymentContract
{
    /**
     * @param array $requests
     * @return array
     * @throws GatewayConfigurationException
     * @throws \Throwable
     */
    public function processRequest($requests = []): array
    {
        $setting = $this->getSetting();
        //reset paypal configuration values
        $this->setPaypalConfiguration($setting);
        $redirectLink = '';
        $provider = new PayPalClient;
        $provider->setApiCredentials($this->getConfiguration($setting));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => $setting->currency,
                        "value" => $requests['amount'],
                    ]
                ]
            ],
            "application_context" => [
                "return_url" => url("/{$setting->response_url}"),
                "cancel_url" => url("/{$setting->cancel_url}"),
                "shipping_preference" => "NO_SHIPPING"
            ],
        ]);
        $response['amount_total'] = $requests['amount'];
        $response['currency'] = $setting['currency'];
        $response['gateway_setting_id'] = $setting['id'];
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    $redirectLink = $links['href'];
                }
            }
        }
        return [
            "data" => $response,
            "status" => !empty($redirectLink) ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR,
            "redirectLink" => !empty($redirectLink) ? $redirectLink : '',
            "message" => $response['message'] ?? 'Something went wrong.',
        ];
    }

    /**
     * @param array $requests
     * @return array
     * @throws \Throwable
     */
    public function successTransaction(array $requests = []): array
    {
        $status = false;
        $setting = $this->getSetting();
        //reset paypal configuration values
        $this->setPaypalConfiguration($setting);
        $provider = new PayPalClient;
        $provider->setApiCredentials($this->getConfiguration($setting));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($requests['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $status = true;
        }
        return [
            "data" => $response,
            "status" => $status ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR,
            "message" => $status ? '' : $response['message'] ?? 'Something went wrong.'
        ];
    }

    private function getSetting()
    {
        $setting = app(GatewaySettingContract::class)->getCurrentGatewaySettings();
        if (!$setting) {
            throw new GatewayConfigurationException(__("gateway_configuration_not_found"));
        }
        return $setting;
    }

    private function getConfiguration($setting): array
    {
        return [
            'mode'    => $setting->type == GatewaySetting::TEST_MODE?'sandbox':'live',
            'sandbox' => [
                'client_id'         => $setting->type == GatewaySetting::TEST_MODE?$setting->client_id:'',
                'client_secret'     => $setting->type == GatewaySetting::TEST_MODE?$setting->client_secret:'',
            ],
            'live' => [
                'client_id'         => $setting->type != GatewaySetting::TEST_MODE?$setting->client_id:'',
                'client_secret'     => $setting->type != GatewaySetting::TEST_MODE?$setting->client_secret:'',
            ],
            'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'),
            'currency'       => $setting->currency,
            'locale'         => 'en_US',
            'notify_url'=>'',
            'validate_ssl'   => true,
        ];
    }
    private function setPaypalConfiguration($setting): void
    {
        if($setting->type == GatewaySetting::TEST_MODE){
            config()->set('paypal.sandbox.client_id', $setting->client_id);
            config()->set('paypal.sandbox.client_secret', $setting->client_secret);
        }else{
            config()->set('paypal.live.client_id', $setting->client_id);
            config()->set('paypal.live.client_secret', $setting->client_secret);
        }
    }
}

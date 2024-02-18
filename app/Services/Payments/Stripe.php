<?php

namespace App\Services\Payments;

use Illuminate\Http\Response;
use App\Exceptions\GatewayConfigurationException;
use App\Repositories\Contracts\GatewaySettingContract;
use App\Services\Payments\Contracts\PaymentContract;
use Stripe\Exception\ApiErrorException;

class Stripe implements PaymentContract
{
    /**
     * @param array $requests
     * @return array
     * @throws GatewayConfigurationException
     * @throws ApiErrorException
     */
    public function processRequest($requests = []): array
    {
        $setting = $this->getSetting();
        $redirectLink = '';
        $stripe = new \Stripe\StripeClient($setting->client_secret);
        $response = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => $setting->currency,
                        'product_data' => ['name' => '#Order'],
                        'unit_amount' => $requests['amount'] * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => url("/{$setting->response_url}") . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => url("/{$setting->cancel_url}"),
        ]);

        $response['amount_total'] = $requests['amount'];
        $response['currency'] = $setting['currency'];
        $response['gateway_setting_id'] = $setting['id'];

        if (isset($response['id']) && $response['id'] != null) {
            if ($response['url']) {
                $redirectLink = $response['url'];
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
        $response = $requests;
        $setting = $this->getSetting();
        if (isset($requests['session_id'])) {
            $stripe = new \Stripe\StripeClient($setting->client_secret);
            $response = $stripe->checkout->sessions->retrieve($requests['session_id']);
        }

        if (isset($response['status']) && $response['status'] == 'complete') {
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

}

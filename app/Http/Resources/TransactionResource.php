<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use \Illuminate\Http\Request;

class TransactionResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $this->micro = [
            'id' => $this->id,
            'trace_id' => $this->trace_id,
        ];
        $this->full = [
            'comment' => $this->comment,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'payment_status' => $this->payment_status,
            'status' => $this->status,
            'paid_at' => $this->paid_at? Carbon::parse($this->paid_at)->translatedFormat('Y-m-d h:i a'):'',
        ];

        $this->relations = [
            'user'=> $this->whenLoaded('user')?new UserResource($this->user):'',
            'gatewaySetting'=> $this->whenLoaded('gatewaySetting')?new GatewaySettingResource($this->gatewaySetting):'',
        ];
        return $this->getResource();
    }
}

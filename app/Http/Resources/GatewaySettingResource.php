<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use \Illuminate\Http\Request;

class GatewaySettingResource extends BaseResource
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
            'name' => $this->name,
        ];
        $this->full = [
            'type' => $this->type,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'currency' => $this->currency,
            'status' => (bool)$this->status,
            'status_text' => $this->status_text,
            'response_url' => $this->response_url,
            'cancel_url' => $this->cancel_url,
            'can_delete'=> !in_array($this->id, [1,2])
        ];
        return $this->getResource();
    }
}

<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use \Illuminate\Http\Request;

class ActivityLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'message' => $this->description,
            'action' => $this->getExtraProperty('action'),
            'module' => $this->getExtraProperty('module'),
            'by' => $this->causer?->name,
            'date' => Carbon::parse($this->created_at)->translatedFormat('Y-m-d h:i:s a'),
            'time' => $this->created_at->format('H:i'),
        ];
    }
}

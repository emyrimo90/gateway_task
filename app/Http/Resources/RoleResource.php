<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'name' => $this->name,
            'created_at' => $this->created_at->format('Y-m-d H:i'),
            'permissions' => $this->whenLoaded('permissions', function () {
                return $this->permissions->isNotEmpty() ? $this->customizePermissions() : (object)null;
            }),
            'role_permissions' => $this->whenLoaded('permissions', function () {
                return $this->permissions->isNotEmpty() ? $this->customizePermissions('name') : (object)null;
            }),
        ];
    }

    private function customizePermissions($field='id')
    {
        return $this->permissions->groupBy('model')->map(function ($model, $key)  use($field){
            return $model->pluck($field);
        })->collect();
    }
}

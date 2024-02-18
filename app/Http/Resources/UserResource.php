<?php

namespace App\Http\Resources;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends BaseResource
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

        $this->mini = [
            'email' => $this->email,
            'phone' => $this->phone,
        ];

        $this->full = [
        ];

        $this->relations = [
            'roles' => implode(' ,', $this->getRoleNames()->toArray()),
            'roles_ids' => $this->getRoleIds(),
            'segment_ids' => $this->relationLoaded('segments') ? $this->segments->pluck('id')->toArray() : [],
            'sub_segment_ids' => $this->relationLoaded('subSegments') ? $this->subSegments->pluck('id')->toArray() : [],
            'warehouse_ids' => $this->relationLoaded('warehouses') ? $this->warehouses->pluck('id')->toArray() : [],
            'segment_names' => $this->relationLoaded('segments') ? implode(' ,', $this->segments->pluck('name')->toArray()) : '',
            'sub_segment_names' => $this->relationLoaded('subSegments') ? implode(' ,', $this->subSegments->pluck('name')->toArray()) : '',
            'warehouse_names' => $this->relationLoaded('warehouses') ? implode(' ,', $this->warehouses->pluck('name')->toArray()) : '',
            'role_id' => $this->relationLoaded('roles') ? $this->getRoleIds()[0] ?? null : null,
//            'permissions' => $this->relationLoaded('permissions') ? $this->formatPermsForCASL() : [],
            'permissions' => $this->whenLoaded('permissions', function (){
                return collect($this->getAllPermissions())->pluck('name')->toArray();
            }),
        ];

        return $this->getResource();
    }

//    protected function formatPermsForCASL(): array
//    {
//        if (in_array(Role::DEFAULT_ROLE_SUPER_ADMIN, $this->getRoleNames()->toArray(), true)) {
//            return [[
//                'action' => 'manage',
//                'subject' => 'all',
//            ]];
//        }
//        $output = [];
//        foreach ($this->getAllPermissions() as $permission) {
//            $subject = $permission->model;
//            if (!in_array($permission->name, Permission::ADDITIONAL_PERMISSIONS, true)) {
//                $action = explode('_', $permission->name)[0];
//            } else {
//                $action = $permission->name;
//            }
//            $output[] = [
//                'action' => $action,
//                'subject' => $subject,
//            ];
//        }
//        return $output;
//    }
    public function getRoleIds()
    {
        return $this->whenLoaded('roles', function () {
            return $this->roles->sortByDesc('id')->pluck('id')->toArray();
        });
    }
}

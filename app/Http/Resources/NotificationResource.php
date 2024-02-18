<?php

namespace App\Http\Resources;

use \Illuminate\Http\Request;

class NotificationResource extends BaseResource
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
            'title'=> $this->title,
            'body' => $this->body,
            'data' => isset($this->data)? $this->data: "",
            'read_at' => isset($this->read_at)? $this->read_at: "",
            'redirect_type' => $this->redirect_type,
            'redirect_id' => $this->redirect_id,
            'created_at' => isset($this->created_at)? $this->created_at->diffForHumans() : "",
        ];
    }

}

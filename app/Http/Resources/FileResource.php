<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use \Illuminate\Http\Request;
use Str;

class FileResource extends BaseResource
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
            'name'=> $this->name,
        ];

        $this->mini = [
            'mime'   => $this->mime,
            'width'  => $this->when(Str::contains($this->mime, 'image'), $this->width),
            'height' => $this->when(Str::contains($this->mime, 'image'), $this->height),
            'url'    => asset('storage/' . $this->url),
            'path'   => '/storage/' . $this->url,
            'created_at'   =>  $this->created_at->format('Y-m-d g:i a'),
        ];

        $this->full = [

        ];

        $this->relations = [
        ];

        return $this->getResource();
    }
}

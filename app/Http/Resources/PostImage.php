<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostImage extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        //dd($this->resource->map->only('image_path'));
        return [
            'data' => $this->resource->pluck('image_path'),
            'image_count' => $this->count(),
            'path' => url('/images/large/'),

        ];
    }
}

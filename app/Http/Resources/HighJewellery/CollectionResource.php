<?php

namespace App\Http\Resources\HighJewellery;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image,
            'design_target_desc' => $this->design_target_desc,
            'design_target_img' => $this->design_target_img,

        ];
    }
}

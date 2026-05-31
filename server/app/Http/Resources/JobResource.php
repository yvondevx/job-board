<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'external_id'    => $this->external_id,
            'category_id'    => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'author_id'      => $this->author_id,
            'title'          => $this->title,
            'slug'           => $this->slug,
            'description'    => $this->description,
            'location'       => $this->location,
            'suburb'         => $this->suburb,
            'price_offer'    => $this->price_offer,
            'type'           => $this->type,
            'status'         => $this->status,
            'photos'         => $this->photos ?? [],
            'meta'           => $this->meta   ?? [],
            'created_at'     => $this->created_at?->toDateTimeString(),
            'updated_at'     => $this->updated_at?->toDateTimeString(),
        ];
    }
}

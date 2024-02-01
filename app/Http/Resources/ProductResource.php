<?php

namespace App\Http\Resources;

use App\Models\ProductImages;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'primary_image' => $this->primary_image,
            'images' => ProductImagesResource::collection($this->whenLoaded('images')),
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'delivery_amount' => $this->delivery_amount,
        ];
    }
}

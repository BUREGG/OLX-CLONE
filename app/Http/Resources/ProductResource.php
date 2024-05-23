<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'price'=>$this->price,
            'description' => $this->when($request->is('api/products*'),function(){
                return $this->description;
            }),
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'refresh' => $this->refresh,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'address' => $this->address,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at
        ];
        
    }
}

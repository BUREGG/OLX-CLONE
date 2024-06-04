<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\ProductUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);

        return[
            'id'=>$this->id,
            'name'=>$this->name,
            'email'=>$this->email,

            'products'=> ProductResource::collection($this->whenLoaded('products'))
        ];
    }
}

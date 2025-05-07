<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        $data = [
            'id'    => $this->id,
            'name'  => $this->name,
            'image' => $this->icon ? $this->full_image_url : asset('backend/images/no-image.jpg'),
            'product_list'=> ProductResource::collection(Product::where('status','1')->where('category_id',$this->id)->get()),
        ];
        return $data;
    }
}

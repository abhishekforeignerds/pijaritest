<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDeliveredListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $orderDetail = $this->order_detail;
        $data = [
            'id' => $this->id,
            'order_id' => optional($orderDetail)->order_id,
            'product_id' => optional($orderDetail)->product_id,
            'product_name' => optional($orderDetail)->product_name,
            'sku' => $this->product_stock->sku,
            'category' => optional($orderDetail)->category_name,
            'sub_category' => optional($orderDetail)->sub_category_name,
            'color' => optional($orderDetail)->color,
            'price' =>optional($orderDetail)->price,
            'grand_total' =>(optional($orderDetail)->price)*$this->quantity,
            'confirmed_date' => $this->confirmed_date,
            'shipped_date' => $this->shipped_date,
            'delivered_date' => $this->delivered_date,
            'cancelled_date' => $this->cancelled_date,
            'quantity' => $this->quantity,
            'date' => $this->date,
            'delivery_person' => $this->delivery_boy->name,
            'customer_name' =>  $this->order_detail->order->user->name,
            'product_image' =>  $this->order_detail->product_image,
        ];
        return $data;
    }
}


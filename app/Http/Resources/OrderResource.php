<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'user' => $this->user_id,
            'shipping_address' => json_decode($this->shipping_address),
            'payment_type' => $this->payment_type,
            'payment_status' => $this->payment_status,
            'delivery_status' => $this->delivery_status,
            'payment_details' => $this->payment_details,
            'grand_total' => $this->grand_total,
            'discount_type' => $this->discount_type,
            'discount' => $this->discount,
            'delivery_charge' => $this->delivery_charge,
            'delivery_type' => $this->delivery_type,
            'wallet_discount' => $this->wallet_discount,
            'coupon_discount' => $this->coupon_discount,
            'coupon_code' => $this->coupon_code,
            'code' => $this->code,
            'date' =>Carbon::createFromTimestamp($this->date)->format('d-m-Y') ,
            'status' => $this->status,
        ];

        return $data;
    }
}

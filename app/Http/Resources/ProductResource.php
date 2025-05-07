<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\ProductDatePrice;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id'      => $this->id,
            'name'    => $this->name,
            'variant' =>$this->product_stock_data($this->product_stock)
        ];
        return $data;
    }

    function product_stock_data($data){
      foreach($data as $stock){
        // $pdp=ProductDatePrice::where('product_id',$stock->product_id)->where('variant_id',$stock->id)->whereDate('date', '=', date('Y-m-d'))->first();
        // if(!empty($pdp->id)){
        //     $stock->mrp=$pdp->mrp;
        //     $stock->price=$pdp->price;
        // }
      }
      return $data;
    }

}

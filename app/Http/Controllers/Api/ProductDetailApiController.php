<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Favourite;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\ProductDatePrice;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class ProductDetailApiController extends Controller
{
    public function productDetail(Request $request,$id){
        $detail = Product::where('id', $id)->first();
        $variants = ProductStock::where('product_id', $id)->get();
        foreach ($variants as $variant) {
            $photo_array = [];
            if (is_array($variant->photos) || is_object($variant->photos)) {
                foreach($variant->photos as $photos){
                    array_push($photo_array,uploaded_asset($photos));
                }
            }
           $variant->photos = $photo_array;
           $user_id = $request->user_id;
           $is_fav = Favourite::where('user_id', $user_id)->where('product_id', $id)->where('variant_id', $id)->first();
           if ($is_fav) {
                $variant->is_fav = 1;
           }
           else {
                $variant->is_fav = 0;
           }
        //    $pdp=ProductDatePrice::where('product_id',$variant->product_id)->where('variant_id',$variant->id)->whereDate('date', '=', date('Y-m-d'))->first();
        //    if(!empty($pdp->id)){
        //        $variant->mrp=$pdp->mrp;
        //        $variant->price=$pdp->price;
        //    }
           $variant->product_price_date=ProductDatePrice::where('product_id',$variant->product_id)->where('variant_id',$variant->id)->get();
        }
        $related =ProductResource::collection( Product::where('category_id', $detail->category_id)->take(12)->get());
        return response()->json([
            'detail' => $detail,
            'variant' => $variants,
            'related'=>$related
        ], 200);
    }





}

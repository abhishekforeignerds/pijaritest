<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddToCartApiController extends Controller
{
    public function addCart(Request $request){
        $add_cart = new Cart;
        $add_cart->user_id = auth()->user()->id;
        $add_cart->product_id = $request->product_id;
        $add_cart->variant_id = $request->variant_id;
        $add_cart->subscription_date = json_encode($request->subcription_date);
        $add_cart->quantity = $request->quantity;
        $add_cart->save();

        return response()->json([
            'success' => true,
            'message' => 'Product Added to Cart',
        ], 200);
    }

    public function getCart(){
        $user_id = auth()->id();
        $get_cart = Cart::where('user_id', $user_id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Cart List',
            'data'    => $get_cart
        ], 200);
    }

    public function cartDelete($id){
        Cart::where('id', $id)->first()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product Remove from Cart'
        ], 200);
    }
}

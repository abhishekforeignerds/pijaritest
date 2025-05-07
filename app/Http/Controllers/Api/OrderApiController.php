<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\UserWallet;
use App\Models\OrderDetail;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\ProductDatePrice;
use App\Models\OrderSubscription;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\PhonepeController;

class OrderApiController extends Controller
{
    public function order(Request $request){

        // if(count(Order::where('user_id',auth()->user()->id)->where('payment_status','unpaid')->get()) > 0){
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Pending Payment',
        //     ], 422);
        // }

        $address = Address::find($request->address_id);
        $data = [
            'name' => $address->name,
            'phone' => $address->phone,
            'address' => $address->address,
            'state' => $address->state,
            'city' => $address->city,
            'pincode' => $address->pincode,
            'landmark' => $address->landmark,
            'area' => $address->area
        ];

        $order = new Order;
        $order->user_id = auth()->user()->id;
        $order->shipping_address = json_encode($data);
        $order->payment_type = $request->payment_type;
        $order->payment_status = $request->payment_status;
        $order->delivery_status = $request->delivery_status;
        $order->payment_details = $request->payment_details;
        $order->grand_total = $request->grand_total;
        $order->discount_type = $request->discount_type;
        $order->discount = $request->discount;
        $order->delivery_charge = $request->delivery_charge;
        $order->delivery_type = $request->delivery_type;
        $order->wallet_discount = $request->wallet_discount;
        $order->coupon_discount = $request->coupon_discount;
        $order->coupon_code = $request->coupon_code;
        $order->code = !empty(Order::latest()->first()->code)  ? Order::latest()->first()->code + 1 : 1001;
        $order->date = strtotime('now');
        $order->save();

        foreach (json_decode(json_encode($request->product)) as $product) {
            $varient_data = ProductStock::find($product->varient_id);
            $detail = new OrderDetail;
            $detail->order_id = $order->id;
            $detail->product_id = $varient_data->product_id;
            $detail->variant_id = $varient_data->id;
            $detail->product_name = $varient_data->product->name;
            $detail->category_name = $varient_data->category->name;
            $detail->sub_category_name = optional($varient_data->subcategory)->name;
            $detail->product_image = uploaded_asset($varient_data->thumbnail);
            $detail->color = $varient_data->color;
            $detail->s_w = $varient_data->s_w;
            $detail->price = $varient_data->price;
            $detail->mrp = $varient_data->mrp;
            $detail->tax = $varient_data->tax;
            // $detail->quantity = $varient_data->quantity;
            $detail->save();


                foreach($product->date->date as $key=>$date){

                    $mrp=$varient_data->mrp;
                    $price=$varient_data->price;


                    $pdp=ProductDatePrice::where('product_id',$varient_data->product_id)->where('variant_id',$varient_data->id)->whereDate('date', '=',$date)->first();
                    if(!empty($pdp->id)){
                        $mrp=$pdp->mrp;
                        $price=$pdp->price;
                    }

                    $order_subs = new OrderSubscription;
                    $order_subs->order_detail_id = $detail->id;
                    $order_subs->product_variant_id=$varient_data->id;
                    $order_subs->date = $date;
                    $order_subs->delivery_time = $request->delivery_time;
                    $order_subs->quantity =$product->date->quantity[$key];
                    $order_subs->color = $varient_data->color;
                    $order_subs->s_w = $varient_data->s_w;
                    $order_subs->price = $price;
                    $order_subs->mrp =$mrp;
                    $order_subs->tax = $varient_data->tax;
                    $order_subs->save();

                }

        }

        if( $request->wallet_discount > 0){
            $user = User::find(auth()->user()->id);

            $wallet = new UserWallet;
            $wallet->user_id =auth()->user()->id;
            $wallet->amount = $request->wallet_discount;
            $wallet->transaction_detail = 'Wallet is apply for order '.$order->code;
            $wallet->approval = 1;
            $wallet->transaction_type = 'debit';
            $wallet->save();

            $user->balance = $user->balance - $wallet->amount;
            $user->save();


        }

        // if($request->payment_type=="phonepe"){
        //     $request->merge(['user_id'=>auth()->user()->id,'order_id'=>$order->id]);

        //     $phone_pe=new PhonepeController();
        //     return  $phone_pe->pay($request);
        // }


        $merchantTransactionId = $order->payment_type . '-' . $order->id . '-' . $order->user_id . '-' . rand(0, 100000);
        return response()->json([
            'success' => true,
            'order_code'=>$order->code,
            'mt_transaction_id'=>$merchantTransactionId,
            'message' => 'Order Processing'
        ], 200);

    }
}

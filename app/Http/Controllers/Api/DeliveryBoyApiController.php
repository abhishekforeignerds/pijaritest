<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\DeliveryBoy;
use Illuminate\Http\Request;
use App\Models\OrderSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\OrderDeliveredListResource;

class DeliveryBoyApiController extends Controller
{
    public function login(Request $request){
        request()->validate([
            'phone'    => 'required|digits:10',
            'password' => 'required'
        ]);

        $delivery_user = DeliveryBoy::where('phone', $request->phone)->first();
        if (!empty($delivery_user)){
            if (Hash::check($request->password, $delivery_user->password)){
                $token = $delivery_user->createToken('mytoken')->plainTextToken;

                return response()->json([
                    'status'  => true,
                    'message' => 'User logged in',
                    'token'   => $token
                ], 200);
            }
            else{
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid Password'
                ], 404);
            }
        }
        else {
            return response()->json([
                'status'  => false,
                'message' => 'Please pass phone & password'
            ], 404);
        }
    }

    public function todayOrder(){
        $userId = auth()->id();
        $today = OrderSubscription::where('date', Carbon::today()->format('Y-m-d'))->where('delivery_boy_id',$userId)->with(['order_detail.order'])->orderBy('id','desc')->get();
        foreach($today as $order){
            $order->order_detail->order->shipping_address=json_decode($order->order_detail->order->shipping_address);
            $order->order_detail->order->date=Carbon::createFromTimestamp($order->order_detail->order->date)->format('d-m-Y');
            $order->sku=$order->product_stock->sku;
        }

        return response()->json([
            'success' => true,
            'message' => 'Today Order',
            'data'    => $today
        ], 200);
    }

    public function orderStatus(Request $request){
        request()->validate([
            'delivered_date' => 'nullable',
            'cancelled_date' => 'nullable'
        ]);
        $status = OrderSubscription::find($request->id);
        if ($request->status == 'delivered') {
            $status->delivered_date = Carbon::now();
            $status->status = 'delivered';
        }
        if ($request->status == 'cancelled') {
            $status->cancelled_date = Carbon::now();
            $status->status = 'cancelled';
            $order_subscription= $status;
            if($order_subscription->order_detail->order->payment_status=='paid'){

                $amount=$order_subscription->order_detail->price*$order_subscription->quantity;
                $user = User::find($order_subscription->order_detail->order->user_id);

                $wallet = new UserWallet;
                $wallet->user_id =$order_subscription->order_detail->order->user_id;
                $wallet->amount = $amount;
                $wallet->transaction_detail = 'Amount is credited due to order product cancel. Order Code '.$order_subscription->order_detail->order->code;
                $wallet->approval = 1;
                $wallet->transaction_type = 'credit';
                $wallet->save();

                $user->balance = $user->balance + $wallet->amount;
                $user->save();

            }


        }
        $status->save();

        return response()->json([
            'success' => true,
            'message' => 'Order Status Updated'
        ], 200);
    }

    public function orderDelivered(){
        try{
            $delivery_boy = auth()->id();
            $delivered = OrderSubscription::where('delivery_boy_id', $delivery_boy)->with(['order_detail.order'])->orderBy('id','desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'order delivered list',
                'data'    => OrderDeliveredListResource::collection($delivered)
            ], 200);
        }
        catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong !',
                'error'   => $th->getMessage()
            ], 401);
        }
    }

    public function deliveryBoyProfile(){
        $data = DeliveryBoy::where('id', auth()->id())->first();
        $data->profile_photo=uploaded_asset($data->profile_photo);
        return response()->json([
            'success' => true,
            'message' => 'Delivery Boy Profile',
            'data'    => $data
        ], 200);
    }

    public function deliveryBoyProfileUpdate(Request $request){
        request()->validate([
            'name'          => 'nullable',
            'email'         => 'nullable|email',
            'phone'         => 'nullable|digits:10|unique:delivery_boys,phone,' . auth()->id(),
            'profile_photo' => 'nullable|mimes:png,jpg,jpeg,webp'
        ]);

        $data = DeliveryBoy::where('id', auth()->id())->first();
        if($request->name){
            $data->name = $request->name;
        }
        if($request->email){
            $data->email = $request->email;
        }
        if($request->phone){
            $data->phone = $request->phone;
        }
        if($request->address){
            $data->address = $request->address;
        }
        if (!empty($request->profile_photo)) {
            $file = $request->file('profile_photo');
            $data->profile_photo = upload_file($request,'profile_photo');
        }
        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile Updated Successfully'
        ], 200);
    }

    public function changePassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
        ]);

        $user = DeliveryBoy::find(auth()->id());

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Old password is incorrect',
        ], 401);
    }

    public function forgotPassword(Request $request){
        request()->validate([
            'phone' =>'required|digits:10'
        ]);

        $otp = 1234;
        $deliveryBoy = DeliveryBoy::where('phone', $request->phone)->first();
        if (!$deliveryBoy) {
            return response()->json([
                'success' => false,
                'message' => 'Delivery Boy not found for the provided phone number'
            ], 404);
        }
        $deliveryBoy->otp = $otp;
        $deliveryBoy->save();

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully'
        ], 200);
    }

    public function resetPassword(Request $request){
        $request->validate([
            'phone' =>'required|digits:10',
            'otp' => 'required',
            'new_password' => 'required'
        ]);

        $deliveryBoy = DeliveryBoy::where('phone', $request->phone)->first();
        if (!$deliveryBoy) {
            return response()->json([
                'success' => false,
                'message' => 'DeliveryBoy not found for the provided phone number'
            ], 404);
        }
        if ($request->otp != $deliveryBoy->otp) {
            return response()->json([
                'success' => false,
                'message' => 'OTP is incorrect'
            ], 401);
        }
        $deliveryBoy->password = Hash::make($request->new_password);
        $deliveryBoy->otp = '';
        $deliveryBoy->save();

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully'
        ], 200);
    }
}

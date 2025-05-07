<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Models\OrderSubscription;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\WalletCollection;

class UserOrderApiController extends Controller
{
    public function orderDetail(Request $request){
        try {
            $detail = Order::where('user_id', auth()->id())->where('id', $request->id)->with('order_detail.order_subscription')->first();
            $detail->date=Carbon::createFromTimestamp($detail->date)->format('d-m-Y');
            $merchantTransactionId = $detail->payment_type . '-' . $detail->id . '-' . $detail->user_id . '-' . rand(0, 100000);
            return response()->json([
                'success' => true,
                'message' => 'User Order Detail',
                'detail' => $detail,
                'mt_transaction_id'=>$merchantTransactionId,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong !',
                'error'   => $th->getMessage()
            ], 401);
        }
    }

    public function orderCancel(Request $request){
        request()->validate([
            'cancelled_date' => 'nullable'
        ]);
        $status = OrderSubscription::find($request->id);
        if ($request->status == 'cancelled') {
            $status->cancelled_date = Carbon::now();
            $status->status = 'cancelled';
            $order_subscription=$status;
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


    public function balance()
    {
        $user = User::find(auth()->user()->id);

        $wallet_history=UserWallet::where('user_id', auth()->user()->id)->get();
        foreach($wallet_history as $wallet){
          $wallet->amount =   round($wallet->amount);
          $wallet->date =   $wallet->created_at->format('d-m-Y');
          $wallet->time =   $wallet->created_at->format('h:i A');
        }

        return response()->json([
            'balance' =>round($user->balance),
            'wallet_history'=>$wallet_history->makeHidden(['created_at','updated_at']),
            'success' => true,
            'status' => 200
        ]);
    }


}

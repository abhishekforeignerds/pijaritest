<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\OrderSubscription;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;

class PurchaseHistoryApiController extends Controller
{
    public function index(){
        try {
            $userId = auth()->id();
            $orders = Order::where('user_id', $userId)->orderBy('id','desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'User purchase history',
                'orders' => OrderResource::collection($orders)
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


    public function todayOrder(){
        $userId = auth()->id();
        $today = $today = Carbon::today()->format('Y-m-d');
        $todayOrder = OrderSubscription::where('date', $today)->whereHas('order_detail.order', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })->with(['order_detail.order'])->orderBy('id','desc')->get();
        return response()->json([
            'success' => true,
            'message' => 'Today Order',
            'data'    => $todayOrder
        ], 200);
    }
}

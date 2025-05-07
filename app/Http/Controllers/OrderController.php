<?php

namespace App\Http\Controllers;

use gv;
use PDF;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use Razorpay\Api\Api;
use App\Models\Pujari;
use App\Models\Vendor;
use App\Models\Address;
use App\Models\Product;
use App\Models\Service;
use App\Models\Inclusion;
use App\Models\UserWallet;
use App\Models\DeliveryBoy;
use App\Models\OneDayOrder;
use App\Models\OrderDetail;
use App\Exports\OrderExport;
use App\Models\GenialIncome;
use App\Models\ProductStock;
use App\Models\PujariWallet;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use App\Models\UserPPHistroy;
use App\Models\user_gv_histroy;
use App\Models\BusinessCategory;
use App\Models\OrderSubscription;
use App\Exports\OneDayOrderExport;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\DB;
use App\Models\VendorPaymentHistroy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\OrderPaymentTransaction;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function customer_order(Request $request)
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        return view('user_dashboard.customer.order', compact('orders'));
    }

    public function customer_order_details($id)
    {
        $order = Order::where('id', $id)->first();
        return view('user_dashboard.customer.order_details', compact('order'));
    }

    public function customer_e_puja_order(Request $request)
    {
        $orders = OneDayOrder::where('user_id', Auth::user()->id)->orderBy('id','desc')->paginate(20);
        return view('user_dashboard.customer.e_puja_order', compact('orders'));
    }

    public function customer_e_puja_order_details($id)
    {
        $order = OneDayOrder::where('id', $id)->first();
        return view('user_dashboard.customer.e_puja_order_details', compact('order'));
    }

    public function customer_service_order(Request $request)
    {
        $orders = ServiceOrder::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        return view('user_dashboard.customer.service_order', compact('orders'));
    }

    public function customer_service_order_details($id)
    {
        $order = ServiceOrder::where('id', $id)->first();
        return view('user_dashboard.customer.service_order_details', compact('order'));
    }

    public function vendor_order(Request $request)
    {
        $orders = Order::where('vendor_id', Auth::guard('vendor')->user()->id)->orderBy('id','desc')->get();
        return view('vendor_dashboard.order.order', compact('orders'));
    }

    public function admin_order(Request $request)
    {

        $orders = Order::with('order_detail')->latest();
        $dateRange = explode('-', $request->get('daterange'));

        if (!empty($request->get('daterange'))) {
            $start_date = Carbon::parse($dateRange[0])->toDateString();
            $end_date = Carbon::parse($dateRange[1])->toDateString();
        }


        if (!empty($request->get('daterange'))) {
            $orders = $orders->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
        }

        if (!empty($request->search)) {
            $searchValue=$request->search;
            $user_ids = User::where('name', 'like', '%' . $searchValue . '%')->orwhere('phone', 'like', '%' . $searchValue . '%')->orwhere('email', 'like', '%' . $searchValue . '%')->get()->pluck('id');
            $orders = $orders->whereIn('user_id', $user_ids);
        }
        if (!empty($request->get('payment_status'))) {
            $orders = $orders->where('payment_status',$request->payment_status);
        }
        if (!empty($request->get('location_type'))) {
            $orders = $orders->whereHas('order_detail', function ($query) use ($request) {
                $query->where('location', $request->location_type);
            });
        }

        if (!empty($request->get('puja_type'))) {
            $orders = $orders->whereHas('order_detail.product', function ($query) use ($request) {
                $query->where('product_type', $request->puja_type);
            });
        }


        if($request->export){
            $orders=$orders->get()->pluck('id');
            return Excel::download(new OrderExport($orders), 'order-report.xlsx');
        }

        $orders=$orders->paginate(20);
        return view('backend.order.order', compact('orders'));
    }

    public function admin_one_day_order(Request $request)
    {

        $orders = OneDayOrder::latest();

        $dateRange = explode('-', $request->get('daterange'));

        if (!empty($request->get('daterange'))) {
            $start_date = Carbon::parse($dateRange[0])->toDateString();
            $end_date = Carbon::parse($dateRange[1])->toDateString();
        }

        if (!empty($request->get('daterange'))) {
            $orders = $orders->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
        }

        if (!empty($request->search)) {
            $searchValue=$request->search;
            $user_ids = User::where('name', 'like', '%' . $searchValue . '%')->orwhere('phone', 'like', '%' . $searchValue . '%')->orwhere('email', 'like', '%' . $searchValue . '%')->get()->pluck('id');
            $orders = $orders->whereIn('user_id', $user_ids);
        }
        if (!empty($request->get('payment_status'))) {
            $orders = $orders->where('payment_status',$request->payment_status);
        }
        if (!empty($request->get('puja'))) {
            $orders = $orders->where('product_id',$request->puja);
        }
        if($request->export){
            $orders=$orders->get()->pluck('id');
            return Excel::download(new OneDayOrderExport($orders), 'one-day-order-report.xlsx');
        }
        $orders=$orders->paginate(20);



        return view('backend.order.one_day_order', compact('orders'));
    }

    public function order_payment_transaction($id){
            $order=Order::find($id);
            $order_payment_transaction=OrderPaymentTransaction::where('order_id',$id)->get();
            return view('backend.order.order_payment_transaction', compact('order_payment_transaction','order'));
    }

    public function order_payment_add(Request $request){
            $order=Order::find($request->order_id);
            $order->total_paid=$order->total_paid+$request->amount;
            $order->save();

            $order_payment_transaction =new OrderPaymentTransaction;
            $order_payment_transaction->order_id=$order->id;
            $order_payment_transaction->user_id=$order->user_id;
            $order_payment_transaction->amount=$request->amount;
            $order_payment_transaction->transaction_type='credit';
            $order_payment_transaction->save();

            return redirect()->back();
    }


    public function vendor_service_order(Request $request)
    {
        $orders = ServiceOrder::where('vendor_id', Auth::guard('vendor')->user()->id)->orderBy('id','desc')->get();
        return view('vendor_dashboard.order.service_order', compact('orders'));
    }

    public function admin_service_order(Request $request)
    {
        $orders = ServiceOrder::get();
        return view('backend.order.service_order', compact('orders'));
    }

    public function vendor_order_details($id)
    {
        $order = Order::where('id', $id)->first();
        return view('vendor_dashboard.order.order_details', compact('order'));
    }

    public function admin_order_details($id)
    {
        $order = Order::where('id', $id)->with('OrderDetail')->first();
        return view('backend.order.order_details', compact('order'));
    }

    public function admin_one_day_order_details($id)
    {
        $order = OneDayOrder::where('id', $id)->first();
        return view('backend.order.one_day_order_details', compact('order'));
    }

    public function delivery_boy_update(Request $request){

        request()->validate([
            'delivery_boy_id' => 'required'
        ]);
        $order_details=OrderDetail::where('order_id',$request->order_id)->get();
        foreach($order_details as $order_detail){
            $deliveres = OrderSubscription::where('order_detail_id',$order_detail->id)->get();
            foreach($deliveres as $deliver){
                $deliver->delivery_boy_id = $request->delivery_boy_id;
                $deliver->save();
            }
        }
        return back();
    }

    public function today_order()
    {
        $delivery_boy = DeliveryBoy::where('status','1')->get();
        $today_order = OrderSubscription::where('date', Carbon::today()->format('Y-m-d'))->with('order_detail')->orderBy('id','desc')->get();
        return view('backend.order.today_order', compact('today_order','delivery_boy'));
    }

    public function today_order_report(Request $request){

        $orders = OrderSubscription::with('order_detail')->groupBy('product_variant_id')->orderBy('id','desc');

        $dateRange = $request->get('daterange');
        $delivery_status=$request->get('delivery_status');

        if (!empty($request->get('daterange'))) {
            $orders = $orders->where('date', '=', $dateRange);
        }

        if (!empty($request->get('delivery_status'))) {
            $orders = $orders->where('status',$delivery_status);
        }

        $orders = $orders->paginate(10);
        return view('backend.order.today_order_report', compact('orders','dateRange','delivery_status'));

    }

    public function delivery_boy_order_report(Request $request){

        $orders = OrderSubscription::with('order_detail')->groupBy('delivery_boy_id')->orderBy('id','desc');

        $dateRange = $request->get('daterange');
        $delivery_status=$request->get('delivery_status');

        if (!empty($request->get('daterange'))) {
            $orders = $orders->where('date', '=', $dateRange);
        }

        if (!empty($request->get('delivery_status'))) {
            $orders = $orders->where('status',$delivery_status);
        }

        $orders = $orders->paginate(10);
        return view('backend.order.delivery_boy_order_report', compact('orders','dateRange','delivery_status'));

    }


    public function status_update(Request $request)
    {

        $order_subscription = OrderSubscription::find($request->order_subscrition_id);
        $order_subscription->delivery_boy_id=$request->delivery_boy_id;
        if ($request->status == 'confirmed') {
            $order_subscription->confirmed_date = Carbon::now();
            $order_subscription->status = 'confirmed';
        }
        if ($request->status == 'shipped') {
            $order_subscription->shipped_date = Carbon::now();
            $order_subscription->status = 'shipped';
        }
        if ($request->status == 'delivered') {
            $order_subscription->delivered_date = Carbon::now();
            $order_subscription->status = 'delivered';
        }
        if ($request->status == 'cancelled') {
            $order_subscription->cancelled_date = Carbon::now();
            $order_subscription->status = 'cancelled';

            if($order_subscription->order_detail->order->payment_status=='paid'){

                $amount=$order_subscription->order_detail->price*$order_subscription->quantity;
                $user = User::find($order_subscription->order_detail->order->id);

                $wallet = new UserWallet;
                $wallet->user_id =$order_subscription->order_detail->order->id;
                $wallet->amount = $amount;
                $wallet->transaction_detail = 'Amount is credited due to order product cancel. Order Code '.$order_subscription->order_detail->order->code;
                $wallet->approval = 1;
                $wallet->transaction_type = 'credit';
                $wallet->save();

                $user->balance = $user->balance + $wallet->amount;
                $user->save();

            }


        }
        $order_subscription->save();

        return 1;
    }

    public function pujariji_update(Request $request){

        $order= OrderDetail::find($request->id);

        if(!empty($order->pujari_id)){

            $order->pujari_status='';
            $order->save();

            $pujari=Pujari::find($order->pujari_id);
            $pujari->admin_to_pay = $pujari->admin_to_pay-$order->pujari_comission;
            $pujari->save();

        }



        $order->pujari_id=$request->pujari_id;
        $order->pujari_comission=$request->pujari_comission;
        $order->save();

        $pujari=Pujari::find($request->pujari_id);
        $pujari->admin_to_pay = $pujari->admin_to_pay+$request->pujari_comission;
        $pujari->save();

        return 1;
    }



    public function order_payment_status_update(Request $request){

        $order= Order::find($request->order_id);
        $order->payment_status=$request->status;
        $order->save();

        return 1;
    }


    public function vendor_service_order_details($id)
    {
        $order = ServiceOrder::where('id', $id)->first();
        return view('vendor_dashboard.order.service_order_details', compact('order'));
    }

    public function admin_service_order_details($id)
    {
        $order = ServiceOrder::where('id', $id)->first();
        return view('backend.order.service_order_details', compact('order'));
    }


    public function customer_order_show(Request $request, $id)
    {
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {

       // return $request->all();


        $check_user=Auth::check();
        if($check_user)
        {
            $user_id=Auth::user()->id;
            $cart_items=Cart::where('user_id',$user_id)->get();
        }
        else
        {
            $check_session=Session::get('guest_id');
            $cart_items=Cart::where('user_id',$check_session)->get();
            $customer=User::where('phone',$request->phone)->orwhere('email',$request->email)->first();
            if(!empty($customer->id)){
                $user_id=$customer->id;
            }else{
                $customer=new User;
                $customer->name=$request->name;
                $customer->email=$request->email;
                $customer->phone=$request->phone;
                $customer->password=Hash::make($request->password);
                $customer->save();

                $user_id=$customer->id;
            }
        }
        $payment_detalis='';
        $payment_status='Unpaid';
        $total_paid=0;
        if(!empty($request->razorpay_payment_id)){
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $response = $api->payment->fetch($request->razorpay_payment_id);

            $payment_detalis = json_encode(array('id' => $response['id'],'method' => $response['method'],'amount' => $response['amount']/100,'currency' => $response['currency']));
            $total_paid=$response['amount']/100;
        }

        if($request->deposite_radio=='pay_advance'){
            $payment_status='partial';
        }
        if($request->deposite_radio=='pay_full'){
            $payment_status='paid';
        }


     $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'state' => $request->state,
            'city' => $request->city,
            'pincode' => $request->zip_code,
            'email' => $request->email,
        ];

        $order = new Order;
        $order->user_id = $user_id;
        $order->shipping_address = json_encode($data);
        $order->payment_type = 'razorpay';
        $order->payment_status =$payment_status;
        $order->payment_details=$payment_detalis;
        $order->rashi_name = $request->rashi_name;
        $order->dob = $request->dob;
        $order->gotra = $request->gotra;
        $order->varn = $request->varn;
        $order->wife_name=$request->wife_name;
        $order->discount_type = $request->discount_type;
        $order->discount = $request->discount;
        $order->wallet_discount = $request->wallet_discount;
        $order->coupon_discount = $request->coupon_discount;
        $order->coupon_code = $request->coupon_code;
        $order->code = !empty(Order::latest()->first()->code)  ? Order::latest()->first()->code + 1 : 1001;
        $order->date = strtotime('now');
        $order->save();


        $total=0;

        foreach ($cart_items as $item) {

            $detail = new OrderDetail;
            $detail->order_id = $order->id;
            $detail->product_id = $item->product_id;
            $detail->package_id = $item->package_id;
            $detail->product_name = $item->product->name;
            $detail->package_name = $item->package->package_name;
            $detail->product_image = $item->product->full_image_url;
            $detail->inclusion = $item->inclusion;
            $detail->city = $item->city;
            $detail->language = $item->language;
            $detail->location = $item->location;
            $detail->date=$item->date;
            $detail->time=$item->time;
            $detail->price = $item->package->discount_price;
            $total_inclusion=0;
            if(!empty($item->inclusion)){
                $inclusion_price=[];
                foreach(json_decode($item->inclusion) as $inclusion){
                    $inclusion_data=Inclusion::find($inclusion);
                    $total_inclusion=$total_inclusion+$inclusion_data->price;
                    array_push($inclusion_price,$inclusion_data->price);
                }
                $detail->inclusion_price = json_encode($inclusion_price);
            }

            $detail->save();

            $total=$total+$item->package->discount_price+$total_inclusion;
        }

        $order->grand_total=$total;
        $order->total_paid=$total_paid;

        $order->save();
        foreach($cart_items as $item){
            $item->delete();
        }


        order_confirmed_sms($request->phone,$request->name,$order->code);
        return ['data'=>route('order_confirmation',$order->id)];

    }

    public function oneday_order_store(Request $request)
    {

      //  return $request->all();

        $check_user=Auth::check();
        if($check_user)
        {
            $user_id=Auth::user()->id;
            $cart_items=Cart::where('user_id',$user_id)->first();
        }
        else
        {
            $check_session=Session::get('guest_id');
            $cart_items=Cart::where('user_id',$check_session)->first();
            $customer=User::where('phone',$request->phone)->first();
            if(!empty($customer->id)){
                $user_id=$customer->id;
            }else{
                $customer=new User;
                $customer->name=$request->name[0];
                $customer->phone=$request->phone;
                $customer->password=Hash::make($request->phone);
                $customer->save();
                $user_id=$customer->id;
            }
        }
        $payment_detalis='';
        $payment_status='Unpaid';
        $total_paid=0;
        if(!empty($request->razorpay_payment_id)){
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $response = $api->payment->fetch($request->razorpay_payment_id);

            $payment_detalis = json_encode(array('id' => $response['id'],'method' => $response['method'],'amount' => $response['amount']/100,'currency' => $response['currency']));
            $total_paid=$response['amount']/100;
        }

        if($request->deposite_radio=='pay_advance'){
            $payment_status='partial';
        }
        if($request->deposite_radio=='pay_full'){
            $payment_status='paid';
        }

        $total=0;

     $data = [
            'house_no' => $request->house_no,
            'area' => $request->area,
            'landmark' => $request->landmark,
            'state' => $request->state,
            'city' => $request->city,
            'pincode' => $request->pincode,
        ];

        $order = new OneDayOrder;
        $order->user_id = $user_id;
        $order->shipping_address = json_encode($data);
        $order->payment_type = 'razorpay';
        $order->payment_status =$payment_status;
        $order->payment_details=$payment_detalis;
        $order->phone = $request->phone;
        $order->dakshina = $request->dakshina;
        $order->alternate_contact = $request->alternate_contact;
        $order->gotra = $request->gotra;

        $order->code = !empty(OneDayOrder::latest()->first()->code)  ? OneDayOrder::latest()->first()->code + 1 : 1001;
        $order->date = strtotime('now');
        $order->name = json_encode($request->name);

        $item=$cart_items;

        if($request->is_prasahd=='yes'){
            $order->is_prashad = 1;
            $order->prashad_price = $item->product->prashad_price;
        }
        $order->product_id = $item->product_id;
        $order->package_id = $item->package_id;
        $order->product_name = $item->product->name;
        $order->package_name = $item->package->package_name;
        $order->product_image = $item->product->full_image_url;
        $order->inclusion = $item->inclusion;

        $order->price = $item->package->discount_price;
        $total_inclusion=0;
        if(!empty($item->inclusion)){
            $inclusion_price=[];
            foreach(json_decode($item->inclusion) as $inclusion){
                $inclusion_data=Inclusion::find($inclusion);
                $total_inclusion=$total_inclusion+$inclusion_data->price;
                array_push($inclusion_price,$inclusion_data->price);
            }
            $order->inclusion_price = json_encode($inclusion_price);
        }

        $order->save();

        $total=$total+$item->package->discount_price+$total_inclusion;


    $order->grand_total=$total;
    $order->total_paid=$total_paid;

    $order->save();
    $item->delete();


        order_confirmed_sms($request->phone,$request->name[0],$order->code);
        return ['data'=>route('one_day_order.confirmation',$order->id)];

    }

    public function order_confirmation($id){
        $order=Order::find($id);
        return view('frontend.order_confirmation',compact('order'));
    }

    public function one_day_order_confirmation($id){
        $order = OneDayOrder::find($id);
        return view('frontend.one-day-order-confirmation',compact('order'));
    }

    public function process_order(Request $request)
    {

        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $combined_order_id = date('Ymd-His').rand(10, 99);
        $vendor_products = array();
        foreach ($carts as $cartItem) {
            $product_ids = array();
            $product = Product::find($cartItem['product_id']);
            if (isset($vendor_products[$product->vendor_id])) {
                $product_ids = $vendor_products[$product->vendor_id];
            }
            array_push($product_ids, $cartItem);
            $vendor_products[$product->vendor_id] = $product_ids;
        }
        foreach ($vendor_products as $keys => $vendor_product) {

            $order = new Order;
            $order->combined_order_id = $combined_order_id;
            $order->user_id = Auth::user()->id;
            $order->vendor_id =  $keys;
            $address = Address::find($request->address_id);
            $data = [];

            $data['name'] = $address->name;
            $data['phone'] = $address->phone;
            $data['address'] = $address->address;
            $data['state'] = $address->state;
            $data['city'] = $address->city;
            $data['pincode'] = $address->pincode;
            $data['landmark'] = $address->landmark;
            $data['area'] = $address->area;


            $shipping_info = $data;
            $order->shipping_address = json_encode($shipping_info);
            $order->delivery_type = 'home_delivery';
            $order->payment_type = $request->payment_option;
            if(!empty($request->payment_details)){
                $order->payment_status = 'paid';
            }else{
                $order->payment_status = 'unpaid';
            }
            $order->payment_details = $request->payment_details;
            $order->code = !empty(Order::latest()->first()->code)  ? Order::latest()->first()->code + 1 : 1001;
            $order->date = strtotime('now');
            $order->save();
            $grand_total = 0;
            $coupon_discount = 0;
            $delivery_charge = 45;

            foreach ($vendor_product as $key => $cartItem) {
                $order_detail = new OrderDetail;
                $order_detail->order_id  = $order->id;
                $product_stock = ProductStock::find($cartItem['variant_id']);
                $order_detail->product_id = $product_stock->product->id;
                $order_detail->vendor_id = $product_stock->product->vendor_id;
                $order_detail->variant_id = $product_stock->id;
                $order_detail->product_name = $product_stock->product->name;
                $order_detail->business_category_id = $product_stock->product->category->business_category_id;
                $order_detail->category_name = $product_stock->product->category->name;
                $order_detail->sub_category_name = $product_stock->product->subcategory->name;
                $order_detail->product_image = $product_stock->thumbnail;
                $order_detail->color = $product_stock->color;
                $order_detail->s_w = $product_stock->s_w;
                $order_detail->price = $product_stock->price;
                $order_detail->mrp = $product_stock->mrp;
                $order_detail->quantity = $cartItem['quantity'];
                $order_detail->save();

                $product_stock->quantity = $product_stock->quantity - $order_detail->quantity;
                $product_stock->save();


                $grand_total = $grand_total + ($order_detail->price * $order_detail->quantity);
            }
            // if ($request->delivery_type == 'home_delivery') {
            //     $shipping_info =  checkPincode($address->pincode);
            //     $free_delivery = $shipping_info['shipping_data']['free_delivery_above'];
            //     $shipping_cost = $shipping_info['shipping_data']['delivery_charge'];
            //     $delivery_charge = $shipping_cost;

            //     if (!empty($shipping_info['shipping_data']['free_delivery_above']) && ($grand_total >= $free_delivery)) {
            //         $delivery_charge = 0;
            //     }
            // }

            // if (!empty(session()->get('coupon_id'))) {
            //     $applied_coupons = Coupon::where('id', session()->get('coupon_id'))->first();
            //     $order->coupon_code = $applied_coupons->code;
            //     if ($applied_coupons->type == 'free_shipping') {
            //         $delivery_charge = 0;
            //     }
            //     $order->coupon_discount = session()->get('coupon_discount');
            //     $coupon_discount = session()->get('coupon_discount');

            //     $coupon_usage = new CouponUsage;
            //     $coupon_usage->user_id = Auth::user()->id;
            //     $coupon_usage->coupon_id = session()->get('coupon_id');
            //     $coupon_usage->save();
            // }

                if($grand_total >= 1000){
                    $delivery_charge=0;
                }


            $grand_total = $grand_total + $delivery_charge ;

            // if (!empty($request->razorpay_payment_id)) {

            //     $api = new Api($seller_data->key, $seller_data->secret);
            //     $payment = $api->payment->fetch($request->razorpay_payment_id);

            //     $payment_detalis = null;
            //     try {
            //         $response = $api->payment->fetch($request->razorpay_payment_id)->capture(array('amount' => $payment['amount']));
            //         $payment_detalis = json_encode(array('id' => $response['id'], 'method' => $response['method'], 'amount' => $response['amount'], 'currency' => $response['currency']));

            //         $order->payment_details = $payment_detalis;
            //         $order->payment_status = 'paid';
            //     } catch (\Exception $e) {
            //         return  $e->getMessage();
            //     }
            // }



            $order->delivery_charge = $delivery_charge;
            $order->grand_total = $grand_total;
            $order->save();
        }

        Cart::where('user_id', Auth::user()->id)->delete();

        // session()->forget('coupon_id');
        // session()->forget('coupon_discount');

        $response_data=json_decode($request->payment_details);
        $payment = PaymentTransaction::where('mt_id',$response_data->data->merchantTransactionId)->first();
        $payment->payment_details = $request->payment_details;
        $payment->status = 'success';
        $payment->save();

        return view('frontend.order-success', compact('combined_order_id'));
    }

    public function book_service(Request $request)
    {

        $service_data = Service::find($request->service_id);
        $order = new ServiceOrder;
        $order->user_id = Auth::user()->id;
        $order->vendor_id = $service_data->vendor_id;
        $order->business_catgeory_id = $service_data->category->business_category_id;
        $order->service_id = $service_data->id;
        $order->service_name = $service_data->name;
        $order->mrp = $service_data->mrp;
        $order->price = $service_data->price;
        $order->service_image = $service_data->thumbnail;
        $address = Address::find($request->address_id);
        $data = [];

        $data['name'] = $address->name;
        $data['phone'] = $address->phone;
        $data['address'] = $address->address;
        $data['state'] = $address->state;
        $data['city'] = $address->city;
        $data['pincode'] = $address->pincode;
        $data['landmark'] = $address->landmark;
        $data['area'] = $address->area;


        $shipping_info = $data;
        $order->shipping_address = json_encode($shipping_info);
        $order->delivery_type = 'home_delivery';
        $order->payment_type = $request->payment_option;
        $order->payment_status = 'unpaid';
        $order->payment_details = '';
        $order->code = !empty(ServiceOrder::latest()->first()->code)  ? ServiceOrder::latest()->first()->code + 1 : 1001;
        $order->date = strtotime('now');
        $order->grand_total = $service_data->price;
        $order->save();

        return view('frontend.order_success_service', compact('order'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function update_delivery_status(Request $request)
    {
        $order = Order::find($request->order_id);
        $vendor = Vendor::find($order->vendor_id);
        $categories = json_decode($vendor->business_category);
        $vendor_balance_amount = json_decode($vendor->business_category_product_balance);
        $commissions = json_decode($vendor->product_comission_percentage);
        $commissions_type = json_decode($vendor->product_type_comission);


        if ($request->status == 'delivered') {
            foreach (OrderDetail::where('order_id', $order->id)->groupBy('business_category_id')->get() as $data) {
                $category_amount = OrderDetail::where('order_id', $order->id)->where('business_category_id', $data->business_category_id)->sum(DB::raw('price * quantity'));
                foreach ($categories as $key => $category) {
                    if ($category == $data->business_category_id) {
                        if ($commissions_type[$key] == 'percent') {
                            if ($category_amount > $vendor_balance_amount[$key]) {
                                $business_category = BusinessCategory::find($category);
                                return ['msg' => 'Please Recharge Category: ' . $business_category->name . ' to confirm order', 'status' => 0];
                            }
                        }
                        if ($commissions_type[$key] == 'amount') {
                            if ($commissions[$key] > $vendor_balance_amount[$key]) {
                                $business_category = BusinessCategory::find($category);
                                return ['msg' => 'Please Recharge Category: ' . $business_category->name . ' to confirm order', 'status' => 0];
                            }
                        }
                    }
                }
            }

            $business_category_balance = [];
            foreach (OrderDetail::where('order_id', $order->id)->groupBy('business_category_id')->get() as $data) {
                $category_amount = OrderDetail::where('order_id', $order->id)->where('business_category_id', $data->business_category_id)->sum(DB::raw('price * quantity'));
                foreach ($categories as $key => $category) {

                    if ($category == $data->business_category_id) {
                        if ($commissions_type[$key] == 'percent') {
                            $balance_amount = $vendor_balance_amount[$key] - ($category_amount);

                            $payment = new VendorPaymentHistroy;
                            $payment->vendor_id = $vendor->id;
                            $payment->payment_id = rand(1111, 9999);
                            $payment->payment_amount = $category_amount;
                            $payment->method = '';
                            $payment->transaction_type = 'debit';
                            $payment->description = 'Payment debited for order product';
                            $payment->status = 1;
                            $payment->save();
                        }
                        if ($commissions_type[$key] == 'amount') {

                            $balance_amount = $vendor_balance_amount[$key] - ($commissions[$key]);

                            $payment = new VendorPaymentHistroy;
                            $payment->vendor_id = $vendor->id;
                            $payment->payment_id = rand(1111, 9999);
                            $payment->payment_amount = $commissions[$key];
                            $payment->method = '';
                            $payment->transaction_type = 'debit';
                            $payment->description = 'Payment debited for order product';
                            $payment->status = 1;
                            $payment->save();
                        }
                    } else {
                        $balance_amount = $vendor_balance_amount[$key];
                    }
                    array_push($business_category_balance, $balance_amount);
                }
            }
            $vendor->business_category_product_balance = json_encode($business_category_balance);
            $vendor->save();

            $order->delivery_status = $request->status;
            $order->save();
        }


        if ($request->status == 'delivered') {
            foreach (OrderDetail::where('order_id', $order->id)->groupBy('business_category_id')->get() as $data) {
                $category_amount = OrderDetail::where('order_id', $order->id)->where('business_category_id', $data->business_category_id)->sum(DB::raw('price * quantity'));
                foreach ($categories as $key => $category) {

                    if ($category == $data->business_category_id) {

                        $comission_catgeory_percentage = $commissions[$key];
                        $total_comission_amount = ($category_amount * $comission_catgeory_percentage) / 100;
                        $order_user_comission_gb = (($total_comission_amount * get_setting('gv_comission_percentage_product')) / 100) / 25;
                        $order_user = User::find($order->user_id);
                        $order_user->pp = $order_user->pp + $order_user_comission_gb;
                        $order_user->save();

                        $genial_income = new GenialIncome;
                        $genial_income->user_id=$order->user_id;
                        $genial_income->vendor_id=$order->vendor_id;
                        $genial_income->order_id=$order->id;
                        $genial_income->order_amount=$category_amount;
                        $genial_income->type='web';
                        $genial_income->genial_amount=(($total_comission_amount *(100 - get_setting('gv_comission_percentage_product'))) / 100);
                        $genial_income->genial_percent=(100 - get_setting('gv_comission_percentage_product'));
                        $genial_income->save();

                        $order_user_pp_transaction = new UserPPHistroy;
                        $order_user_pp_transaction->user_id = $order_user->id;
                        $order_user_pp_transaction->pp = $order_user_comission_gb;
                        $order_user_pp_transaction->type = 'credited';
                        $order_user_pp_transaction->detail = 'PP Transfer from order.';
                        $order_user_pp_transaction->save();

                        $referral_code = $order_user->referral_by;
                        $current_user = User::find($order->user_id);

                        do {
                            $parent_user = User::where('referral_code', $referral_code)->first();
                            if(!empty($parent_user)){
                                $parent_user->gb = $parent_user->gb + $order_user_comission_gb;
                                $parent_user->save();

                                $parent_user_gv_transaction = new user_gv_histroy;
                                $parent_user_gv_transaction->user_id = $parent_user->id;
                                $parent_user_gv_transaction->from_user_id = $order_user->id;
                                $parent_user_gv_transaction->gv = $order_user_comission_gb;
                                $parent_user_gv_transaction->type = 'credited';
                                $parent_user_gv_transaction->detail = 'Gv Transfer from team purchase.';
                                $parent_user_gv_transaction->save();


                            $current_user = $parent_user;
                            $referral_code = $parent_user->referral_by;
                            }
                        } while (!empty(User::where('referral_code', $referral_code)->first()));
                    }
                }
            }
            $order->delivery_status = $request->status;
            $order->save();
        }


    }

    public function update_service_order_delivery_status(Request $request)
    {
       // return $request->all();
        $order = ServiceOrder::find($request->order_id);
        $vendor = Vendor::find($order->vendor_id);
        $categories = json_decode($vendor->business_category);
        $vendor_balance_amount = json_decode($vendor->business_category_service_balance);
        $commissions = json_decode($vendor->service_comission_percentage);
        $commissions_type = json_decode($vendor->service_type_comission);

        if ($request->status == 'confirmed') {

                $category_amount = $order->grand_total;
                foreach ($categories as $key => $category) {
                    if ($category == $order->business_catgeory_id) {
                        if ($commissions_type[$key] == 'percent') {
                            if ($category_amount > $vendor_balance_amount[$key]) {
                                $business_category = BusinessCategory::find($category);
                                return ['msg' => 'Please Recharge Category: ' . $business_category->name . ' to confirm order', 'status' => 0];
                            }
                        }
                        if ($commissions_type[$key] == 'amount') {
                            if ($commissions[$key] > $vendor_balance_amount[$key]) {
                                $business_category = BusinessCategory::find($category);
                                return ['msg' => 'Please Recharge Category: ' . $business_category->name . ' to confirm order', 'status' => 0];
                            }
                        }
                    }

                }

            $business_category_balance = [];

                $category_amount =  $order->grand_total;
                foreach ($categories as $key => $category) {

                    if ($category == $order->business_catgeory_id) {
                        if ($commissions_type[$key] == 'percent') {
                            $balance_amount = $vendor_balance_amount[$key] - ($category_amount);

                            $payment = new VendorPaymentHistroy;
                            $payment->vendor_id = $vendor->id;
                            $payment->payment_id = rand(1111, 9999);
                            $payment->payment_amount = $category_amount;
                            $payment->method = '';
                            $payment->transaction_type = 'debit';
                            $payment->description = 'Payment debited for service order product';
                            $payment->status = 1;
                            $payment->save();
                        }
                        if ($commissions_type[$key] == 'amount') {

                            $balance_amount = $vendor_balance_amount[$key] - ($commissions[$key]);

                            $payment = new VendorPaymentHistroy;
                            $payment->vendor_id = $vendor->id;
                            $payment->payment_id = rand(1111, 9999);
                            $payment->payment_amount = $commissions[$key];
                            $payment->method = '';
                            $payment->transaction_type = 'debit';
                            $payment->description = 'Payment debited for service order product';
                            $payment->status = 1;
                            $payment->save();
                        }
                    } else {
                        $balance_amount = $vendor_balance_amount[$key];
                    }
                    array_push($business_category_balance, $balance_amount);
                }

            $vendor->business_category_service_balance = json_encode($business_category_balance);
            $vendor->save();

            $order->delivery_status = $request->status;
            $order->save();
        }

        if ($request->status == 'confirmed') {

                $category_amount = $order->grand_total;
                foreach ($categories as $key => $category) {

                    if ($category == $order->business_catgeory_id) {

                        $comission_catgeory_percentage = $commissions[$key];
                        $total_comission_amount = ($category_amount * $comission_catgeory_percentage) / 100;
                        $order_user_comission_gb = (($total_comission_amount * get_setting('gv_comission_percentage_service')) / 100) / 25;
                        $order_user = User::find($order->user_id);
                        $order_user->pp = $order_user->pp + $order_user_comission_gb;
                        $order_user->save();


                        $genial_income = new GenialIncome;
                        $genial_income->user_id=$order->user_id;
                        $genial_income->vendor_id=$order->vendor_id;
                        $genial_income->order_id=$order->id;
                        $genial_income->order_amount=$category_amount;
                        $genial_income->type='web';
                        $genial_income->genial_amount=(($total_comission_amount *(100 - get_setting('gv_comission_percentage_service'))) / 100);
                        $genial_income->genial_percent=(100 - get_setting('gv_comission_percentage_service'));
                        $genial_income->save();

                        $order_user_pp_transaction = new UserPPHistroy;
                        $order_user_pp_transaction->user_id = $order_user->id;
                        $order_user_pp_transaction->pp = $order_user_comission_gb;
                        $order_user_pp_transaction->type = 'credited';
                        $order_user_pp_transaction->detail = 'PP Transfer from service order.';
                        $order_user_pp_transaction->save();

                        $referral_code = $order_user->referral_by;
                        $current_user = User::find($order->user_id);

                        do {
                            $parent_user = User::where('referral_code', $referral_code)->first();
                            if(!empty($parent_user)){
                                $parent_user->gb = $parent_user->gb + $order_user_comission_gb;
                                $parent_user->save();

                                $parent_user_gv_transaction = new user_gv_histroy;
                                $parent_user_gv_transaction->user_id = $parent_user->id;
                                $parent_user_gv_transaction->from_user_id = $order_user->id;
                                $parent_user_gv_transaction->gv = $order_user_comission_gb;
                                $parent_user_gv_transaction->type = 'credited';
                                $parent_user_gv_transaction->detail = 'Gv Transfer from team purchase.';
                                $parent_user_gv_transaction->save();


                            $current_user = $parent_user;
                            $referral_code = $parent_user->referral_by;
                            }
                        } while (!empty(User::where('referral_code', $referral_code)->first()));
                    }
                }

        }

    }


    public function pujari_model(Request $request){
        $order_detail= OrderDetail::where('id', $request->order_detail_id)->first();
        $order=Order::where('id',$order_detail->id)->first();
        $pujari_ji_id=$request->pujari_ji_id;
        return view('backend.order.pujari_model',compact('order_detail','order','pujari_ji_id'))->render();
    }

    public function invoice($id){
        $order = Order::where('id',$id)->first();
        return view('backend.order.invoice',compact('order'));
    }

    public function one_day_order_invoice($id){
        $order = OneDayOrder::where('id',$id)->first();
        return view('backend.order.one_day_order_invoice',compact('order'));
    }

    public function download_invoice($id){

        $order = Order::where('id',$id)->first();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
        ])->loadView('backend.order.download_invoice', compact('order'));
        return $pdf->download('order-'.$order->id.'.pdf');


    }

    public function pujari_comission(Request $request){

    }


}

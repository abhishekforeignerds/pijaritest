<?php

namespace App\Http\Controllers;

use gv;
use Carbon\Carbon;
use App\Models\Pos;
use App\Models\User;
use App\Models\Vendor;
use App\Models\GenialIncome;
use Illuminate\Http\Request;
use App\Models\UserPPHistroy;
use App\Models\user_gv_histroy;
use App\Models\BusinessCategory;
use App\Models\VendorPaymentHistroy;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pos_list = Pos::where('vendor_id', Auth::guard('vendor')->user()->id)->orderBy('id','desc');

        $dateRange = explode('-', $request->get('daterange'));

        if (!empty($request->get('daterange'))) {
            $start_date = Carbon::parse($dateRange[0])->toDateString();
            $end_date = Carbon::parse($dateRange[1])->toDateString();
        }


        if (!empty($request->get('daterange'))) {
            $pos_list = $pos_list->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
        }

        if (!empty($request->search)) {
            $searchValue=$request->search;
            $user_ids = User::where('name', 'like', '%' . $searchValue . '%')->orwhere('phone', 'like', '%' . $searchValue . '%')->orwhere('email', 'like', '%' . $searchValue . '%')->orwhere('referral_code', 'like', '%' . $searchValue . '%')->get()->pluck('id');
            $pos_list = $pos_list->whereIn('user_id', $user_ids);
        }

        $pos_list= $pos_list->get();

        return view('vendor_dashboard.pos.index', compact('pos_list'));
    }

    public function admin_pos(Request $request)
    {
        $pos_list = Pos::orderBy('id','desc');

        $dateRange = explode('-', $request->get('daterange'));

        if (!empty($request->get('daterange'))) {
            $start_date = Carbon::parse($dateRange[0])->toDateString();
            $end_date = Carbon::parse($dateRange[1])->toDateString();
        }


        if (!empty($request->get('daterange'))) {
            $pos_list = $pos_list->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
        }

        if (!empty($request->search)) {
            $searchValue=$request->search;
            $user_ids = User::where('name', 'like', '%' . $searchValue . '%')->orwhere('phone', 'like', '%' . $searchValue . '%')->orwhere('email', 'like', '%' . $searchValue . '%')->orwhere('referral_code', 'like', '%' . $searchValue . '%')->get()->pluck('id');
            $pos_list = $pos_list->whereIn('user_id', $user_ids);
        }

        if (!empty($request->vendor_id)) {
            $pos_list = $pos_list->where('vendor_id', $request->vendor_id);
        }

        $pos_list =  $pos_list->get();
        return view('backend.pos.index', compact('pos_list'));
    }

    public function customer_pos(Request $request)
    {
        $pos_list = Pos::where('user_id', Auth::user()->id)->orderBy('id','desc');

        $dateRange = explode('-', $request->get('daterange'));

        if (!empty($request->get('daterange'))) {
            $start_date = Carbon::parse($dateRange[0])->toDateString();
            $end_date = Carbon::parse($dateRange[1])->toDateString();
        }


        if (!empty($request->get('daterange'))) {
            $pos_list = $pos_list->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
        }

        if (!empty($request->search)) {
            $searchValue=$request->search;
            $user_ids = User::where('name', 'like', '%' . $searchValue . '%')->orwhere('phone', 'like', '%' . $searchValue . '%')->orwhere('email', 'like', '%' . $searchValue . '%')->orwhere('referral_code', 'like', '%' . $searchValue . '%')->get()->pluck('id');
            $pos_list = $pos_list->whereIn('user_id', $user_ids);
        }

        $pos_list= $pos_list->get();

        return view('user_dashboard.customer.pos', compact('pos_list'));
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

        $vendor = Vendor::find(Auth::guard('vendor')->user()->id);
        $categories = json_decode($vendor->business_category);
        if ($request->type == 'product') {
            $vendor_balance_amount = json_decode($vendor->business_category_product_balance);
            $commissions = json_decode($vendor->product_comission_percentage);
            $commissions_type = json_decode($vendor->product_type_comission);

            foreach ($categories as $key => $category) {
                if ($category == $request->business_category_id) {

                    if($commissions[$key]== 0 ){
                        return back()->with('error', 'POS is Not eliglible ');
                    }

                    if ($commissions_type[$key] == 'percent') {
                        if ($request->grand_total > $vendor_balance_amount[$key]) {
                            $business_category = BusinessCategory::find($category);
                            return back()->with('error', 'Please Recharge Category: ' . $business_category->name . ' to confirme order');
                        }
                    }
                    if ($commissions_type[$key] == 'amount') {
                        if ($commissions[$key] > $vendor_balance_amount[$key]) {
                            $business_category = BusinessCategory::find($category);
                            return back()->with('error', 'Please Recharge Category: ' . $business_category->name . ' to confirme order');
                        }
                    }


                }
            }

            $pos = new Pos;
            $pos->vendor_id = Auth::guard('vendor')->user()->id;
            $pos->user_id = User::where('referral_code', $request->referral_code)->first()->id;
            $pos->referral_code = $request->referral_code;
            $pos->business_category_id = $request->business_category_id;
            $pos->type = $request->type;
            $pos->grand_total = $request->grand_total;
            $pos->save();

            $category_amount = $request->grand_total;
            $business_category_balance = [];
            foreach ($categories as $key => $category) {
                if ($category == $request->business_category_id) {

                    if ($commissions_type[$key] == 'percent') {

                        $balance_amount = $vendor_balance_amount[$key] - ($request->grand_total);

                        $payment = new VendorPaymentHistroy;
                        $payment->vendor_id = $vendor->id;
                        $payment->payment_id = rand(1111, 9999);
                        $payment->payment_amount = $request->grand_total;
                        $payment->method = '';
                        $payment->transaction_type = 'debit';
                        $payment->description = 'Payment debited for pos order product';
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
                        $payment->description = 'Payment debited for pos order product';
                        $payment->status = 1;
                        $payment->save();
                    }
                } else {
                    $balance_amount = $vendor_balance_amount[$key];
                }
                array_push($business_category_balance, $balance_amount);
            }

            $vendor->business_category_product_balance = json_encode($business_category_balance);

            foreach ($categories as $key => $category) {
                if ($category == $request->business_category_id) {

                    $comission_catgeory_percentage = $commissions[$key];
                    $total_comission_amount = ($category_amount * $comission_catgeory_percentage) / 100;
                    $order_user_comission_gb = (($total_comission_amount * get_setting('gv_comission_percentage_product')) / 100) / 25;
                    $order_user = User::find($pos->user_id);
                    $order_user->pp = $order_user->pp + $order_user_comission_gb;
                    $order_user->save();


                    $genial_income = new GenialIncome;
                    $genial_income->user_id=$pos->user_id;
                    $genial_income->vendor_id=$pos->vendor_id;
                    $genial_income->order_id=$pos->id;
                    $genial_income->type='pos';
                    $genial_income->order_amount=$category_amount;
                    $genial_income->genial_amount=(($total_comission_amount *(100 - get_setting('gv_comission_percentage_product'))) / 100);
                    $genial_income->genial_percent=(100 - get_setting('gv_comission_percentage_product'));
                    $genial_income->save();

                    $order_user_pp_transaction = new UserPPHistroy;
                    $order_user_pp_transaction->user_id = $order_user->id;
                    $order_user_pp_transaction->pp = $order_user_comission_gb;
                    $order_user_pp_transaction->type = 'credited';
                    $order_user_pp_transaction->detail = 'PP Transfer from pos order.';
                    $order_user_pp_transaction->save();

                    $referral_code = $order_user->referral_by;
                    $current_user = User::find($pos->user_id);

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

        if ($request->type == 'service') {


            $vendor_balance_amount = json_decode($vendor->business_category_service_balance);
            $commissions = json_decode($vendor->service_comission_percentage);
            $commissions_type = json_decode($vendor->service_type_comission);
            $category_amount = $request->grand_total;

            foreach ($categories as $key => $category) {
                if ($category == $request->business_category_id) {

                    if($commissions[$key]== 0 ){
                        return back()->with('error', 'POS is Not eliglible ');
                    }

                    if ($commissions_type[$key] == 'percent') {
                        if ($category_amount > $vendor_balance_amount[$key]) {
                            $business_category = BusinessCategory::find($category);
                            return back()->with('error', 'Please Recharge Category: ' . $business_category->name . ' to confirme order');
                        }
                    }
                    if ($commissions_type[$key] == 'amount') {
                        if ($commissions[$key] > $vendor_balance_amount[$key]) {
                            $business_category = BusinessCategory::find($category);
                            return back()->with('error', 'Please Recharge Category: ' . $business_category->name . ' to confirme order');
                        }
                    }
                }
            }

            $pos = new Pos;
            $pos->vendor_id = Auth::guard('vendor')->user()->id;
            $pos->user_id = User::where('referral_code', $request->referral_code)->first()->id;
            $pos->referral_code = $request->referral_code;
            $pos->business_category_id = $request->business_category_id;
            $pos->grand_total = $request->grand_total;
            $pos->type = $request->type;
            $pos->save();


            $business_category_balance = [];

            foreach ($categories as $key => $category) {

                if ($category == $request->business_category_id) {
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

            foreach ($categories as $key => $category) {
                if ($category == $request->business_category_id) {

                    $comission_catgeory_percentage = $commissions[$key];
                    $total_comission_amount = ($category_amount * $comission_catgeory_percentage) / 100;
                    $order_user_comission_gb = (($total_comission_amount * get_setting('gv_comission_percentage_service')) / 100) / 25;
                    $order_user = User::find($pos->user_id);
                    $order_user->pp = $order_user->pp + $order_user_comission_gb;
                    $order_user->save();

                    $genial_income = new GenialIncome;
                    $genial_income->user_id=$pos->user_id;
                    $genial_income->vendor_id=$pos->vendor_id;
                    $genial_income->order_id=$pos->id;
                    $genial_income->type='pos';
                    $genial_income->order_amount=$category_amount;
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
                    $current_user = User::find($pos->user_id);

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

        $vendor->save();


        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pos  $pos
     * @return \Illuminate\Http\Response
     */
    public function show(Pos $pos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pos  $pos
     * @return \Illuminate\Http\Response
     */
    public function edit(Pos $pos)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pos  $pos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pos $pos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pos  $pos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pos $pos)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Reward;
use App\Models\Vendor;
use App\Models\UserKyc;
use App\Models\Comission;
use App\Models\UserReward;
use App\Models\UserVendor;
use App\Models\UserWallet;
use App\Models\OneDayOrder;
use App\Models\UserGbMonth;
use App\Models\AchiveReward;
use Illuminate\Http\Request;
use App\Models\BonanzaReward;
use App\Models\UserPPHistroy;
use App\Models\user_gv_histroy;
use App\Models\UserBonanzaReward;
use App\Models\PaymentTransaction;
use App\Models\ReferralTransaction;
use App\Models\UserWithdrwalRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        return view('backend.customer.index');
    }
    public function get_customer(Request $request)
    {

        $draw                 =         $request->get('draw'); // Internal use
        $start                 =         $request->get("start"); // where to start next records for pagination
        $rowPerPage         =         $request->get("length"); // How many recods needed per page for pagination

        $orderArray        =         $request->get('order');
        $columnNameArray     =         $request->get('columns'); // It will give us columns array

        $searchArray         =         $request->get('search');
        $columnIndex         =         $orderArray[0]['column'];  // This will let us know,
        // which column index should be sorted
        // 0 = id, 1 = name, 2 = email , 3 = created_at

        $columnName         =         $columnNameArray[$columnIndex]['data']; // Here we will get column name,
        // Base on the index we get

        $columnSortOrder     =         $orderArray[0]['dir']; // This will get us order direction(ASC/DESC)
        $searchValue         =         $searchArray['value']; // This is search value


        $users = User::where('id', '>', 0);
        $total = $users->count();

        $totalFilter = User::where('id', '>', 0);
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('name', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();


        $arrData = User::where('id', '>', 0);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('name', 'like', '%' . $searchValue . '%')->orwhere('phone', 'like', '%' . $searchValue . '%')->orwhere('email', 'like', '%' . $searchValue . '%');
        }
        if ($searchValue == 'Prime' || $searchValue == 'prime') {
            $arrData = $arrData->orwhere('prime', 'like', '%' . ($searchValue == 'prime' ? 1 : '') . '%');
        }

        $arrData = $arrData->get();

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        );

        return response()->json($response);
    }

    public function create(Request $request)
    {
        return view('backend.customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'phone' => 'required',
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->address = $request->address;
        if (!empty($request->referral_by)) {
            $user->referral_by = strtoupper($request->referral_by);
        }
        $user->referral_code = 'G' . rand(1111111111, 9999999999);

        if (!empty($request->profile_picture)) {
            $file = $request->file('profile_picture');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/customer/'), $image);
            $user->profile_picture = $image;
        }

        $user->save();

        return redirect()->route('customer_list')->with('success', 'Customer added successfully');
    }


    public function password_update(Request $request)
    {

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->back();
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('backend.customer.edit', compact('user'));
    }

    public function customer_profile($id)
    {
        $user = User::find($id);
        return view('backend.customer.profile', compact('user'));
    }

    public function customer_view(Request $request,$id)
    {
        $user = User::find($id);
        $orders = Order::where('user_id',$id)->with('order_detail')->latest();
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

        if($request->export){
            $orders=$orders->get()->pluck('id');
            return Excel::download(new OrderExport($orders), 'order-report.xlsx');
        }

        $orders=$orders->paginate(20);
        return view('backend.customer.view', compact('user','orders'));
    }

    public function customer_e_puja(Request $request,$id)
    {
        $user = User::find($id);
        $orders = OneDayOrder::where('user_id',$id)->latest();

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
        if($request->export){
            $orders=$orders->get()->pluck('id');
            return Excel::download(new OneDayOrderExport($orders), 'one-day-order-report.xlsx');
        }
        $orders=$orders->paginate(20);



        return view('backend.customer.e_puja_order', compact('user','orders'));
    }

    public function update(Request $request)
    {
        $user = User::find($request->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->address = $request->address;
        if (!empty($request->profile_picture)) {
            $file = $request->file('profile_picture');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/customer/'), $image);
            $user->profile_picture = $image;
        }
        $user->birthDate = $request->birthDate;
        $user->birthTime = $request->birthTime;
        $user->birthPlace = $request->birthPlace;
        $user->gender = $request->gender;
        $user->save();
        return redirect()->route('customer_list')->with('success', 'Customer updated successfully');
    }


    public function vendor_list(Request $request)
    {
        $user_vendors = UserVendor::where('user_id', Auth::user()->id)->get()->pluck('vendor_id');
        $vendors = Vendor::whereIn('id', $user_vendors->toArray())->orderBy('id','desc')->get();
        return view('user_dashboard.customer.vendor', compact('vendors'));
    }

    public function vendor_add(Request $request)
    {

        $request->validate([
            'email' => 'required|email|unique:vendors',
            'phone' => 'required|digits:10|unique:vendors',
        ]);

        $vendor = new Vendor;
        $vendor->vendor_code = 'G' . rand(11111111, 99999999);
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        if (!empty($request->password)) {
            $vendor->password = Hash::make($request->password);
        }
        $vendor->address = $request->address;
        $vendor->pincode = $request->pincode;
        $vendor->city = $request->city;
        $vendor->state = $request->state;
        $vendor->firm_name = $request->firm_name;
        $vendor->bank_name = $request->bank_name;
        $vendor->account_number = $request->account_number;
        $vendor->branch_name = $request->branch_name;
        $vendor->phone = $request->phone;
        $vendor->ifsc_code = $request->ifsc_code;
        $vendor->account_holder_name = $request->account_holder_name;
        $vendor->gstin = $request->gstin;

        if (!empty($request->logo)) {
            $file = $request->file('logo');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/vendor/'), $image);
            $vendor->logo = $image;
        }

        if (!empty($request->business_category)) {
            $vendor->business_category = json_encode($request->business_category);
        } else {
            $vendor->business_category = [];
        }
        if (!empty($request->product_comission_percentage)) {
            $vendor->product_comission_percentage = json_encode($request->product_comission_percentage);
        } else {
            $vendor->product_comission_percentage = [];
        }
        if (!empty($request->service_comission_percentage)) {
            $vendor->service_comission_percentage = json_encode($request->service_comission_percentage);
        } else {
            $vendor->service_comission_percentage = [];
        }
        if (!empty($request->product_type_comission)) {
            $vendor->product_type_comission = json_encode($request->product_type_comission);
        } else {
            $vendor->product_type_comission = [];
        }
        if (!empty($request->service_type_comission)) {
            $vendor->service_type_comission = json_encode($request->service_type_comission);
        } else {
            $vendor->service_type_comission = [];
        }
        if (!empty($request->business_category_product_balance)) {
            $vendor->business_category_product_balance = json_encode($request->business_category_product_balance);
        } else {
            $vendor->business_category_product_balance = [];
        }
        if (!empty($request->business_category_service_balance)) {
            $vendor->business_category_service_balance = json_encode($request->business_category_service_balance);
        } else {
            $vendor->business_category_service_balance = [];
        }

        $vendor->save();

        $user_vendor = new UserVendor;
        $user_vendor->user_id = Auth::user()->id;
        $user_vendor->vendor_id = $vendor->id;
        $user_vendor->save();

        return redirect()->route('customer.vendor');
    }

    public function vendor_edit($id)
    {
        $vendor = Vendor::find($id);
        return view('user_dashboard.customer.edit_vendor', compact('vendor'));
    }

    public function vendor_view($id)
    {
        $vendor = Vendor::find($id);
        return view('user_dashboard.customer.view_vendor', compact('vendor'));
    }

    public function vendor_update(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:vendors,email,' . $request->id,
            'phone' => 'required|unique:vendors,phone,' . $request->id,
        ]);
        $vendor = Vendor::find($request->id);
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        if ($request->password) {
            $vendor->password = Hash::make($request->password);
        }
        $vendor->address = $request->address;
        $vendor->pincode = $request->pincode;
        $vendor->city = $request->city;
        $vendor->state = $request->state;
        $vendor->firm_name = $request->firm_name;
        $vendor->bank_name = $request->bank_name;
        $vendor->branch_name = $request->branch_name;
        $vendor->account_number = $request->account_number;
        $vendor->phone = $request->phone;
        $vendor->ifsc_code = $request->ifsc_code;
        $vendor->account_holder_name = $request->account_holder_name;
        $vendor->gstin = $request->gstin;

        if (!empty($request->logo)) {
            $file = $request->file('logo');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/vendor/'), $image);
            $vendor->logo = $image;
        }

        $vendor->save();

        return redirect()->route('customer.vendor');
    }


    public function profile_update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->address = $request->address;
        if (!empty($request->profile_picture)) {
            $file = $request->file('profile_picture');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/customer/'), $image);
            $user->profile_picture = $image;
        }
        $user->birthDate = $request->birthDate;
        $user->birthTime = $request->birthTime;
        $user->birthPlace = $request->birthPlace;
        $user->gender = $request->gender;
        $user->save();
        return back();
    }

    public function bank_update(Request $request)
    {
        $user_bank = UserKyc::where('user_id', Auth::user()->id)->first();
        if (empty($user_bank)) {
            $user_bank = new UserKyc;
            $user_bank->user_id = Auth::user()->id;
        }
        $user_bank->account_holder_name = $request->holder_name;
        $user_bank->account_number = $request->account_number;
        $user_bank->ifsc_code = $request->ifsc_code;
        $user_bank->bank_name = $request->bank_name;
        $user_bank->branch_name = $request->branch_name;
        $user_bank->upi_id = $request->upi_id;
        $user_bank->nominee_name = $request->nominee_name;
        $user_bank->nominee_relation = $request->nominee_relation;
        $user_bank->save();
        return back();
    }
    public function kyc_update(Request $request)
    {

        $user_kyc = UserKyc::where('user_id', Auth::user()->id)->first();
        if (empty($user_kyc)) {
            $user_kyc = new UserKyc;
            $user_kyc->user_id = Auth::user()->id;
        }
        $user_kyc->aadhaar = $request->aadhaar;
        $user_kyc->pan = $request->pan;
        if (!empty($request->aadhaar_front_file)) {
            $file = $request->file('aadhaar_front_file');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/customer/'), $image);
            $user_kyc->aadhaar_front_file = $image;
        }
        if (!empty($request->aadhaar_back_file)) {
            $file = $request->file('aadhaar_back_file');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/customer/'), $image);
            $user_kyc->aadhaar_back_file = $image;
        }
        if (!empty($request->pan_file)) {
            $file = $request->file('pan_file');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/customer/'), $image);
            $user_kyc->pan_file = $image;
        }
        if (!empty($request->bank_passbook_file)) {
            $file = $request->file('bank_passbook_file');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/customer/'), $image);
            $user_kyc->bank_passbook_file = $image;
        }
        if (!empty($request->cancelled_cheque_file)) {
            $file = $request->file('cancelled_cheque_file');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/customer/'), $image);
            $user_kyc->cancelled_cheque_file = $image;
        }

        $user_kyc->save();
        return back();
    }

    public function updateStatus(Request $request)
    {
        // $user = User::findOrFail($request->id);
        // $user->status = $request->status;
        // if ($user->save()) {
        //     return 1;
        // }
        // return 0;
    }

    public function wallet()
    {
        $wallet_transactions = UserWallet::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        return view('user_dashboard.customer.wallet', compact('wallet_transactions'));
    }

    public function gv_histroy($user_id)
    {
        // $user_gv_histroy = user_gv_histroy::where('user_id', Auth::user()->id)->get();
        $user = User::find($user_id);
        $user_list = User::where('referral_by', $user->referral_code)->get();

        $firstDayLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastDayLastMonth = Carbon::now()->subMonth()->endOfMonth();

        $firstDayLastMonthg = Carbon::now()->startOfMonth();
        $lastDayLastMonthg = Carbon::now()->endOfMonth();

        $user_total_pp_last_month = UserPPHistroy::where('user_id', Auth::user()->id)->whereBetween('created_at', [$firstDayLastMonth, $lastDayLastMonth])->sum('pp');

        $total_gb_last_month = UserGbMonth::where('user_id',Auth::user()->id)->whereBetween('created_at', [$firstDayLastMonthg, $lastDayLastMonthg])->sum('gv');

        return view('user_dashboard.customer.user_gv_histroy', compact('user_list','user_total_pp_last_month','total_gb_last_month','firstDayLastMonth','lastDayLastMonth','firstDayLastMonthg','lastDayLastMonthg'));
    }

    public function pp_histroy()
    {
        $user_pp_histroy = UserPPHistroy::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        return view('user_dashboard.customer.user_pp_histroy', compact('user_pp_histroy'));
    }

    public function income_histroy_repurchase()
    {
        $user = User::find(Auth::user()->id);
        $user_list = User::where('referral_by', $user->referral_code)->get();

        $firstDayLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastDayLastMonth = Carbon::now()->subMonth()->endOfMonth();

        $user_pp_histroy = UserPPHistroy::where('user_id', Auth::user()->id)->whereBetween('created_at', [$firstDayLastMonth, $lastDayLastMonth])->sum('pp');

        $firstDayLastMonthg = Carbon::now()->startOfMonth();
        $lastDayLastMonthg = Carbon::now()->endOfMonth();

        return view('user_dashboard.customer.income_histroy_repurcahse', compact('user_list', 'user_pp_histroy','firstDayLastMonthg','lastDayLastMonthg'));
    }


    public function direct_team()
    {
        $directs = User::where('referral_by', Auth::user()->referral_code)->get();
        return view('user_dashboard.customer.direct', compact('directs'));
    }
    public function level_team()
    {
        $levels = commissions();
        return view('user_dashboard.customer.level', compact('levels'));
    }
    public function level_team_member($level)
    {
        $level_team = Comission::where('user_id', Auth::user()->id)->where('level', $level)->get();
        return view('user_dashboard.customer.level_team', compact('level_team'));
    }
    public function bonanza_reward()
    {
        $user = Auth::user();
        $bonanza_reward = BonanzaReward::all();
        $user_reward = UserBonanzaReward::where('user_id', $user->id)->latest()->first();
        $selected_reward = '';
        if (!empty($user_reward->reward_id)) {
            $selected_reward = $user_reward->reward_id;
        }
        $direct = User::where('referral_by', Auth::user()->referral_code)->where('status', 1)->get()->count();

        return view('user_dashboard.customer.bonanza_reward', compact('bonanza_reward', 'selected_reward', 'direct'));
    }

    public function getTotalTeamCount($userId, $user_ids)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $teamCount = $this->calculateTotalTeamCount($user, $user_ids);

        return $teamCount;
    }

    protected function calculateTotalTeamCount($user, $user_ids)
    {
        $teamCount = 0;

        foreach (User::where('referral_by', $user->referral_code)->whereNotIn('id', $user_ids)->where('status', 1)->get() as $child) {
            $teamCount++; // Count the direct children

            $teamCount += $this->calculateTotalTeamCount($child, $user_ids); // Recursively count their teams
        }

        return $teamCount;
    }


    public function reward()
    {
        $user = Auth::user();
        $rewards = Reward::all();
        $user_reward = UserReward::where('user_id', $user->id)->latest()->first();
        $selected_reward = '';
        if (!empty($user_reward->reward_id)) {
            $selected_reward = $user_reward->reward_id;
        }
        $achive_reward=AchiveReward::where('user_id', $user->id)->get();
        return view('user_dashboard.customer.reward', compact('rewards', 'selected_reward','achive_reward'));
    }

    public function customer_fess_phonepe(Request $request)
    {
        $request->merge(['amount' => 500, 'type' => 'customer_registration_fees']);
        $phonepe = new PhonepeController;
        return redirect($phonepe->payWithPhonePe($request));
    }

    public function pay(Request $request)
    {

        $comissions = Comission::where('referral_user_id', Auth::user()->id)->where('status', 0)->get();

        $user_data = User::find(Auth::user()->id);
        $user_data->active_date = date('Y-m-d H:i:s');
        $user_data->status = 1;
        $user_data->save();

        $response_data=json_decode($request->payment_details);
        $payment = PaymentTransaction::where('mt_id',$response_data->data->merchantTransactionId)->first();
        $payment->payment_details = $request->payment_details;
        $payment->status = 'success';
        $payment->save();


        foreach ($comissions as $comission) {

            $user = User::find($comission->user_id);
            $user->balance = round($user->balance + $comission->commission, 2);
            $user->save();
            $wallet_transaction = new UserWallet;
            $wallet_transaction->user_id = $comission->user_id;
            $wallet_transaction->amount = round($comission->commission, 2);
            $wallet_transaction->transaction_type = 'Credited';
            $wallet_transaction->transaction_detail = 'Referral Amount Received of Rs.' . round($comission->commission, 2) . ' from referral user ' . Auth::user()->name . ' on level ' . $comission->level;
            $wallet_transaction->balance = round($user->balance, 2);
            $wallet_transaction->approval = 'Confirmed';
            $wallet_transaction->save();

            $comission->status = 1;
            $comission->save();
        }


        //     Mail::send('frontend.email.welcome_mail', [] ,function($message) use($request){
        //         $message->to($request->email);
        //         $message->subject('Welcome Email');
        //    });

        return redirect()->route('customer.dashboard');
    }

    public function admin_pay($id, $m_id)
    {
       // return [$id,$m_id];
        $comissions = Comission::where('referral_user_id', $id)->where('status', 0)->get();

        $user_data = User::find($id);

        if ($user_data->status == 0) {
            $user_data->active_date = date('Y-m-d H:i:s');
            $user_data->status = 1;
            $user_data->save();

            $phonepe = new PhonepeController;
            $payment_details = $phonepe->status_check_api_manual($m_id);
            $response_data=json_decode($payment_details);

            $payment =PaymentTransaction::where('mt_id',$response_data->data->merchantTransactionId)->first();;
            $payment->user_id = $user_data->id;
            $payment->transaction_type = 'customer_registration_fess';
            $payment->user_type = 'user';
            $payment->amount = 500;
            $payment->payment_method = 'phonepe';
            $payment->payment_details = $payment_details;
            $payment->save();

            foreach ($comissions as $comission) {

                $user = User::find($comission->user_id);
                $user->balance = round($user->balance + $comission->commission, 2);
                $user->save();
                $wallet_transaction = new UserWallet;
                $wallet_transaction->user_id = $comission->user_id;
                $wallet_transaction->amount = round($comission->commission, 2);
                $wallet_transaction->transaction_type = 'Credited';
                $wallet_transaction->transaction_detail = 'Referral Amount Received of Rs.' . round($comission->commission, 2) . ' from referral user ' . $user_data->name . ' on level ' . $comission->level;
                $wallet_transaction->balance = round($user->balance, 2);
                $wallet_transaction->approval = 'Confirmed';
                $wallet_transaction->save();

                $comission->status = 1;
                $comission->save();
            }
        }

        return 'done';
    }


    public function pay_all()
    {

        $users = User::where('status', 0)->get();
        foreach ($users as $user) {

            $comissions = Comission::where('referral_user_id', $user->id)->where('status', 0)->get();

            $user_data = User::find($user->id);
            $user_data->active_date = date('Y-m-d H:i:s');
            $user_data->status = 1;
            $user_data->save();

            foreach ($comissions as $comission) {

                $user = User::find($comission->user_id);
                $user->balance = round($user->balance + $comission->commission, 2);
                $user->save();
                $wallet_transaction = new UserWallet;
                $wallet_transaction->user_id = $comission->user_id;
                $wallet_transaction->amount = round($comission->commission);
                $wallet_transaction->transaction_type = 'Credited';
                $wallet_transaction->transaction_detail = 'Referral Amount Received of Rs.' . round($comission->commission, 2) . ' from referral user ' . User::find($comission->referral_user_id)->name . ' on level ' . $comission->level;
                $wallet_transaction->balance = round($user->balance, 2);
                $wallet_transaction->approval = 'Confirmed';
                $wallet_transaction->save();

                $comission->status = 1;
                $comission->save();
            }
        }
    }

    public function direct_income()
    {
        $directs = Comission::where('user_id', Auth::user()->id)->where('level', 1)->orderBy('id','desc')->get();
        return view('user_dashboard.customer.direct_income', compact('directs'));
    }
    public function level_income()
    {
        $levels = Comission::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        return view('user_dashboard.customer.level_income', compact('levels'));
    }
    public function vendor_income()
    {
        $datas = UserVendor::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        return view('user_dashboard.customer.vendor_income', compact('datas'));
    }

    public function withdrawl_requests()
    {
        $withdraw_requests = UserWithdrwalRequest::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        return view('user_dashboard.customer.withdrawl_request', compact('withdraw_requests'));
    }

    public function withdrawl_request_store(Request $request)
    {
        $tds_amount = ($request->amount * 5) / 100;
        $gt_amount = ($request->amount * 1) / 100;
        $paid_amount = $request->amount - ($tds_amount + $gt_amount);

        if (Auth::user()->balance > $request->amount) {
            $user_data = User::find(Auth::user()->id);
            if (!empty($user_data->user_kyc->upi_id)) {
                $payment_data = razorpay_payout_upi($user_data, $paid_amount);
            }
            if (!empty($user_data->user_kyc->account_number) && empty($user_data->user_kyc->upi_id)) {
                $payment_data = razorpay_payout_bank($user_data, $paid_amount);
            }

            if (!empty(json_decode($payment_data)->id)) {


                $withdraw_request = new UserWithdrwalRequest;
                $withdraw_request->user_id = Auth::user()->id;
                $withdraw_request->amount = $request->amount;
                // $withdraw_request->gst_amount = ($request->amount*18)/100;
                $withdraw_request->tds_amount = $tds_amount;
                $withdraw_request->gt_amount = $gt_amount;
                $withdraw_request->paid_amount = $paid_amount;
                $withdraw_request->message = $request->message;
                $withdraw_request->status = '0';
                $withdraw_request->viewed = '0';
                $withdraw_request->save();



                $user_data->balance = round($user_data->balance - $withdraw_request->amount, 2);
                $user_data->save();

                $wallet = new UserWallet;
                $wallet->user_id = $withdraw_request->user_id;
                $wallet->amount = round($withdraw_request->amount, 2);
                $wallet->transaction_type = 'Debited';
                $wallet->transaction_detail = 'Transfer to bank account amount ' . round($paid_amount, 2) . ' of ' . round($withdraw_request->amount, 2);
                $wallet->balance = round($user_data->balance, 2);
                $wallet->approval = 'Confirmed';
                $wallet->save();



                $withdraw_request->payment_details = $payment_data;
                $withdraw_request->payment_id = json_decode($payment_data)->id;
                $withdraw_request->save();
            } else {
                return back()->with('error', json_decode($payment_data)->error->description);
            }

            return back();
        } else {
            return back()->with('error', 'Balance is less!');
        }
    }

    public function tree_view(Request $request)
    {
        if (!empty($request->referral_code)) {
            $referral_code = $request->referral_code;
        } else {
            $referral_code = Auth::user()->referral_code;
        }
        return view('user_dashboard.customer.tree_view', compact('referral_code'));
    }

    private function getChildren($referralCode)
    {
        return User::where('referral_by', $referralCode)->get();
    }
    public function referral_details(Request $request)
    {
        $data = User::where('referral_code', $request->referral_code)->first();
        return 'Name: ' . $data->name . '<br>User Id: ' . $data->referral_code . ' <br>Sponsor Id: ' . $data->referral_by . '<br>PP:' . $data->pp . '<br>GP: ' . $data->gb + $data->pp;
    }


    // Function to build the MLM tree recursively
    // private function buildTree($referralCode = null)
    // {
    //     $node = User::where('referral_code', $referralCode)->first();
    //     if (!$node) {
    //         return null;
    //     }
    //     $children = $this->getChildren($referralCode);
    //     if (!$children->count()) {
    //         return $node;
    //     }
    //     $tree = ['name' => $node->name, 'children' => []];
    //     foreach ($children as $child) {
    //         $tree['children'][] = $this->buildTree($child->referral_code);
    //     }
    //     return $tree;
    // }
    // private function buildTree($referralCode = null)
    // {
    //     $node = User::where('referral_code', $referralCode)->first();
    //     if (!$node) {
    //         return null;
    //     }
    //     $children = $this->getChildren($referralCode);
    //     if (!$children->count()) {
    //         return [
    //             'id' => $node->id,
    //             'parent' => $node->referral_by ?: null, // Use referral_code as the parent identifier
    //             'name' => $node->name,
    //         ];
    //     }
    //     $tree = [
    //         'id' => $node->id,
    //         'parent' =>$node->referral_by ?: null, // Use referral_code as the parent identifier
    //         'name' => $node->name,
    //         'children' => [],
    //     ];
    //     foreach ($children as $child) {
    //         $tree['children'][] = $this->buildTree($child->referral_code);
    //     }
    //     return $tree;
    // }
    private function buildTree($referralCode = null, $level = 1)
    {
        if ($level > 4) {
            return null; // Limit the depth to four levels
        }

        $node = User::where('referral_code', $referralCode)->first();
        if (!$node) {
            return null;
        }
        $children = $this->getChildren($referralCode);
        if (!$children->count()) {
            return [
                'v' => $node->referral_code,
                'f' => '<div class=mytooltip><img src=' . ($node->status == 1 ? asset('green.png') : asset('red.png')) . ' style=height:50px;width:50px;><a
                href=' . route('tree_view') . '?referral_code=' . $node->referral_code . '><span style=color:black>' . $node->referral_code . '</span><br><span
                     style=color:black>' . $node->name . '</span></a><span class=mytext id=my' . $node->referral_code . '></span></div>',
                'p' => $node->referral_by ?: null,
            ];
        }
        $tree = [
            'v' => $node->referral_code,
            'f' => '<div class=mytooltip><img src=' . ($node->status == 1 ? asset('green.png') : asset('red.png')) . ' style=height:50px;width:50px;><a
            href=' . route('tree_view') . '?referral_code=' . $node->referral_code . '><span style=color:black>' . $node->referral_code . '</span><br><span
                 style=color:black>' . $node->name . '</span></a><span class=mytext id=my' . $node->referral_code . '></span></div>',
            'p' => $node->referral_by ?: null,
            'c' => [],
        ];
        foreach ($children as $child) {
            $tree['c'][] = $this->buildTree($child->referral_code, $level + 1);
        }
        return $tree;
    }

    // Function to get the MLM tree starting from the top-level member (John)
    public function getMLMTree(Request $request)
    {
        $topLevelReferralCode = $request->referral_code; // Change this to the referral code of your top-level member (e.g., 'John')
        $mlmTree = $this->buildTree($topLevelReferralCode);
        return response()->json($mlmTree);
    }

    public function download_invoice()
    {
        return view('frontend.invoice');
    }

    public function customer_order(Request $request,$id)
    {

        $orders = Order::where('user_id',$id)->with('order_detail')->latest();
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

        if($request->export){
            $orders=$orders->get()->pluck('id');
            return Excel::download(new OrderExport($orders), 'order-report.xlsx');
        }

        $orders=$orders->paginate(20);
        return view('backend.customer.order', compact('orders','id'));
    }

    public function customer_oneday_order(Request $request,$id)
    {

        $orders = OneDayOrder::where('user_id',$id)->latest();
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

        $orders=$orders->paginate(20);
        return view('backend.customer.one_day_order', compact('orders','id'));
    }

}

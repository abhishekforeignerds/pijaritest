<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\UserVendor;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\BusinessCategory;
use App\Models\PaymentTransaction;
use App\Models\VendorPaymentHistroy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class VendorController extends Controller
{

    public function index(Request $request)
    {
        $vendors = Vendor::all();
        return view('backend.vendor.index', compact('vendors'));
    }
    public function get_vendor(Request $request)
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


        $users = Vendor::where('id', '>', 0);
        $total = $users->count();

        $totalFilter = Vendor::where('id', '>', 0);
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('name', 'like', '%' . $searchValue . '%');
        }
        $totalFilter = $totalFilter->count();


        $arrData = Vendor::where('id', '>', 0);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('name', 'like', '%' . $searchValue . '%')->orwhere('phone', 'like', '%' . $searchValue . '%')->orwhere('email', 'like', '%' . $searchValue . '%')->orwhere('vendor_code', 'like', '%' . $searchValue . '%');
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
        $business_categories = BusinessCategory::all();
        return view('backend.vendor.create', compact('business_categories'));
    }
    public function vendor_view($id)
    {
        $vendor = Vendor::find($id);
        $business_categories = BusinessCategory::all();
        return view('backend.vendor.view', compact('vendor', 'business_categories'));
    }
    public function edit($id)
    {
        $vendor = Vendor::find($id);
        $business_categories = BusinessCategory::all();
        return view('backend.vendor.edit', compact('vendor', 'business_categories'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'email' => 'required|unique:vendors',
            'phone' => 'required|unique:vendors',
        ]);

        $vendor = new Vendor;
        $vendor->vendor_code = 'G'.rand(11111111,99999999);
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        if (!empty($request->password)) {
            $vendor->password = Hash::make($request->password);
        }
        $vendor->pincode = $request->pincode;
        $vendor->city = $request->city;
        $vendor->state = $request->state;
        $vendor->address = $request->address;
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

        return redirect()->route('vendor_list');
    }
    public function update(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'email' => 'required|unique:vendors,email,' . $request->id,
            'phone' => 'required|unique:vendors,phone,' . $request->id,
        ]);

        $vendor = Vendor::find($request->id);
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        if (!empty($request->password)) {
            $vendor->password = Hash::make($request->password);
        }
        $vendor->pincode = $request->pincode;
        $vendor->city = $request->city;
        $vendor->state = $request->state;
        $vendor->address = $request->address;
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

        return redirect()->route('vendor_list');
    }
    public function vendorLogin()
    {
        if (Auth::guard('vendor')->check()) {
            return redirect()->route('vendor.dashboard');
        }
        return view('vendor_dashboard.auth.vendor_login');
    }
    public function vendorRegister()
    {
        return view('vendor_dashboard.auth.vendor_register');
    }
    public function vendorForgotPassword()
    {
        return view('vendor_dashboard.auth.vendor_forgot_password');
    }
    public function vendorResetPassword()
    {
        return view('vendor_dashboard.auth.vendor_reset_password');
    }
    public function attemptLogin(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'vendor_code' => 'required|exists:vendors',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            if (Auth::guard('vendor')->attempt(['vendor_code' => $request->vendor_code, 'password' => $request->password], !empty($request->remember) ? true : false)) {
                return redirect()->route('vendor.dashboard')->with('success', 'You Have Successfully Login!');
            } else {
                $validator->getMessageBag()->add('password', 'Wrong Password');
                return back()->withErrors($validator)->withInput();
            }
        }
    }
    public function attemptRegister(Request $request)
    {

        $request->validate([
            'email' => 'required|email|unique:vendors',
            'phone' => 'required|digits:10|unique:vendors',
            'firm_name' => 'required',
            'address' => 'required',
        ]);

        $vendor = new Vendor;
        $vendor->vendor_code = 'G'.rand(11111111,99999999);
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->password = Hash::make($request->password);
        $vendor->pincode = $request->pincode;
        $vendor->city = $request->city;
        $vendor->state = $request->state;
        $vendor->address = $request->address;
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

        if (Auth::guard('vendor')->attempt(['email' => $request->email, 'password' => $request->password], !empty($request->remember) ? true : false)) {
            return redirect()->route('vendor.dashboard')->with('success', 'You Have Successfully Login!');
        }
        return redirect()->back()->with('error', 'Invalid Credentials! Please try again');
    }

    public function vendorLogout(Request $request)
    {
        Auth::guard('vendor')->logout();
        return redirect()->route('vendor_login')->with('success', 'You Have Successfully Logout!');
    }


    public function checkemail(Request $request)
    {
        $user = Vendor::all()->where('email', $request->email)->first();
        if ($user) {
            return Response::json($request->email . ' is already taken');
        }
    }

    public function updateStatus(Request $request)
    {
        $vendor = Vendor::findOrFail($request->id);
        $vendor->ban = $request->ban;
        if ($vendor->save()) {
            return 1;
        }
        return 0;
    }

    public function vendor_comission_percentage(Request $request)
    {
        $business_category = $request->business_category;
        $vendor_id = $request->vendor_id;
        if (!empty($business_category)) {
            $business_categories = BusinessCategory::whereIn('id', $business_category)->get();
            $vendor_data = Vendor::find($vendor_id);
            return view('backend.vendor.comission_table', compact('business_categories', 'vendor_data'));
        }
    }

    public function vendor_comission_percentage_add(Request $request)
    {
        $business_category = $request->business_category;
        if (!empty($business_category)) {
            $business_categories = BusinessCategory::whereIn('id', $business_category)->get();
            $vendor_data = [];
            return view('backend.vendor.comission_add_table', compact('business_categories', 'vendor_data'));
        }
    }


    public function get_category_by_vendor(Request $request)
    {
        $vendor = Vendor::find($request->vendor_id);
        $vendor_categories = json_decode($vendor->business_category);
        $categories = Category::whereIn('business_category_id', $vendor_categories)->get();
        return $categories;
    }

    public function get_service_category_by_vendor(Request $request)
    {
        $vendor = Vendor::find($request->vendor_id);
        $vendor_categories = json_decode($vendor->business_category);
        $categories = ServiceCategory::whereIn('business_category_id', $vendor_categories)->get();
        return $categories;
    }

    public function topup_category(Request $request)
    {
        $vendor = Vendor::find(Auth::guard('vendor')->user()->id);
        $vendor_categories = json_decode($vendor->business_category);
        $commissions_product = json_decode($vendor->product_comission_percentage);
        $commissions_service = json_decode($vendor->service_comission_percentage);
        $vendor_categories_product_balance = json_decode($vendor->business_category_product_balance);
        $vendor_categories_service_balance = json_decode($vendor->business_category_service_balance);
        return view('vendor_dashboard.topup_categories', compact('vendor', 'vendor_categories', 'vendor_categories_product_balance', 'vendor_categories_service_balance','commissions_product','commissions_service'));
    }

    public function vendor_payment_histroy(Request $request)
    {
        $vendor_payment_histories = VendorPaymentHistroy::where('vendor_id', Auth::guard('vendor')->user()->id)->orderBy('id','desc')->get();
        return view('vendor_dashboard.payment_histroy', compact('vendor_payment_histories'));
    }

    public function profile_update(Request $request)
    {
        $vendor = Vendor::find(Auth::guard('vendor')->user()->id);
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        if (!empty($request->password)) {
            $vendor->password = Hash::make($request->password);
        }
        $vendor->pincode = $request->pincode;
        $vendor->city = $request->city;
        $vendor->state = $request->state;
        $vendor->address = $request->address;
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
        if (!empty($request->business_category)) {
            $vendor->business_category = json_encode($request->business_category);
        }
        if (!empty($request->comission_percentage)) {
            $vendor->comission_percentage = json_encode($request->comission_percentage);
        }
        if (!empty($request->business_category_balance)) {
            $vendor->business_category_balance = json_encode($request->business_category_balance);
        }
        $vendor->save();

        return redirect()->back();
    }

    // public function vendor_registration_fess(Request $request)
    // {

    //     $vendor = Vendor::find(Auth::guard('vendor')->user()->id);
    //     $registraion_fee = $request->registration_fee;
    //     $topup_category_fee = $request->topup_category;
    //     $categories = json_decode($vendor->business_category);
    //     $commissions_product = json_decode($vendor->product_comission_percentage);
    //     $product_type_comission = json_decode($vendor->product_type_comission);
    //     $commissions_service = json_decode($vendor->service_comission_percentage);
    //     $service_type_comission = json_decode($vendor->service_type_comission);
    //     $comission_count = 0;
    //     foreach ($commissions_product as $key => $comission_p) {
    //         if ($comission_p > 0) {
    //             $comission_count = $comission_count + 1;
    //         }
    //     }

    //     foreach ($commissions_service as $key => $comission_s) {
    //         if ($comission_s > 0) {
    //             $comission_count = $comission_count + 1;
    //         }
    //     }

    //     $amount = $topup_category_fee / $comission_count;


    //     $business_category_product_balance = [];
    //     $business_category_service_balance = [];
    //     if (count($commissions_product) > 0) {
    //         foreach ($commissions_product as $key => $comission) {
    //             if ($comission > 0) {
    //                 if ($product_type_comission[$key] == 'percent') {
    //                     $balance_amount = ($amount * 100) / $comission;
    //                 }
    //                 if ($product_type_comission[$key] == 'amount') {
    //                     $balance_amount = $amount;
    //                 }
    //             } else {
    //                 $balance_amount = 0;
    //             }
    //             array_push($business_category_product_balance, round($balance_amount, 2));
    //         }
    //         $vendor->business_category_product_balance = json_encode($business_category_product_balance);
    //     }
    //     if (count($commissions_service) > 0) {
    //         foreach ($commissions_service as $key => $comission) {
    //             if ($comission > 0) {
    //                 if ($service_type_comission[$key] == 'percent') {
    //                     $balance_amount = ($amount * 100) / $comission;
    //                 }
    //                 if ($service_type_comission[$key] == 'amount') {
    //                     $balance_amount = $amount;
    //                 }
    //             } else {
    //                 $balance_amount = 0;
    //             }
    //             array_push($business_category_service_balance, round($balance_amount, 2));
    //         }
    //         $vendor->business_category_service_balance = json_encode($business_category_service_balance);
    //     }
    //     $vendor->status = 1;
    //     $vendor->save();

    //     $payment = new VendorPaymentHistroy;
    //     $payment->vendor_id = $vendor->id;
    //     $payment->payment_id = rand(1111, 9999);
    //     $payment->payment_amount = $registraion_fee;
    //     $payment->method = '';
    //     $payment->description = 'Payment for registration fees';
    //     $payment->status = 1;
    //     $payment->save();

    //     foreach ($business_category_product_balance as $key => $balance) {
    //         if($balance > 0){
    //             $payment = new VendorPaymentHistroy;
    //             $payment->vendor_id = $vendor->id;
    //             $payment->payment_id = rand(1111, 9999);
    //             $payment->payment_amount = $amount;
    //             $payment->method = '';
    //             $payment->description = 'Payment for category product topup';
    //             $payment->status = 1;
    //             $payment->save();
    //         }
    //     }
    //     foreach ($business_category_service_balance as $key => $balance) {
    //         if($balance > 0){
    //             $payment = new VendorPaymentHistroy;
    //             $payment->vendor_id = $vendor->id;
    //             $payment->payment_id = rand(1111, 9999);
    //             $payment->payment_amount = $amount;
    //             $payment->method = '';
    //             $payment->description = 'Payment for category service topup';
    //             $payment->status = 1;
    //             $payment->save();
    //         }
    //     }
    //     $user_vendor_data = UserVendor::where('vendor_id', $vendor->id)->first();
    //     if (!empty($user_vendor_data->user_id)) {
    //         $user = User::find($user_vendor_data->user_id);
    //         $user->balance = $user->balance + 200;
    //         $user->save();
    //         $wallet_transaction = new UserWallet;
    //         $wallet_transaction->user_id = $user->id;
    //         $wallet_transaction->amount = 200;
    //         $wallet_transaction->transaction_type = 'Credited';
    //         $wallet_transaction->transaction_detail = 'Amount Received of Rs.200 for Vendor Regiration from ' . $vendor->name;
    //         $wallet_transaction->balance = $user->balance;
    //         $wallet_transaction->approval = 'Confirmed';
    //         $wallet_transaction->save();
    //     }

    //     return back();
    // }

    // public function vendor_categories_product_fess(Request $request)
    // {
    //     $vendor = Vendor::find(Auth::guard('vendor')->user()->id);
    //     $category_id = $request->category_id;
    //     $categories = json_decode($vendor->business_category);
    //     $commissions = json_decode($vendor->product_comission_percentage);
    //     $comission_type = json_decode($vendor->product_type_comission);
    //     $vendor_balance_amount = json_decode($vendor->business_category_product_balance);
    //     $amount = $request->amount;
    //     $business_category_balance = [];
    //     foreach ($categories as $key => $category) {
    //         if ($category == $category_id) {
    //             if ($commissions[$key] > 0) {
    //                 if ($comission_type[$key] == 'percent') {
    //                     $balance_amount = $vendor_balance_amount[$key] + (($amount * 100) / $commissions[$key]);
    //                 }
    //                 if ($comission_type[$key] == 'amount') {
    //                     $balance_amount = $vendor_balance_amount[$key] + $amount;
    //                 }
    //             } else {
    //                 return back()->with('error', 'Comission zero can not be recharged!');
    //             }
    //         } else {
    //             $balance_amount = $vendor_balance_amount[$key];
    //         }
    //         array_push($business_category_balance, round($balance_amount, 2));
    //     }
    //     $vendor->business_category_product_balance = json_encode($business_category_balance);
    //     $vendor->save();


    //     $payment = new VendorPaymentHistroy;
    //     $payment->vendor_id = $vendor->id;
    //     $payment->payment_id = rand(1111, 9999);
    //     $payment->payment_amount = $amount;
    //     $payment->method = '';
    //     $payment->description = 'Payment for category product topup';
    //     $payment->status = 1;
    //     $payment->save();


    //     return back();
    // }

    // public function vendor_categories_service_fess(Request $request)
    // {

    //     $vendor = Vendor::find(Auth::guard('vendor')->user()->id);
    //     $category_id = $request->category_id;
    //     $categories = json_decode($vendor->business_category);
    //     $commissions = json_decode($vendor->service_comission_percentage);
    //     $comission_type = json_decode($vendor->service_type_comission);
    //     $vendor_balance_amount = json_decode($vendor->business_category_service_balance);
    //     $amount = $request->amount;
    //     $business_category_balance = [];
    //     foreach ($categories as $key => $category) {
    //         if ($category == $category_id) {
    //             if ($commissions[$key] > 0) {
    //                 if ($comission_type[$key] == 'percent') {
    //                     $balance_amount = $vendor_balance_amount[$key] + (($amount * 100) / $commissions[$key]);
    //                 }
    //                 if ($comission_type[$key] == 'amount') {
    //                     $balance_amount = $vendor_balance_amount[$key] + $amount;
    //                 }
    //             } else {
    //                 return back()->with('error', 'Comission zero can not be recharged!');
    //             }
    //         } else {
    //             $balance_amount = $vendor_balance_amount[$key];
    //         }

    //         array_push($business_category_balance, round($balance_amount, 2));
    //     }
    //     $vendor->business_category_service_balance = json_encode($business_category_balance);
    //     $vendor->save();


    //     $payment = new VendorPaymentHistroy;
    //     $payment->vendor_id = $vendor->id;
    //     $payment->payment_id = rand(1111, 9999);
    //     $payment->payment_amount = $amount;
    //     $payment->method = '';
    //     $payment->description = 'Payment for category service topup';
    //     $payment->status = 1;
    //     $payment->save();


    //     return back();
    // }


    public function vendor_registration_fess_phonepe(Request $request){
        if($request->registration_fee < 500){
            $request->merge(['registration_fee'=> 500]);
        }
        if($request->topup_category < 500){
            $request->merge(['topup_category'=> 500]);
        }
        $amount=$request->registration_fee+$request->topup_category;
        $request->merge(['amount'=> $amount]);
        $phonepe = new PhonepeController;
        return redirect($phonepe->payWithPhonePe($request));
}

    public function vendor_registration_fess(Request $request)
    {
        //dd($request->all());
        $vendor = Vendor::find(Auth::guard('vendor')->user()->id);
        $registraion_fee = $request->registration_fee;
        $topup_category_fee = $request->topup_category;
        $categories = json_decode($vendor->business_category);
        $commissions_product = json_decode($vendor->product_comission_percentage);
        $product_type_comission = json_decode($vendor->product_type_comission);
        $commissions_service = json_decode($vendor->service_comission_percentage);
        $service_type_comission = json_decode($vendor->service_type_comission);
        $comission_count = 0;
        foreach ($commissions_product as $key => $comission_p) {
            if ($comission_p > 0) {
                $comission_count = $comission_count + 1;
            }
        }

        foreach ($commissions_service as $key => $comission_s) {
            if ($comission_s > 0) {
                $comission_count = $comission_count + 1;
            }
        }

        $amount = $topup_category_fee / $comission_count;


        $business_category_product_balance = [];
        $business_category_service_balance = [];
        if (count($commissions_product) > 0) {
            foreach ($commissions_product as $key => $comission) {
                if ($comission > 0) {
                    if ($product_type_comission[$key] == 'percent') {
                        $balance_amount = ($amount * 100) / $comission;
                    }
                    if ($product_type_comission[$key] == 'amount') {
                        $balance_amount = $amount;
                    }
                } else {
                    $balance_amount = 0;
                }
                array_push($business_category_product_balance, round($balance_amount, 2));
            }
            $vendor->business_category_product_balance = json_encode($business_category_product_balance);
        }
        if (count($commissions_service) > 0) {
            foreach ($commissions_service as $key => $comission) {
                if ($comission > 0) {
                    if ($service_type_comission[$key] == 'percent') {
                        $balance_amount = ($amount * 100) / $comission;
                    }
                    if ($service_type_comission[$key] == 'amount') {
                        $balance_amount = $amount;
                    }
                } else {
                    $balance_amount = 0;
                }
                array_push($business_category_service_balance, round($balance_amount, 2));
            }
            $vendor->business_category_service_balance = json_encode($business_category_service_balance);
        }
        $vendor->status = 1;
        $vendor->save();

        $payment = new VendorPaymentHistroy;
        $payment->vendor_id = $vendor->id;
        $payment->payment_id = rand(1111, 9999);
        $payment->payment_amount = $registraion_fee;
        $payment->method = $request->payment_details;
        $payment->transaction_type = 'credit';
        $payment->description = 'Payment for registration fees';
        $payment->status = 1;
        $payment->save();

        foreach ($business_category_product_balance as $key => $balance) {
            if($balance > 0){
                $payment = new VendorPaymentHistroy;
                $payment->vendor_id = $vendor->id;
                $payment->payment_id = rand(1111, 9999);
                $payment->payment_amount = $amount;
                $payment->method = $request->payment_details;
                $payment->transaction_type = 'credit';
                $payment->description = 'Payment for category product topup';
                $payment->status = 1;
                $payment->save();
            }
        }
        foreach ($business_category_service_balance as $key => $balance) {
            if($balance > 0){
                $payment = new VendorPaymentHistroy;
                $payment->vendor_id = $vendor->id;
                $payment->payment_id = rand(1111, 9999);
                $payment->payment_amount = $amount;
                $payment->method = $request->payment_details;
                $payment->transaction_type = 'credit';
                $payment->description = 'Payment for category service topup';
                $payment->status = 1;
                $payment->save();
            }
        }
        $user_vendor_data = UserVendor::where('vendor_id', $vendor->id)->first();
        if (!empty($user_vendor_data->user_id)) {
            $user = User::find($user_vendor_data->user_id);
            $user->balance = $user->balance + 200;
            $user->save();
            $wallet_transaction = new UserWallet;
            $wallet_transaction->user_id = $user->id;
            $wallet_transaction->amount = 200;
            $wallet_transaction->transaction_type = 'Credited';
            $wallet_transaction->transaction_detail = 'Amount Received of Rs.200 for Vendor Regiration from ' . $vendor->name;
            $wallet_transaction->balance = $user->balance;
            $wallet_transaction->approval = 'Confirmed';
            $wallet_transaction->save();
        }

        $response_data=json_decode($request->payment_details);
        $payment = PaymentTransaction::where('mt_id',$response_data->data->merchantTransactionId)->first();
        $payment->payment_details = $request->payment_details;
        $payment->status = 'success';
        $payment->save();


        return redirect()->route('vendor.profile');
    }


    public function vendor_categories_product_fess_phonepe(Request $request){
            $phonepe = new PhonepeController;
            return redirect($phonepe->payWithPhonePe($request));
    }

    public function vendor_categories_product_fess(Request $request)
    {

        //dd($request->all());
        $vendor = Vendor::find(Auth::guard('vendor')->user()->id);
        $category_id = $request->category_id;
        $categories = json_decode($vendor->business_category);
        $commissions = json_decode($vendor->product_comission_percentage);
        $comission_type = json_decode($vendor->product_type_comission);
        $vendor_balance_amount = json_decode($vendor->business_category_product_balance);
        $amount = $request->amount;
        $business_category_balance = [];
        foreach ($categories as $key => $category) {
            if ($category == $category_id) {
                if ($commissions[$key] > 0) {
                    if ($comission_type[$key] == 'percent') {
                        $balance_amount = $vendor_balance_amount[$key] + (($amount * 100) / $commissions[$key]);
                    }
                    if ($comission_type[$key] == 'amount') {
                        $balance_amount = $vendor_balance_amount[$key] + $amount;
                    }
                } else {
                    return back()->with('error', 'Comission zero can not be recharged!');
                }
            } else {
                $balance_amount = $vendor_balance_amount[$key];
            }
            array_push($business_category_balance, round($balance_amount, 2));
        }
        $vendor->business_category_product_balance = json_encode($business_category_balance);
        $vendor->save();


        $payment = new VendorPaymentHistroy;
        $payment->vendor_id = $vendor->id;
        $payment->payment_id = rand(1111, 9999);
        $payment->payment_amount = $amount;
        $payment->method = $request->payment_details;
        $payment->transaction_type = 'credit';
        $payment->description = 'Payment for category product topup';
        $payment->status = 1;
        $payment->save();

        $response_data=json_decode($request->payment_details);
        $payment = PaymentTransaction::where('mt_id',$response_data->data->merchantTransactionId)->first();
        $payment->payment_details = $request->payment_details;
        $payment->status = 'success';
        $payment->save();


        return redirect()->route('topup_category');
    }

    public function vendor_categories_service_fess_phonepe(Request $request)
    {
        $phonepe = new PhonepeController;
        return redirect($phonepe->payWithPhonePe($request));
    }


    public function vendor_categories_service_fess(Request $request)
    {
        //dd($request->all());
        $vendor = Vendor::find(Auth::guard('vendor')->user()->id);
        $category_id = $request->category_id;
        $categories = json_decode($vendor->business_category);
        $commissions = json_decode($vendor->service_comission_percentage);
        $comission_type = json_decode($vendor->service_type_comission);
        $vendor_balance_amount = json_decode($vendor->business_category_service_balance);
        $amount = $request->amount;
        $business_category_balance = [];
        foreach ($categories as $key => $category) {
            if ($category == $category_id) {
                if ($commissions[$key] > 0) {
                    if ($comission_type[$key] == 'percent') {
                        $balance_amount = $vendor_balance_amount[$key] + (($amount * 100) / $commissions[$key]);
                    }
                    if ($comission_type[$key] == 'amount') {
                        $balance_amount = $vendor_balance_amount[$key] + $amount;
                    }
                } else {
                    return back()->with('error', 'Comission zero can not be recharged!');
                }
            } else {
                $balance_amount = $vendor_balance_amount[$key];
            }

            array_push($business_category_balance, round($balance_amount, 2));
        }
        $vendor->business_category_service_balance = json_encode($business_category_balance);
        $vendor->save();


        $payment = new VendorPaymentHistroy;
        $payment->vendor_id = $vendor->id;
        $payment->payment_id = rand(1111, 9999);
        $payment->payment_amount = $amount;
        $payment->method = $request->payment_details;
        $payment->transaction_type = 'credit';
        $payment->description = 'Payment for category service topup';
        $payment->status = 1;
        $payment->save();

        $response_data=json_decode($request->payment_details);
        $payment = PaymentTransaction::where('mt_id',$response_data->data->merchantTransactionId)->first();
        $payment->payment_details = $request->payment_details;
        $payment->status = 'success';
        $payment->save();



        return redirect()->route('topup_category');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Pujari;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\UserVendor;
use App\Models\UserWallet;
use App\Models\OrderDetail;
use App\Models\ServiceCity;
use App\Models\PujariWallet;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\BusinessCategory;
use App\Models\PaymentTransaction;
use App\Models\VendorPaymentHistroy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class PujariController extends Controller
{

    public function index(Request $request)
    {
        $vendors = Pujari::all();

        return view('backend.pujari.index', compact('vendors'));
    }

    public function verified_pujari_list(Request $request)
    {
        $vendors = Pujari::all();
        return view('backend.pujari.verified_pujari_list', compact('vendors'));
    }
    public function unverified_pujari_list(Request $request)
    {
        $vendors = Pujari::all();
        return view('backend.pujari.unverified_pujari_list', compact('vendors'));
    }
    public function get_pujari(Request $request)
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

         ## Custom Field value
         $status = $request->get('status');
         $city = $request->get('city');
         $pincode = $request->get('pincode');

        $users = Pujari::where('id', '>', 0);
        $total = $users->count();

        $totalFilter = Pujari::where('id', '>', 0);
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('name', 'like', '%' . $searchValue . '%');
        }
        if (isset($status)) {
            $totalFilter = $totalFilter->where('verified',$status);
        }
        if (!empty($city)) {
            $totalFilter = $totalFilter->whereJsonContains('city',''.$city);
        }
        if (!empty($pincode)) {
            $totalFilter = $totalFilter->whereJsonContains('pincode',$pincode);
        }
        $totalFilter = $totalFilter->count();


        $arrData = Pujari::where('id', '>', 0);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('name', 'like', '%' . $searchValue . '%')->orwhere('phone', 'like', '%' . $searchValue . '%')->orwhere('email', 'like', '%' . $searchValue . '%')->orwhere('pujari_code', 'like', '%' . $searchValue . '%');
        }

        if (isset($status)) {
            $arrData = $arrData->where('verified',$status);
        }
        if (!empty($city)) {
            $arrData = $arrData->whereJsonContains('city',''.$city);
        }
        if (!empty($pincode)) {
            $arrData = $arrData->whereJsonContains('pincode',$pincode);
        }

        $arrData = $arrData->get()->map(function ($pujari) {
            // Decode the city_ids JSON
            $cityIds = json_decode($pujari->city, true);

            // Fetch city names for these IDs
            $cityNames = ServiceCity::whereIn('id', $cityIds)->pluck('city')->toArray();

            // Add city names to the pujari data
            $pujari->city_names = implode(', ', $cityNames);

            return $pujari;
        });

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        );

        return response()->json($response);
    }
    public function get_pujari_verified(Request $request)
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

         ## Custom Field value
         $status = 1;
         $city = $request->get('city');
         $pincode = $request->get('pincode');

        $users = Pujari::where('id', '>', 0);
        $total = $users->count();

        $totalFilter = Pujari::where('id', '>', 0);
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('name', 'like', '%' . $searchValue . '%');
        }

            $totalFilter = $totalFilter->where('verified',$status);

        if (!empty($city)) {
            $totalFilter = $totalFilter->whereJsonContains('city',''.$city);
        }
        if (!empty($pincode)) {
            $totalFilter = $totalFilter->whereJsonContains('pincode',$pincode);
        }
        $totalFilter = $totalFilter->count();


        $arrData = Pujari::where('id', '>', 0);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('name', 'like', '%' . $searchValue . '%')->orwhere('phone', 'like', '%' . $searchValue . '%')->orwhere('email', 'like', '%' . $searchValue . '%')->orwhere('pujari_code', 'like', '%' . $searchValue . '%');
        }

            $arrData = $arrData->where('verified',$status);

        if (!empty($city)) {
            $arrData = $arrData->whereJsonContains('city',''.$city);
        }
        if (!empty($pincode)) {
            $arrData = $arrData->whereJsonContains('pincode',$pincode);
        }

        $arrData = $arrData->get()->map(function ($pujari) {
            // Decode the city_ids JSON
            $cityIds = json_decode($pujari->city, true);

            // Fetch city names for these IDs
            $cityNames = ServiceCity::whereIn('id', $cityIds)->pluck('city')->toArray();

            // Add city names to the pujari data
            $pujari->city_names = implode(', ', $cityNames);

            return $pujari;
        });

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        );

        return response()->json($response);
    }
    public function get_pujari_unverified(Request $request)
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

         ## Custom Field value
         $status = 0;
         $city = $request->get('city');
         $pincode = $request->get('pincode');

        $users = Pujari::where('id', '>', 0);
        $total = $users->count();

        $totalFilter = Pujari::where('id', '>', 0);
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('name', 'like', '%' . $searchValue . '%');
        }

            $totalFilter = $totalFilter->where('verified',$status);

        if (!empty($city)) {
            $totalFilter = $totalFilter->whereJsonContains('city',''.$city);
        }
        if (!empty($pincode)) {
            $totalFilter = $totalFilter->whereJsonContains('pincode',$pincode);
        }
        $totalFilter = $totalFilter->count();


        $arrData = Pujari::where('id', '>', 0);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('name', 'like', '%' . $searchValue . '%')->orwhere('phone', 'like', '%' . $searchValue . '%')->orwhere('email', 'like', '%' . $searchValue . '%')->orwhere('pujari_code', 'like', '%' . $searchValue . '%');
        }


            $arrData = $arrData->where('verified',$status);

        if (!empty($city)) {
            $arrData = $arrData->whereJsonContains('city',''.$city);
        }
        if (!empty($pincode)) {
            $arrData = $arrData->whereJsonContains('pincode',$pincode);
        }

        $arrData = $arrData->get()->map(function ($pujari) {
            // Decode the city_ids JSON
            $cityIds = json_decode($pujari->city, true);

            // Fetch city names for these IDs
            $cityNames = ServiceCity::whereIn('id', $cityIds)->pluck('city')->toArray();

            // Add city names to the pujari data
            $pujari->city_names = implode(', ', $cityNames);

            return $pujari;
        });

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
        return view('backend.pujari.create');
    }
    public function vendor_view($id)
    {
        $pujari = Pujari::find($id);
        $assign_puja = OrderDetail::where('pujari_id',$id)->get();
        return view('backend.pujari.view', compact('pujari','assign_puja'));
    }
    public function edit($id)
    {
        $pujari = Pujari::find($id);
        return view('backend.pujari.edit', compact('pujari'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'phone' => 'required|unique:vendors',
        ]);

        $vendor = new Pujari;
        $vendor->vendor_code = 'P'.rand(11111111,99999999);
        $vendor->name = $request->name;
        $vendor->email = $request->email;

        $vendor->father_name = $request->father_name;
        $vendor->dob = $request->dob;
        $vendor->whatsapp = $request->whatsapp;
        $vendor->category = $request->category;
        $vendor->pincode = $request->pincode;
        $vendor->city = $request->city;
        $vendor->language = $request->language;
        $vendor->address = $request->address;
        $vendor->bank_name = $request->bank_name;
        $vendor->branch_name = $request->branch_name;
        $vendor->account_number = $request->account_number;
        $vendor->phone = $request->phone;
        $vendor->ifsc_code = $request->ifsc_code;
        $vendor->account_holder_name = $request->account_holder_name;


        if (!empty($request->logo)) {
            $file = $request->file('logo');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/pujari/'), $image);
            $vendor->logo = $image;
        }


        $vendor->save();

        return redirect()->route('pujari_list');
    }

    public function update(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'phone' => 'required|unique:pujaris,phone,' . $request->id,
        ]);

        $vendor = Pujari::find($request->id);
        $vendor->name = $request->name;
        $vendor->email = $request->email;

        $vendor->father_name = $request->father_name;
        $vendor->dob = $request->dob;
        $vendor->whatsapp = $request->whatsapp;
        $vendor->category = $request->category;
        $vendor->pincode = $request->pincode;
        $vendor->city = $request->city;
        $vendor->language = $request->language;
        $vendor->address = $request->address;
        $vendor->bank_name = $request->bank_name;
        $vendor->branch_name = $request->branch_name;
        $vendor->account_number = $request->account_number;
        $vendor->phone = $request->phone;
        $vendor->ifsc_code = $request->ifsc_code;
        $vendor->account_holder_name = $request->account_holder_name;

        if (!empty($request->logo)) {
            $file = $request->file('logo');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/pujari/'), $image);
            $vendor->logo = $image;
        }

        $vendor->save();

        return redirect()->route('pujari_list');
    }

    public function delete($id)
    {
        $pujari = Pujari::find($id);
        $pujari->delete();
        return redirect()->back();
    }

    public function pujariLogin()
    {
        if (Auth::guard('pujari')->check()) {
            return redirect()->route('vendor.dashboard');
        }
        return view('frontend.pujari-login');
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

    public function attemptRegister(Request $request)
    {

        $request->validate([
            'name'=>'required',
            'phone' => 'required|digits:10|unique:pujaris',
            'address' => 'required',
            'logo' =>'required|mimes:png,jpg,jpeg,webp'
        ]);
        $user =new Pujari;
        $user->phone=$request->phone;
        $user->pujari_code= Pujari::generateUniquePujariCode();
        $user->name=$request->name;
        $user->father_name=$request->father_name;
        $user->name = $request->name;
        $user->category = json_encode($request->category);
        $user->dob = $request->dob;
        $user->pincode = json_encode($request->pincode);
        $user->city = json_encode($request->city);
        if(!empty($request->terth_city)){
            $user->terth_city = json_encode($request->terth_city);
        }else{
            $user->terth_city = '[]';
        }
        $user->language=json_encode($request->language);
        $user->address = $request->address;


        $user->save();

        if (!empty($request->logo)) {
            $file = $request->file('logo');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/pujari/'.$user->id.'/'), $image);
            $user->logo = $image;
        }

        $user->save();
        return redirect()->route('pujari-login')->with('success', 'Register Successfully! Please login after verification.');
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
        $vendor = Pujari::findOrFail($request->id);
        $vendor->ban = $request->ban;
        if ($vendor->save()) {
            return 1;
        }
        return 0;
    }

    public function updateVerified(Request $request)
    {
        $vendor = Pujari::findOrFail($request->id);
        $vendor->verified = $request->ban;
        if ($vendor->save()) {
            return 1;
        }
        return 0;
    }

    public function updateOnline(Request $request)
    {
        $vendor = Pujari::findOrFail($request->id);
        $vendor->is_online = $request->is_online;
        if ($vendor->save()) {
            return 1;
        }
        return 0;
    }



    public function profile_update(Request $request)
    {
        $vendor = Pujari::find($request->id);
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->category = $request->category;
        $vendor->father_name = $request->father_name;
        $vendor->dob = $request->dob;
        $vendor->whatsapp = $request->whatsapp;

        $vendor->pincode = $request->pincode;
        $vendor->city = $request->city;
        if(!empty($request->terth_city)){
            $vendor->terth_city = $request->terth_city;
        }else{
            $vendor->terth_city = '[]';
        }

        $vendor->language=$request->language;
        $vendor->address = $request->address;

        $vendor->save();

        if (!empty($request->logo)) {
            $file = $request->file('logo');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/pujari/'.$vendor->id.'/'), $image);
            $vendor->logo = $image;
        }
        $vendor->save();
        return redirect()->back();
    }

    public function bank_update(Request $request){

        $vendor = Pujari::find($request->id);
        $vendor->bank_name = $request->bank_name;
        $vendor->branch_name = $request->branch_name;
        $vendor->account_number = $request->account_number;
        $vendor->ifsc_code = $request->ifsc_code;
        $vendor->account_holder_name = $request->account_holder_name;



        $vendor->save();

        if (!empty($request->passbook_image)) {
            $file = $request->file('passbook_image');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/pujari/'.$vendor->id.'/'), $image);
            $vendor->passbook_image = $image;
        }

        if (!empty($request->checkbook_image)) {
            $file = $request->file('checkbook_image');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/pujari/'.$vendor->id.'/'), $image);
            $vendor->checkbook_image = $image;
        }

        $vendor->save();
        return redirect()->back();
    }

    public function education_update(Request $request){
        $vendor = Pujari::find($request->id);
        $vendor->experince = $request->experince;
        $vendor->save();

        if (!empty($request->pan_card)) {
            $file = $request->file('pan_card');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/pujari/'.$vendor->id.'/'), $image);
            $vendor->pan_card = $image;
        }

        if (!empty($request->aadhaar_card)) {
            $file = $request->file('aadhaar_card');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/pujari/'.$vendor->id.'/'), $image);
            $vendor->aadhaar_card = $image;
        }

        if (!empty($request->aadhaar_card_back)) {
            $file = $request->file('aadhaar_card_back');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/pujari/'.$vendor->id.'/'), $image);
            $vendor->aadhaar_card_back = $image;
        }

        $qualifications = [];
        $image_array = [];

        // Handle uploaded images and retain existing ones if not replaced
        if ($request->qualifications) {
            foreach ($request->qualifications as $key => $qualification) {
                $qualifications[] = $qualification;

                if (isset($request->qualification_images[$key]) && $request->qualification_images[$key]->isValid()) {
                    // Handle new image upload
                    $file = $request->qualification_images[$key];
                    $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
                    $file->move(public_path('frontend/pujari/'.$vendor->id.'/'), $image);
                    $image_array[] = $image;
                } else {
                    // Retain existing image if no new image is uploaded
                    $existing_images = json_decode($vendor->qualification_image, true) ?? [];
                    $image_array[] = $existing_images[$key] ?? null;
                }
            }
        }

        // Update vendor qualifications and images
        $vendor->qualification = json_encode($qualifications);
        $vendor->qualification_image = json_encode($image_array);
        $vendor->save();

        return redirect()->back();
    }



    public function attemptLogin(Request $request)
    {

            $customer = Pujari::where('phone', $request->input_name)->where('verified',1)->first();
            if (!empty($customer)) {
                Auth::guard('pujari')->login($customer, false);
                return redirect()->route('pujari.dashboard');
            }else{
                return back()->withErrors([
                    'input_name' => 'Please Login After Verification',
                ]);
            }

    }

    public function attemptLogout()
    {
        Auth::guard('pujari')->logout();
        return redirect()->route('pujari-login');
    }


    public function send_otp(Request $request)
    {

            $mobileregex = "/^[6-9][0-9]{9}$/";
            if ($request->phone != '' && preg_match($mobileregex, $request->phone) === 1) {
                $user = Pujari::where('phone', $request->phone)->first();
                if (!empty($user->name)) {
                    $mob_otp = rand(1000, 9999);
                    Session::forget('pujari_mob_otp');
                    Session::put('pujari_mob_otp', [$mob_otp]);
                    $user->otp = $mob_otp;
                    $user->save();
                    if ($request->form_name == 'sms_form') {
                        login_by_sms($request->phone, $mob_otp);
                    }
                    return response()->json(['status' => true, 'otp' => $mob_otp]);
                }else {
                    $user =new Pujari;
                    $user->phone=$request->phone;
                    $user->pujari_code= Pujari::generateUniquePujariCode();
                    $user->name=$request->name;
                    $mob_otp = rand(1000, 9999);
                    Session::forget('pujari_mob_otp');
                    Session::put('pujari_mob_otp', [$mob_otp]);
                    $user->otp = $mob_otp;
                    $user->save();

                    login_by_sms($request->phone, $mob_otp);
                    return response()->json(['status' => true, 'otp' => $mob_otp]);
                }
            } else {
                return response()->json(['status' => false]);
            }

    }

        public function send_pujari_otp(Request $request)
    {

            $mobileregex = "/^[6-9][0-9]{9}$/";
            if ($request->phone != '' && preg_match($mobileregex, $request->phone) === 1) {
                $user = Pujari::where('phone', $request->phone)->where('verified',1)->first();
                if (!empty($user->id)) {
                    $mob_otp = rand(1000, 9999);
                    Session::forget('pujari_mob_otp');
                    Session::put('pujari_mob_otp', [$mob_otp]);

                  login_by_sms($request->phone, $mob_otp);

                  return response()->json(['status' => true, 'otp' => $mob_otp]);
                }else{
                    return response()->json(['status' => false]);
                }
            }


    }

    public function check_otp(Request $request)
    {

        $otp = Session::get('pujari_mob_otp');
        if ($otp[0] == $request->otp) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function assign_puja(Request $request){

        $assign_puja = OrderDetail::where('pujari_id',Auth::guard('pujari')->user()->id)->get();
        return view('pujari_dashboard.puja.assign_puja', compact('assign_puja'));

    }
    public function assign_puja_show($id){

        $order_detail = OrderDetail::find($id);
        $order=Order::find($order_detail->order_id);
        return view('pujari_dashboard.puja.puja_details', compact('order','order_detail'));

    }

    public function payment_status_update(Request $request){

        $order= OrderDetail::find($request->order_id);
        $order->pujari_status=$request->status;

        if($request->status=='completed'){

            $pujari_wallet=new PujariWallet;
            $pujari_wallet->pujari_id = $request->pujari_id;
            $pujari_wallet->amount=$request->pujari_comission;
            $pujari_wallet->transaction_type = 'credit';
            $pujari_wallet->balance = $pujari->admin_to_pay;
            $pujari_wallet->save();

        }

        $order->save();

        return 1;
    }


    public function wallet(Request $request){
        $wallet = PujariWallet::where('pujari_id',Auth::guard('pujari')->user()->id)->get();
        return view('pujari_dashboard.wallet', compact('wallet'));
    }

}

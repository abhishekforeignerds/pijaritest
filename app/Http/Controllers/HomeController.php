<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rapid;
use App\Models\Leader;
use App\Models\Poiner;
use App\Models\Reward;
use App\Models\Vendor;
use App\Models\Gallery;
use App\Models\Pincode;
use App\Models\Product;
use App\Models\Service;
use App\Models\UserKyc;
use App\Models\Category;
use App\Models\Comission;
use App\Models\ContactUs;
use App\Models\President;
use App\Models\UserReward;
use App\Models\UserWallet;
use App\Models\SubCategory;
use App\Models\AchiveReward;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\BusinessCategory;
use Craftsys\Msg91\Facade\Msg91;
use App\Models\ServiceSubCategory;
use App\Models\ReferralTransaction;
use App\Models\UserWithdrwalRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    public function customer_dashboard()
    {
        $total_direct_active = User::where('referral_by', Auth::user()->referral_code)->where('status', 1)->get()->count();
        $total_direct_in_active = User::where('referral_by', Auth::user()->referral_code)->where('status', 0)->get()->count();

        $total_indirect_active = getTotalTeamCount(Auth::user()->id) - count(User::where('referral_by', Auth::user()->referral_code)->where('status', 1)->get());
        $total_indirect_inactive = getTotalTeamIACount(Auth::user()->id) - count(User::where('referral_by', Auth::user()->referral_code)->where('status', 0)->get());

        $total_team = $total_indirect_active + $total_indirect_inactive + $total_direct_active + $total_direct_in_active;

        $withdraw_requests = UserWithdrwalRequest::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->where('status', 1)->get()->sum('paid_amount');
        return view('user_dashboard.dashboard', compact('total_direct_active', 'total_direct_in_active', 'total_team', 'total_indirect_active', 'total_indirect_inactive', 'withdraw_requests'));
    }

    public function home()
    {
        $business_categories = BusinessCategory::where('status', 1)->where('featured', 1)->limit(12)->get();

        $service_categories = ServiceCategory::where('status', 1)->where('featured', 1)->limit(12)->get();

        $vendors = Vendor::where('status', 1)->where('ban', 1)->where('pincode', session()->get('pincode'))->limit(12)->get();

        $featured_product_categories = Category::where('featured', 1)->where('status', 1)->whereHas('product', function ($q) {
            $q->whereHas('vendor', function ($s) {
                $s->where('pincode', session()->get('pincode'))->where('ban', 1);
            });
        })->limit(12)->get();

        $featured_service_categories = ServiceCategory::where('featured', 1)->where('status', 1)->whereHas('service', function ($q) {
            $q->whereHas('vendor', function ($s) {
                $s->where('pincode', session()->get('pincode'))->where('ban', 1);
            });
        })->limit(12)->get();

        $poiner_ids = Poiner::orderBy('id','desc')->get()->pluck('user_id');
        $leader_ids = Leader::orderBy('id','desc')->get()->pluck('user_id');
        $rapid_ids = Rapid::orderBy('id','desc')->get()->pluck('user_id');
        $president_ids = President::orderBy('id','desc')->get()->pluck('user_id');



        $poiners = User::whereIn('id', $poiner_ids)->orderBy('id','desc')->take(5)->get();
        $leaders = User::whereIn('id', $leader_ids)->orderBy('id','desc')->take(5)->get();
        $rapids = User::whereIn('id', $rapid_ids)->orderBy('id','desc')->inRandomOrder()->take(5)->get();
        $president_clubs = User::whereIn('id', $president_ids)->orderBy('id','desc')->take(5)->get();

        return view('frontend.index', compact('business_categories', 'service_categories', 'vendors', 'featured_product_categories', 'featured_service_categories', 'poiners', 'leaders', 'rapids', 'president_clubs'));
    }

    public function club_member()
    {
        $poiner_ids = Poiner::truncate();
        $leader_ids = Leader::truncate();
        $rapid_ids = Rapid::truncate();
        $president_ids = President::truncate();

        $all_user = User::where('status', 1)->get();
        foreach ($all_user as $user) {
            $total_direct = count(User::where('referral_by', $user->referral_code)->where('status',1)->get());
            $total_team = getTotalTeamCount($user->id);
            if (($total_direct >= 40) && ($total_team >= 80)) {
                $president = new President;
                $president->user_id = $user->id;
                $president->date = date('Y-m-d');
                $president->save();
                continue;
            }
            if (($total_direct >= 20) && ($total_team >= 40)) {
                $rapid = new Rapid;
                $rapid->user_id = $user->id;
                $rapid->date = date('Y-m-d');
                $rapid->save();
                continue;
            }
            if (($total_direct >= 10) && ($total_team >= 20)) {
                $leader = new Leader;
                $leader->user_id = $user->id;
                $leader->date = date('Y-m-d');
                $leader->save();
                continue;
            }
            if (($total_direct >= 5) && ($total_team >= 10)) {
                $poiner = new Poiner;
                $poiner->user_id = $user->id;
                $poiner->date=date('Y-m-d');
                $poiner->save();
                continue;
            }
        }
       return  back()->with('success', 'Club Generated Successfully!');
    }

    public function gallery(){

        $gallery=Gallery::where('delete_status',0)->get();
        return view('frontend.gallery',compact('gallery'));

    }

    public function poiner_view_all(){

        $poiner_ids = Poiner::get()->pluck('user_id');
        $list = User::whereIn('id', $poiner_ids)->orderBy('id','desc')->get();
        $list_name='Poiners Club';
        return view('frontend.club_member',compact('list','list_name'));

    }

    public function leader_view_all(){
        $leader_ids = Leader::get()->pluck('user_id');
        $list = User::whereIn('id', $leader_ids)->orderBy('id','desc')->get();
        $list_name='Leaders Club';
        return view('frontend.club_member',compact('list','list_name'));

    }

    public function rapid_view_all(){
        $rapid_ids = Rapid::get()->pluck('user_id');
        $list = User::whereIn('id', $rapid_ids)->orderBy('id','desc')->get();
        $list_name='Rapid Club';
        return view('frontend.club_member',compact('list','list_name'));
    }

    public function president_view_all(){
        $president_ids = President::get()->pluck('user_id');
        $list = User::whereIn('id', $president_ids)->orderBy('id','desc')->get();
        $list_name='President Club';
        return view('frontend.club_member',compact('list','list_name'));
    }

    public function search(Request $request)
    {
        $query = $request->q;
        $category_id = $request->business_category;
        $conditions = ['pincode' => session()->get('pincode')];

        if (!empty($query)) {
            $business_category = BusinessCategory::where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')->orWhere('keyword', 'like', '%' . $query . '%');
            })->first();

            if (!empty($business_category->id)) {
                $category_ids = $business_category->id;
            }
        }



        $vendors = Vendor::where($conditions)->where('ban', 1);

        if ($query != null) {

            $vendors = $vendors->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')->orWhere('firm_name', 'like', '%' . $query . '%');
            });
        }

        if ($category_id != null) {
            $vendors = $vendors->whereJsonContains('business_category', '' . $category_id);
        }

        if (!empty($business_category->id)) {
            $vendors = $vendors->orwhereJsonContains('business_category', '' . $category_ids);
        }

        $vendors = $vendors->paginate(20);
        $vendors->appends($request->query());
        return view('frontend.all-vendor', compact('vendors', 'query'));
    }

    public function search_shoping(Request $request)
    {
        $query = $request->q;
        $category_id = $request->category;
        $subcategory_id = $request->subcategory;
        $vendor_id = $request->vendor;
        $conditions = ['status' => 1];

        if ($category_id != null) {
            $conditions = array_merge($conditions, ['category_id' => $category_id]);
        }
        if ($subcategory_id != null) {
            $conditions = array_merge($conditions, ['subcategory_id' => $subcategory_id]);
        }
        if ($vendor_id != null) {
            $conditions = array_merge($conditions, ['vendor_id' => $vendor_id]);
        }
        $products = ProductStock::where($conditions)->whereHas('vendor', function ($q) {
            $q->where('pincode', session()->get('pincode'))->where('ban', 1);
        });

        if ($query != null) {
            $products = $products->whereHas('product', function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')->orWhere('tag', 'like', '%' . $query . '%');
            });
        }

        $products = $products->paginate(20);
        $products->appends($request->query());
        return view('frontend.all-product', compact('products', 'query'));
    }

    public function search_service(Request $request)
    {
        $query = $request->q;
        $category_id = $request->category;
        $subcategory_id = $request->subcategory;
        $vendor_id = $request->vendor;
        $conditions = ['status' => 1];

        if ($category_id != null) {
            $conditions = array_merge($conditions, ['category_id' => $category_id]);
        }
        if ($subcategory_id != null) {
            $conditions = array_merge($conditions, ['subcategory_id' => $subcategory_id]);
        }
        if ($vendor_id != null) {
            $conditions = array_merge($conditions, ['vendor_id' => $vendor_id]);
        }
        $services = Service::where($conditions)->whereHas('vendor', function ($q) {
            $q->where('pincode', session()->get('pincode'))->where('ban', 1);
        });

        if ($query != null) {
            $services = $services->where('name', 'like', '%' . $query . '%')->orWhere('tag', 'like', '%' . $query . '%');
        }

        $services = $services->paginate(20);
        $services->appends($request->query());
        return view('frontend.all-service', compact('services', 'query'));
    }

    public function product_detail(Request $request, $id)
    {
        $product = Product::find($id);
        return view('frontend.product-details', compact('product'));
    }

    public function shop_detail(Request $request, $id)
    {
        $vendor = Vendor::find($id);
        return view('frontend.shop-details', compact('vendor'));
    }

    public function service_detail(Request $request, $id)
    {
        $service = Service::find($id);
        return view('frontend.service_details', compact('service'));
    }

    public function signin()
    {
        if (Auth::check()) {
            return redirect()->route('customer.dashboard');
        }
        return view('frontend.include.signin');
    }
    public function signup()
    {
        return view('frontend.include.signup');
    }
    public function attemptLogin(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'referral_code' => 'required|exists:users',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            if (Auth::attempt(['referral_code' => $request->referral_code, 'password' => $request->password], !empty($request->remember) ? true : false)) {
                //     Mail::send('frontend.email.welcome_mail', [] ,function($message) use($request){
                //         $message->to('ashutoshm778@gmail.com');
                //         $message->subject('Welcome Email');
                //    });
                return redirect()->route('customer.dashboard')->with('success', 'You Have Successfully Login!');
            } else {
                $validator->getMessageBag()->add('password', 'Wrong Password');
                return back()->withErrors($validator)->withInput();
            }
        }
    }

    public function attemptRegister(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'phone' => 'required|digits:10|unique:users',
            'otp' => 'required|digits:4',
            'referral_by' => 'required|exists:users,referral_code',
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
            $user->logo = $image;
        }

        $user->save();

        $user_bank = new UserKyc;
        $user_bank->user_id =  $user->id;
        $user_bank->save();

        if (!empty($request->referral_by)) {

            $commission_data = commissions();

            $level = 18;
            $referral_code = $request->referral_by;
            for ($i = 1; $i <= $level; $i++) {
                $refferal_customer = User::where('referral_code', $referral_code)->first();

                if (!empty($refferal_customer->id)) {
                    $commission = new Comission;
                    $commission->user_id = $refferal_customer->id;
                    $commission->referral_user_id = $user->id;
                    $commission->commission = $commission_data[$i - 1];
                    $commission->level = $i;
                    $commission->status = 0;
                    $commission->save();

                    $referral_code = $refferal_customer->referral_by;
                }
            }
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], !empty($request->remember) ? true : false)) {
            return redirect()->route('customer.dashboard')->with('success', 'You Have Successfully Login!');
        }
        return redirect()->back()->with('error', 'Invalid Credentials! Please try again');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('customer_login')->with('success', 'You Have Successfully Logout!');
    }

    public function checkreferral(Request $request)
    {
        $user = User::where('referral_code', $request->referral_code)->first();
        if (!empty($user)) {
            return $user;
        } else {
            return 0;
        }
    }

    public function check_pincode(Request $request)
    {
        $pincode_data = Pincode::where('pincode', $request->pincode)->where('status', 'active')->first();
        if (!empty($pincode_data)) {

            return response()->json([
                'status' => 1,
                'locations' => $pincode_data->city . ',' . $pincode_data->state,
                'pincode' => $pincode_data->pincode,
            ], 200);
        } else {
            return response()->json([
                'status' => 2,
                'pincode' => 221010,
                'locations' => 'We are currently not available at this location. We shall be back soon.',
            ], 200);
        }
    }

    public function select_pincode(Request $request)
    {
        session()->put('pincode', $request->postal_code);
        return redirect()->back();
    }

    public function all_product_subcategory($id)
    {
        $sub_categories = SubCategory::where('category_id', $id)->where('status', 1)->get();
        return view('frontend.all-product_sub_category', compact('sub_categories'));
    }

    public function all_service_subcategory($id)
    {
        $sub_categories = ServiceSubCategory::where('category_id', $id)->where('status', 1)->get();
        return view('frontend.all-service_sub_category', compact('sub_categories'));
    }

    public function sendOtp(Request $request)
    {
        $data = User::where('phone', $request->phone)->first();
        if (empty($data)) {
            $phone = '91' . $request->phone;
            if (env('APP_ENV') == 'local') {
                $otp = 1234;
                Session::put('otp', $otp);
                return 1;
            } else {
                $otp = rand(1111, 9999);
                Session::put('otp', $otp);
                Msg91::sms()->to('91' . $request->phone)->flow('654c6ce1d6fc0564471e9e84')->variable('user', 'customer')->variable('var', $otp)->send();
                return 1;
            }
        } else {
            return 2;
        }
    }

    public function sendOtpForgotPassword(Request $request)
    {
        $data = User::where('phone', $request->phone)->first();
        if (!empty($data)) {
            $phone = '91' . $request->phone;
            if (env('APP_ENV') == 'local') {
                $otp = 1234;
                Session::put('otp', $otp);
                return 1;
            } else {
                $otp = rand(1111, 9999);
                Session::put('otp', $otp);
                Msg91::sms()->to('91' . $request->phone)->flow('654c6ce1d6fc0564471e9e84')->variable('user', 'customer')->variable('var', $otp)->send();
                return 1;
            }
        } else {
            return 2;
        }
    }

    public function checkOtp(Request $request)
    {
        if (Session::get('otp') != $request->otp) {
            return 0;
        } else {
            return 1;
        }
    }

    public function customer_send_otp(Request $request)
    {
        return dd($request->all());
    }

    public function payout_status(Request $request)
    {
        $webhookPayload = $request->getContent();

        $data = json_decode($webhookPayload);
        $withdraw_request = UserWithdrwalRequest::where('payment_id', $data->payload->payout->entity->id)->first();
        $withdraw_request->payment_details = $webhookPayload;
        $withdraw_request->save();

        if(($withdraw_request->status!=2) || ($withdraw_request->status!=1)){
            if ($data->payload->payout->entity->status == 'reversed') {
                $user_data = User::find($withdraw_request->user_id);
                $user_data->balance = round($user_data->balance + $withdraw_request->amount, 2);
                $user_data->save();


                $wallet = new UserWallet;
                $wallet->user_id = $withdraw_request->user_id;
                $wallet->amount = round($withdraw_request->amount, 2);
                $wallet->transaction_type = 'Credit';
                $wallet->transaction_detail = 'Amount Credited due to technical error of Rs' . round($withdraw_request->amount, 2);
                $wallet->balance = round($user_data->balance, 2);
                $wallet->approval = 'Confirmed';
                $wallet->save();

                $withdraw_request->status = 2;
                $withdraw_request->save();
            }
        }

        if ($data->payload->payout->entity->status == 'processed'){
            $withdraw_request->status=1;
            $withdraw_request->viewed=1;
            $withdraw_request->save();
        }
    }


    public function resetPassword(Request $request)
    {
        //dd($request->all());
        $data = User::where('referral_code', $request->referral_by)->first();
        if (Session::get('otp') == $request->otp) {
            $data->password = Hash::make($request->password);
            $data->save();
            return redirect()->route('customer_login')->with('success', 'Password Chaged Successfully!');
        }
    }
    public function contact_us(Request $request)
    {

        $contact = new ContactUs;
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->email = $request->email;
        $contact->phone_number = $request->phone_number;
        $contact->message = $request->message;
        $contact->save();

        return back()->with('success', 'Enquiry Send  Successfully');
    }

    public function acheive_reward(Request $request)
    {

        $user = User::find(Auth::user()->id);

        $achive_reward = new AchiveReward;
        $achive_reward->user_id = $user->id;
        $achive_reward->reward_id = $request->reward_id;
        $achive_reward->date = date('Y-m-d');
        $achive_reward->save();

        $user->total_gv = 0;
        $user->save();

        $reward_data=Reward::find($request->reward_id);


        $referral_code = $user->referral_by;
        $current_user = User::find($user->id);

        do {
            $parent_user = User::where('referral_code', $referral_code)->first();
            if(!empty($parent_user)){
                if(($parent_user->total_gv - $reward_data->total_gp) > 0){
                 $parent_user->total_gv = $parent_user->total_gv - $reward_data->total_gp;
                }else{
                    $parent_user->total_gv = 0;
                }
            $parent_user->save();

            $current_user = $parent_user;
            $referral_code = $parent_user->referral_by;
            }
        } while (!empty(User::where('referral_code', $referral_code)->first()));

        UserReward::where('user_id', $user->id)->delete();

        return back()->with('success', 'Reward Achive  Successfully');
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pos;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Rapid;
use App\Models\Leader;
use App\Models\Poiner;
use App\Models\Reward;
use App\Models\Vendor;
use App\Models\Pincode;
use App\Models\Product;
use App\Models\Language;
use App\Models\ContactUs;
use App\Models\OurPujari;
use App\Models\President;
use App\Models\TopAchiver;
use App\Models\UserReward;
use App\Models\UserWallet;
use App\Models\OneDayOrder;
use App\Models\ServiceCity;
use App\Models\UserGbMonth;
use App\Imports\UsersImport;
use App\Models\AchiveReward;
use Illuminate\Http\Request;
use App\Models\BonanzaReward;
use App\Models\TerthPujaCity;
use App\Models\BusinessSetting;
use App\Models\UserBonanzaReward;
use App\Models\SortingSetting;
use Illuminate\Support\Facades\DB;
use App\Models\UserWithdrwalRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{

    public function dashboard(Request $request)
    {
        $month_names = [];
        $month_numbers = [];
        $years = [];
        foreach (range(-8, 0) as $i) {
            $month_name = Carbon::now()->addMonth($i)->format('M-Y');
            $month_number = Carbon::now()->addMonth($i)->format('m');
            $month_year = Carbon::now()->addMonth($i)->format('Y');
            array_push($month_names, $month_name);
            array_push($month_numbers, $month_number);
            array_push($years, $month_year);
        }

        $sales = [];
        $customers = [];

        foreach ($month_numbers as $key => $month_number) {
            $sale = Order::whereMonth('created_at', '=', $month_number)->whereYear('created_at', '=', $years[$key])->get()->sum('grand_total');
            array_push($sales, $sale);

            $customer = User::whereMonth('created_at', '=', $month_number)->whereYear('created_at', '=', $years[$key])->get()->count();
            array_push($customers, $customer);
        }
        $totalSalesCurrentMonthOneDay = OneDayOrder::whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)
        ->sum('grand_total');

    $totalSalesCurrentMonthOrders = Order::whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)
        ->sum('grand_total');

    $totalSalesCurrentMonth = $totalSalesCurrentMonthOneDay + $totalSalesCurrentMonthOrders;

    echo $totalSalesCurrentMonth;

        $currentWeekStart = Carbon::now()->startOfWeek();
        $currentWeekEnd = Carbon::now()->endOfWeek();

        $totalSalesWeekMonth = Order::whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])->sum('grand_total');

        $totalSales = Order::sum('grand_total');

        $dates = [];
        $days = [];
        foreach (range(-6, 0) as $i) {
            $date = Carbon::now()->addDays($i)->format('Y-m-d');
            $day  = Carbon::now()->addDays($i)->format('D');
            array_push($dates, $date);
            array_push($days, $day);
        }
        $week_sale = [];
        foreach ($dates as $date) {
            $weekSale = Order::whereDate('created_at', $date)->sum('grand_total');
            $week_sale[] = $weekSale;
        }
        $today_puja = Product::where('id','>',0)->where('date',date('Y-m-d'))->where('product_type','one_day')->get()->count();

        // e-puja orders
        $thirty_dates = collect();
        for ($i = 29; $i >= 0; $i--) {
            $thirty_dates->push(Carbon::now()->subDays($i)->format('d/m'));
        }
        $One_day_puja_amount = OneDayOrder::where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as created_at'),
                DB::raw('SUM(price) as total_price')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::parse($item->created_at)->format('d/m') => $item->total_price];
            });
        $last_thirty_days_amount = $thirty_dates->mapWithKeys(function ($date) use ($One_day_puja_amount) {
            return [$date => $One_day_puja_amount->get($date, 0)];
        });

        // all Orders
        $thirty_date_puja = collect();
        for ($i = 29; $i >= 0; $i--) {
            $thirty_date_puja->push(Carbon::now()->subDays($i)->format('d/m'));
        }
        $all_puja_amount = Order::where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as created_at'),
                DB::raw('SUM(total_paid) as total_paid_amount')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::parse($item->created_at)->format('d/m') => $item->total_paid_amount];
            });
        $last_thirty_days_puja_amount = $thirty_date_puja->mapWithKeys(function ($date) use ($all_puja_amount) {
            return [$date => $all_puja_amount->get($date, 0)];
        });


        $thirty_dates_customer = collect();
        for ($i = 29; $i >= 0; $i--) {
            $thirty_dates_customer->push(Carbon::now()->subDays($i)->format('d/m'));
        }
        $customer_data = User::where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as created_at'),
                DB::raw('SUM(id) as customer_id')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::parse($item->created_at)->format('d/m') => $item->customer_id];
            });
        $last_thirty_days_customer = $thirty_dates_customer->mapWithKeys(function ($date) use ($customer_data) {
            return [$date => $customer_data->get($date, 0)];
        });


        $thirty_dates_sale = collect();
        for ($i = 29; $i >= 0; $i--) {
            $thirty_dates_sale->push(Carbon::now()->subDays($i)->format('d/m'));
        }
        $sale_data = Order::where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as created_at'),
                DB::raw('SUM(grand_total) as grand_total_id')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::parse($item->created_at)->format('d/m') => $item->grand_total_id];
            });
        $last_thirty_days_sale = $thirty_dates_sale->mapWithKeys(function ($date) use ($sale_data) {
            return [$date => $sale_data->get($date, 0)];
        });
        return view('backend.dashboard', compact('totalSalesCurrentMonth', 'totalSalesWeekMonth', 'totalSales', 'month_names', 'sales', 'customers', 'days', 'week_sale','today_puja', 'last_thirty_days_amount', 'last_thirty_days_puja_amount', 'last_thirty_days_customer', 'last_thirty_days_sale'));
    }

    public function adminLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('backend.auth.login');
    }

    public function attemptLogin(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'email' => 'required|exists:admins',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], !empty($request->remember) ? true : false)) {
                return redirect()->route('admin.dashboard')->with('success', 'You Have Successfully Login!');
            }
            $validator->getMessageBag()->add('password', 'Wrong Password');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin_login')->with('success', 'You Have Successfully Logout!');
    }

    public function change_theme(Request $request)
    {
        $mode =  session()->get('theme_mode');
        if ($mode == 'light-theme') {
            session()->put('theme_mode', 'dark-theme');
        }
        if ($mode == 'dark-theme') {
            session()->put('theme_mode', 'light-theme');
        }
    }

    public function service_city(Request $request)
    {
        $pincodes = ServiceCity::where('id', '>', 0)->orderBy('status','asc');
        if (!empty($request->q)) {
            $pincodes = $pincodes->where('city', 'like', '%' . $request->q);
        }
        $pincodes = $pincodes->paginate(20);
        return view('backend.service_city', compact('pincodes'));
    }

    public function updateServiceCityStatus(Request $request)
    {
        $pincode = ServiceCity::findOrFail($request->id);
        $pincode->status = $request->status;
        if ($pincode->save()) {
            return 1;
        }
        return 0;
    }

    public function serviceCityStore(Request $request)
    {

        if (!empty($request->id)) {
            $id=$request->id;
            $this->validate($request, [
                'city' => 'required|unique:service_cities,id,'.$id,
            ]);

            $pincode = ServiceCity::find($request->id);
        } else {

            $this->validate($request, [
                'city' => 'required|unique:service_cities',
            ]);

            $pincode = new ServiceCity;
        }

        $pincode->city = $request->city;
        $pincode->city_name_hindi = $request->city_name_hindi;
        $pincode->state = $request->state;
        $pincode->state_name_hindi = $request->state_name_hindi;

        if (!empty($request->image)) {
            $file = $request->file('image');
            $pincode->image = upload_file($request,'image');
        }

        $pincode->save();

        return redirect()->route('admin.service_city');
    }

    public function editServiceCity(Request $request, $id)
    {
        $pincode = ServiceCity::find($id);
        $pincodes = ServiceCity::where('id', '>', 0);
        if (!empty($request->q)) {
            $pincodes = $pincodes->where('city', 'like', '%' . $request->q);
        }
        $pincodes = $pincodes->paginate(20);
        return view('backend.service_city', compact('pincode', 'pincodes'));
    }

    public function deleteServiceCity($id)
    {
        $pincode = ServiceCity::destroy($id);
        return back();
    }


    public function terth_city(Request $request)
    {
        $pincodes = TerthPujaCity::where('id', '>', 0);
        if (!empty($request->q)) {
            $pincodes = $pincodes->where('city', 'like', '%' . $request->q);
        }
        $pincodes = $pincodes->paginate(20);
        return view('backend.terth_city', compact('pincodes'));
    }

    public function updateTerthCityStatus(Request $request)
    {
        $pincode = TerthPujaCity::findOrFail($request->id);
        $pincode->status = $request->status;
        if ($pincode->save()) {
            return 1;
        }
        return 0;
    }

    public function terthCityStore(Request $request)
    {

        if (!empty($request->id)) {
            $id=$request->id;
            $this->validate($request, [
                'city' => 'required|unique:terth_puja_cities,id,'.$id,
            ]);

            $pincode = TerthPujaCity::find($request->id);
        } else {

            $this->validate($request, [
                'city' => 'required|unique:terth_puja_cities',
            ]);

            $pincode = new TerthPujaCity;
        }

        $pincode->city = $request->city;
        $pincode->city_hindi = $request->city_hindi;
        $pincode->state = $request->state;

        if (!empty($request->image)) {
            $file = $request->file('image');
            $pincode->image = upload_file($request,'image');
        }

        $pincode->save();

        return redirect()->route('admin.terth_city');
    }

    public function editTerthCity(Request $request, $id)
    {
        $pincode = TerthPujaCity::find($id);
        $pincodes = TerthPujaCity::where('id', '>', 0);
        if (!empty($request->q)) {
            $pincodes = $pincodes->where('city', 'like', '%' . $request->q);
        }
        $pincodes = $pincodes->paginate(20);
        return view('backend.terth_city', compact('pincode', 'pincodes'));
    }

    public function deleteTerthCity($id)
    {
        $pincode = TerthPujaCity::destroy($id);
        return back();
    }





    public function pincode_list(Request $request)
    {
        $pincodes = ServiceCity::where('status', 'active')->where('pincode', 'like', $request->key . '%')->groupBy('pincode')->get();

        $data = array();

        foreach ($pincodes as $pincode) {
            $data[] = array("id" => $pincode->pincode, "area" => $pincode->area,"pincode" => $pincode->pincode);
        }

        return json_encode($data);
    }

    public function city_list(Request $request)
    {
        $cities = ServiceCity::where('status', 'active')->where('city', 'like', $request->key . '%')->get();

        $data = array();

        foreach ($cities as $city) {
            $data[] = array("id" => $city->id, "text" => $city->city);
        }

        return json_encode($data);
    }

    public function get_pincode(Request $request)
    {
        $pincode = Pincode::where('status', 'active')->where('pincode', $request->pincode)->first();
        return $pincode;
    }

    public function setting()
    {
        return view('backend.setting');
    }

    public function setting_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $business_settings = BusinessSetting::where('type', $type)->first();
            if ($business_settings != null) {
                if (gettype($request[$type]) == 'array') {
                    $business_settings->value = json_encode($request[$type]);
                } else {
                    $business_settings->value = $request[$type];
                }
                $business_settings->save();
            } else {
                $business_settings = new BusinessSetting;
                $business_settings->type = $type;
                if (gettype($request[$type]) == 'array') {
                    $business_settings->value = json_encode($request[$type]);
                } else {
                    $business_settings->value = $request[$type];
                }
                $business_settings->save();
            }
        }
        return back();
    }


    public function contact_us(Request $request)
    {
        $contacts = ContactUs::all();
        return view('backend.contact_us', compact('contacts'));
    }

    public function language(Request $request)
    {
        $languages = Language::where('id', '>', 0);
        if (!empty($request->q)) {
            $languages = $languages->where('language', 'like', '%' . $request->q);
        }
        $languages = $languages->paginate(20);
        return view('backend.language', compact('languages'));
    }

    public function updateLanguageStatus(Request $request)
    {
        $language = Language::findOrFail($request->id);
        $language->status = $request->status;
        if ($language->save()) {
            return 1;
        }
        return 0;
    }

    public function languageStore(Request $request)
    {

        if (!empty($request->id)) {
            $id=$request->id;
            $this->validate($request, [
                'language' => 'required|unique:languages,id,'.$id,
            ]);

            $language = Language::find($request->id);
        } else {

            $this->validate($request, [
                'language' => 'required|unique:languages',
            ]);

            $language = new Language;
        }

        $language->language = $request->language;

        $language->save();

        return redirect()->route('admin.language');
    }

    public function editLanguage(Request $request, $id)
    {
        $language = Language::find($id);
        $languages = Language::where('id', '>', 0);
        if (!empty($request->q)) {
            $language = $language->where('language', 'like', '%' . $request->q);
        }
        $languages = $languages->paginate(20);
        return view('backend.language', compact('language', 'languages'));
    }

    public function deleteLanguage($id)
    {
        $language = Language::destroy($id);
        return back();
    }


    public function pincode(Request $request)
    {
        $selectedCity = $request->city_id;
        $selectedState = $request->state_id;
        $query = $request->q;
        $cities = ServiceCity::all();
        $pincodes = Pincode::query();
        $uniqueStates = $cities->unique('state');  // Ensures only unique states

        if (!empty($selectedCity)) {
            $pincodes->where('city_id', $selectedCity);
        }

        if (!empty($query)) {
            $pincodes->where('pincode', 'like', '%' . $query . '%'); // Filter by search term
        }

        $pincodes = $pincodes->paginate(20);
        return view('backend.pincode', compact('pincodes', 'cities', 'selectedCity', 'uniqueStates', 'selectedState'));
    }

    public function updatePincodeStatus(Request $request)
    {
        $pincode = Pincode::findOrFail($request->id);
        $pincode->status = $request->status;
        if ($pincode->save()) {
            return 1;
        }
        return 0;
    }

    public function pincodeStore(Request $request)
    {
        $request->all();
        $id = $request->id;

        $rules = [
            'pincode' => 'required|unique:pincodes,pincode,' . $id,
            'city' => 'required|exists:service_cities,id',
            'state' => 'required',
        ];

        $this->validate($request, $rules);
        $pincode = $id ? Pincode::findOrFail($id) : new Pincode;
        $pincode->pincode = $request->pincode;
        $pincode->city = $request->city;
        $pincode->state = $request->state;
        $pincode->save();
        return redirect()->route('admin.pincode')->with('success', 'Pincode saved successfully!');
    }

    public function editPincode(Request $request, $id)
    {
        $pincode = Pincode::find($id);

        if (!$pincode) {
            return redirect()->route('admin.pincode')->with('error', 'Pincode not found!');
        }

        $selectedCity = $pincode->city;
        $selectedState = $pincode->state;

        $cities = ServiceCity::all();
        $uniqueStates = ServiceCity::distinct('state')->get(['state']);

        $pincodes = Pincode::query();
        if (!empty($request->q)) {
            $pincodes->where('pincode', 'like', '%' . $request->q);
        }
        $pincodes = $pincodes->paginate(20);
        return view('backend.pincode', compact('pincode', 'pincodes', 'cities', 'uniqueStates', 'selectedCity', 'selectedState'));
    }

    public function deletePincode($id)
    {
        $pincode = Pincode::destroy($id);
        return back();
    }

    public function getCities(Request $request)
    {
        return $cities = ServiceCity::where('state', $request->state_id)->where('status', 'active')->get();

        return response()->json($cities);
    }

    public function getPincode(Request $request)
    {
        $city = ServiceCity::where('id', $request->city_id)->first();
        return $pincodes = Pincode::where('city',$city->city)->where('status', 'active')->get();
        return response()->json($pincodes);
    }

    public function password_update(Request $request)
    {

        $user = Admin::find(Auth::guard('admin')->user()->id);
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->back();
    }


    public function updateSortingSetting(Request $request)
    {
        $request->validate([
            'model' => 'required|string',
            'sort_column' => 'required|in:name,name_hindi',
            'sort_direction' => 'required|in:asc,desc',
        ]);
    
        SortingSetting::updateSetting($request->model, $request->sort_column, $request->sort_direction);
    
        return back()->with('success', 'Sorting settings updated!');
    }

    public function showSortingSettings()
    {
        $columns = Schema::getColumnListing((new Product)->getTable());
        $setting = SortingSetting::getSettingFor('Product');
        return view('admin.sorting-settings', compact('columns','setting'));
    }

    
}

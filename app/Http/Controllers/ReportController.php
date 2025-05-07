<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pos;
use App\Models\User;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\UserKyc;
use App\Models\UserGbMonth;
use App\Models\GenialIncome;
use Illuminate\Http\Request;
use App\Models\UserWithdrwalRequest;
use App\Models\VendorPaymentHistroy;

class ReportController extends Controller
{
    public function vendor_recharge_report(Request $request)
    {

        return view('backend.report.vendor_recharge_report');
    }

    public function get_vendor_recharge_report(Request $request)
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


        $dateRange = explode('-', $request->get('daterange'));

        if (!empty($request->get('daterange'))) {
            $start_date = Carbon::parse($dateRange[0])->toDateString();
            $end_date = Carbon::parse($dateRange[1])->toDateString();
        }


        $users = VendorPaymentHistroy::where('id', '>', 0)->where('description', 'Payment for registration fees')->with('vendor');
        $total = $users->count();

        $totalFilter = VendorPaymentHistroy::where('id', '>', 0)->where('description', 'Payment for registration fees')->with('vendor');
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->whereHas('vendor', function($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%');
            });
        }
        $totalFilter = $totalFilter->count();


        $arrData = VendorPaymentHistroy::where('id', '>', 0)->where('description', 'Payment for registration fees')->with('vendor');
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->whereHas('vendor', function($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%');
            });
        }
        if (!empty($request->get('daterange'))) {
            $arrData = $arrData->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
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

    public function vendor_rechargeReport(Request $request)
    {
        return view('backend.report.vendor_rechargeReport');
    }

    public function get_vendor_rechargeReport(Request $request)
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

        $searchByVendor = $request->get('searchVendor');
        $searchByPaymentType = $request->get('paymentType');

        $dateRange = explode('-', $request->get('daterange'));

        if (!empty($request->get('daterange'))) {
            $start_date = Carbon::parse($dateRange[0])->toDateString();
            $end_date = Carbon::parse($dateRange[1])->toDateString();
        }


        $users = VendorPaymentHistroy::where('id', '>', 0)->where('description','!=','Payment for registration fees')->with('vendor');
        $total = $users->count();

        $totalFilter = VendorPaymentHistroy::where('id', '>', 0)->where('description','!=','Payment for registration fees')->with('vendor');
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('name', 'like', '%' . $searchValue . '%');
        }

        if (!empty($searchByVendor)) {
            $totalFilter = $totalFilter->where('vendor_id', $searchByVendor);
        }

        if (!empty($searchByPaymentType)) {
            $totalFilter = $totalFilter->where('transaction_type', $searchByPaymentType);
        }

        $totalFilter = $totalFilter->count();


        $arrData = VendorPaymentHistroy::where('id', '>', 0)->where('description','!=','Payment for registration fees')->with('vendor');
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($request->get('daterange'))) {
            $arrData = $arrData->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
        }

        if (!empty($searchByVendor)) {
            $arrData = $arrData->where('vendor_id', $searchByVendor);
        }

        if (!empty($searchByPaymentType)) {
            $arrData = $arrData->where('transaction_type', $searchByPaymentType);
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

    public function customer_recharge_report(Request $request)
    {

        return view('backend.report.customer_recharge_report');
    }

    public function get_customer_recharge_report(Request $request)
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


        $dateRange = explode('-', $request->get('daterange'));

        if (!empty($request->get('daterange'))) {
            $start_date = Carbon::parse($dateRange[0])->toDateString();
            $end_date = Carbon::parse($dateRange[1])->toDateString();
        }


        $users = User::where('status', 1);
        $total = $users->count();

        $totalFilter = User::where('status', 1);
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('name', 'like', '%' . $searchValue . '%');
        }
        if (!empty($request->get('daterange'))) {
            $totalFilter = $totalFilter->where('active_date', '>=', $start_date)->where('active_date', '<=', $end_date);
        }
        $totalFilter = $totalFilter->count();


        $arrData = User::where('status', 1);;
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('name', 'like', '%' . $searchValue . '%');
        }
        if (!empty($request->get('daterange'))) {
            $arrData = $arrData->where('active_date', '>=', $start_date)->where('active_date', '<=', $end_date);
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

    public function tds_report(Request $request)
    {

        return view('backend.report.tds_report');
    }

    public function get_tds_report(Request $request)
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


        $dateRange = explode('-', $request->get('daterange'));

        if (!empty($request->get('daterange'))) {
            $start_date = Carbon::parse($dateRange[0])->toDateString();
            $end_date = Carbon::parse($dateRange[1])->toDateString();
        }

        $users = UserWithdrwalRequest::where('id', '>', 1)->with('user');
        $total = $users->count();

        $totalFilter = UserWithdrwalRequest::where('id', '>', 1)->with('user');
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('name', 'like', '%' . $searchValue . '%');
        }

        if (!empty($request->get('daterange'))) {
            $totalFilter = $totalFilter->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
        }

        $totalFilter = $totalFilter->count();


        $arrData = UserWithdrwalRequest::where('id', '>', 1)->with('user');
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($request->get('daterange'))) {
            $arrData = $arrData->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
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

    public function genial_t_report(Request $request)
    {

        return view('backend.report.genial_t_report');
    }

    public function get_genial_t_report(Request $request)
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

        $dateRange = explode('-', $request->get('daterange'));

        if (!empty($request->get('daterange'))) {
            $start_date = Carbon::parse($dateRange[0])->toDateString();
            $end_date = Carbon::parse($dateRange[1])->toDateString();
        }
        $users = UserWithdrwalRequest::where('id', '>', 1)->with('user');
        $total = $users->count();

        $totalFilter = UserWithdrwalRequest::where('id', '>', 1)->with('user');
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->whereHas('user', function($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%');
            });

        }

        if (!empty($request->get('daterange'))) {
            $totalFilter = $totalFilter->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
        }

        $totalFilter = $totalFilter->count();


        $arrData = UserWithdrwalRequest::where('id', '>', 1)->with('user');
        if (!empty($searchValue)) {
            $arrData = $arrData->whereHas('user', function($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%');
            });

        }
        if (!empty($request->get('daterange'))) {
            $arrData = $arrData->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
        }
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);



        $arrData = $arrData->get();

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        );

        return response()->json($response);
    }

    public function customer_report(Request $request)
    {
        return view('backend.report.customer_report');
    }
    public function get_customer_report(Request $request)
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

        $searchByStatus = $request->get('searchStatus');
        $searchBankStatus = $request->get('searchBankStatus');
        $dateRange = explode('-', $request->get('daterange'));

        if (!empty($request->get('daterange'))) {
            $start_date = Carbon::parse($dateRange[0])->toDateString();
            $end_date = Carbon::parse($dateRange[1])->toDateString();
        }


        $users = User::where('id', '>', 0);
        $total = $users->count();

        $totalFilter = User::where('id', '>', 0);
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('name', 'like', '%' . $searchValue . '%');
        }
        if (!empty($searchByStatus)) {
            $searchStatus = $searchByStatus == 'paid' ? 1 : 0;
            $totalFilter = $totalFilter->where('status', $searchStatus);
        }
        if (!empty($searchBankStatus)) {
            if ($searchBankStatus == 1) {
                $user_ids = UserKyc::whereNotNull('account_number')->whereNotNull('account_holder_name')->whereNotNull('ifsc_code')->whereNotNull('bank_name')->get()->pluck('user_id');
                $totalFilter = $totalFilter->whereIn('id', $user_ids->toArray());
            }
            if ($searchBankStatus == 0) {
                $user_ids = UserKyc::whereNull('account_number')->whereNull('account_holder_name')->whereNull('ifsc_code')->whereNull('bank_name')->get()->pluck('user_id');
                $totalFilter = $totalFilter->whereIn('id', $user_ids->toArray());
            }
        }

        if (!empty($request->get('daterange'))) {
            $totalFilter = $totalFilter->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
        }

        $totalFilter = $totalFilter->count();


        $arrData = User::where('id', '>', 0);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('name', 'like', '%' . $searchValue . '%')->orwhere('phone', 'like', '%' . $searchValue . '%')->orwhere('email', 'like', '%' . $searchValue . '%')->orwhere('referral_code', 'like', '%' . $searchValue . '%')->orwhere('designation', 'like', '%' . str_replace(' ', '_', $searchValue) . '%');
        }
        if ($searchValue == 'Prime' || $searchValue == 'prime') {
            $arrData = $arrData->orwhere('prime', 'like', '%' . ($searchValue == 'prime' ? 1 : '') . '%');
        }
        if (!empty($searchByStatus)) {
            $searchStatus = $searchByStatus == 'paid' ? 1 : 0;
            $arrData = $arrData->where('status', $searchStatus);
        }
        if (!empty($searchBankStatus)) {
            if ($searchBankStatus == 1) {
                $user_ids = UserKyc::whereNotNull('account_number')->whereNotNull('account_holder_name')->whereNotNull('ifsc_code')->whereNotNull('bank_name')->get()->pluck('user_id');
                $arrData = $arrData->whereIn('id', $user_ids->toArray());
            }
            if ($searchBankStatus == 0) {
                $user_ids = UserKyc::whereNull('account_number')->whereNull('account_holder_name')->whereNull('ifsc_code')->whereNull('bank_name')->get()->pluck('user_id');
                $arrData = $arrData->whereIn('id', $user_ids->toArray());
            }
        }
        if (!empty($request->get('daterange'))) {
            $arrData = $arrData->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
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

    public function vendor_report(Request $request)
    {
        $vendors = Vendor::all();
        return view('backend.report.vendor_report', compact('vendors'));
    }
    public function get_vendor_report(Request $request)
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
        $searchByStatus = $request->get('searchStatus');
        $dateRange = explode('-', $request->get('daterange'));

        if (!empty($request->get('daterange'))) {
            $start_date = Carbon::parse($dateRange[0])->toDateString();
            $end_date = Carbon::parse($dateRange[1])->toDateString();
        }

        $users = Vendor::where('id', '>', 0);
        $total = $users->count();

        $totalFilter = Vendor::where('id', '>', 0);
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('name', 'like', '%' . $searchValue . '%');
        }
        if (!empty($searchByStatus)) {
            $searchStatus = $searchByStatus == 'paid' ? 1 : 0;
            $totalFilter = $totalFilter->where('status', $searchStatus);
        }
        if (!empty($request->get('daterange'))) {
            $totalFilter = $totalFilter->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
        }
        $totalFilter = $totalFilter->count();


        $arrData = Vendor::where('id', '>', 0);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('name', 'like', '%' . $searchValue . '%')->orwhere('phone', 'like', '%' . $searchValue . '%')->orwhere('email', 'like', '%' . $searchValue . '%')->orwhere('vendor_code', 'like', '%' . $searchValue . '%');
        }
        if (!empty($searchByStatus)) {
            $searchStatus = $searchByStatus == 'paid' ? 1 : 0;
            $arrData = $arrData->where('status', $searchStatus);
        }
        if (!empty($request->get('daterange'))) {
            $arrData = $arrData->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
        }

        $arrData = $arrData->get();

        foreach($arrData as $data){
            $order_sale=Order::where('vendor_id',$data->id)->get()->sum('grand_total');
            $pos_sale=Pos::where('vendor_id',$data->id)->get()->sum('grand_total');
            $data->order_sale=$order_sale;
            $data->pos_sale=$pos_sale;
        }


        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        );

        return response()->json($response);
    }

    public function vendor_report_detail(Request $request,$id)
    {
        $vendor = Vendor::find($id);
        return view('backend.report.vendor_report_detail', compact('vendor'));
    }


    public function gp_report(Request $request)
    {
        return view('backend.report.gp_report');
    }
    public function get_gp_report(Request $request)
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
        $dateRange = explode('-', $request->get('daterange'));

        if (!empty($request->get('daterange'))) {
            $start_date = Carbon::parse($dateRange[0])->toDateString();
            $end_date = Carbon::parse($dateRange[1])->toDateString();
        }

        $users = UserGbMonth::where('id', '>', 0)->with('user');
        $total = $users->count();

        $totalFilter = UserGbMonth::where('id', '>', 0)->with('user');
        if (!empty($searchValue)) {
            $user_id = User::where('name', 'like', '%' . $searchValue . '%')->orwhere('phone', 'like', '%' . $searchValue . '%')->orwhere('email', 'like', '%' . $searchValue . '%')->get()->pluck('id');
            $totalFilter = $totalFilter->whereIn('user_id',$user_id );
        }
        if (!empty($searchByStatus)) {
            $searchStatus = $searchByStatus == 'paid' ? 1 : 0;
            $totalFilter = $totalFilter->where('status', $searchStatus);
        }
        if (!empty($request->get('daterange'))) {
            $totalFilter = $totalFilter->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
        }
        $totalFilter = $totalFilter->count();


        $arrData = UserGbMonth::where('id', '>', 0)->with('user');
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $user_id = User::where('name', 'like', '%' . $searchValue . '%')->orwhere('phone', 'like', '%' . $searchValue . '%')->orwhere('email', 'like', '%' . $searchValue . '%')->get()->pluck('id');
            $arrData=$arrData->whereIn('user_id',$user_id);
        }
        if (!empty($searchByStatus)) {
            $searchStatus = $searchByStatus == 'paid' ? 1 : 0;
            $arrData = $arrData->where('status', $searchStatus);
        }
        if (!empty($request->get('daterange'))) {
            $arrData = $arrData->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
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
    public function genial_income_report(Request $request)
    {
        return view('backend.report.genial_income_report');
    }
    public function get_genial_income_report(Request $request)
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
        $dateRange = explode('-', $request->get('daterange'));

        if (!empty($request->get('daterange'))) {
            $start_date = Carbon::parse($dateRange[0])->toDateString();
            $end_date = Carbon::parse($dateRange[1])->toDateString();
        }

        $users = GenialIncome::where('id', '>', 0)->with(['user','vendor']);
        $total = $users->count();

        $totalFilter = GenialIncome::where('id', '>', 0)->with(['user','vendor']);
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->whereHas('user', function($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%');
            });
        }
        if (!empty($searchByStatus)) {
            $searchStatus = $searchByStatus == 'paid' ? 1 : 0;
            $totalFilter = $totalFilter->where('status', $searchStatus);
        }
        if (!empty($request->get('daterange'))) {
            $totalFilter = $totalFilter->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
        }
        $totalFilter = $totalFilter->count();


        $arrData = GenialIncome::where('id', '>', 0)->with(['user','vendor']);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->whereHas('user', function($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%')->orwhere('phone', 'like', '%' . $searchValue . '%')->orwhere('email', 'like', '%' . $searchValue . '%');
            });
        }
        if (!empty($searchByStatus)) {
            $searchStatus = $searchByStatus == 'paid' ? 1 : 0;
            $arrData = $arrData->where('status', $searchStatus);
        }
        if (!empty($request->get('daterange'))) {
            $arrData = $arrData->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
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

    public function credit_sale_report(Request $request)
    {
        return view('backend.report.credit_sale_report');
    }

}

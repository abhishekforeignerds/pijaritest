<?php

namespace App\Http\Controllers;

use App\Models\DeliveryBoy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DeliveryBoyController extends Controller
{
    public function index(){
        $delivery_boy = DeliveryBoy::where('status','1')->paginate(16);
        return view('backend.delivery_boy.index', compact('delivery_boy'));
    }

    public function get_delivery_boy(Request $request) {

        $draw 				= 		$request->get('draw'); // Internal use
        $start 				= 		$request->get("start"); // where to start next records for pagination
        $rowPerPage 		= 		$request->get("length"); // How many recods needed per page for pagination

        $orderArray 	   = 		$request->get('order');
        $columnNameArray 	= 		$request->get('columns'); // It will give us columns array

        $searchArray 		= 		$request->get('search');
        $columnIndex 		= 		$orderArray[0]['column'];  // This will let us know,
                                                            // which column index should be sorted
                                                            // 0 = id, 1 = name, 2 = email , 3 = created_at

        $columnName 		= 		$columnNameArray[$columnIndex]['data']; // Here we will get column name,
                                                                        // Base on the index we get

        $columnSortOrder 	= 		$orderArray[0]['dir']; // This will get us order direction(ASC/DESC)
        $searchValue 		= 		$searchArray['value']; // This is search value


        $users = DeliveryBoy::where('id','>',0);
        $total = $users->count();

        $totalFilter = DeliveryBoy::where('id','>',0);
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('name','like','%'.$searchValue.'%');
        }
        $totalFilter = $totalFilter->count();


        $arrData = DeliveryBoy::where('id','>',0);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName,$columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('name','like','%'.$searchValue.'%');
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

    public function create(){
        return view('backend.delivery_boy.create');
    }

    public function store(Request $request) {
        request()->validate([
            'name' => 'required|string|max:50',
            'phone' =>'required|digits:10|unique:delivery_boys,phone',
            'email' => 'nullable|email',
            'address' => 'required',
            'password' =>'required',
            'aadhaar_front' => 'required|mimes:png,jpg,jpeg',
            'aadhaar_back' => 'required|mimes:png,jpg,jpeg',
            'pan' => 'nullable|mimes:png,jpg,jpeg',
        ]);

        $delivery_boy = new DeliveryBoy;
        $delivery_boy->name = $request->name;
        $delivery_boy->phone = $request->phone;
        $delivery_boy->email = $request->email;
        $delivery_boy->password = Hash::make($request->password);
        $delivery_boy->address = $request->address;
        if (!empty($request->aadhaar_front)) {
            $file = $request->file('aadhaar_front');
            $delivery_boy->aadhaar_front = upload_file($request,'aadhaar_front');
        }
        if (!empty($request->aadhaar_back)) {
            $file = $request->file('aadhaar_back');
            $delivery_boy->aadhaar_back = upload_file($request,'aadhaar_back');
        }
        if (!empty($request->pan)) {
            $file = $request->file('pan');
            $delivery_boy->pan = upload_file($request,'pan');
        }
        $delivery_boy->bank_name = $request->bank_name;
        $delivery_boy->bank_account_no = $request->bank_account_no;
        $delivery_boy->ifsc_code = $request->ifsc_code;
        $delivery_boy->save();
        return redirect()->route('delivery-boy.index')->with('success', 'Delivery Boy added successfully');
    }

    public function edit($id){
        $delivery_boy = DeliveryBoy::find($id);
        return view('backend.delivery_boy.edit', compact('delivery_boy'));
    }

    public function update(Request $request,$id) {
        request()->validate([
            'name' => 'required|string|max:50',
            'phone' =>'nullable|digits:10|unique:delivery_boys,id,'.$id,
            'email' => 'nullable|email',
            'address' => 'required',
            'aadhaar_front' => 'mimes:png,jpg,jpeg',
            'aadhaar_back' => 'mimes:png,jpg,jpeg',
            'pan' => 'mimes:png,jpg,jpeg',
        ]);
        $delivery_boy=DeliveryBoy::find($id);
        $delivery_boy->name = $request->name;
        $delivery_boy->phone = $request->phone;
        $delivery_boy->email = $request->email;
        if($request->password){
            $delivery_boy->password = Hash::make($request->password);
        }
        $delivery_boy->address = $request->address;
        if (!empty($request->aadhaar_front)) {
            $file = $request->file('aadhaar_front');
            $delivery_boy->aadhaar_front = upload_file($request,'aadhaar_front');
        }
        if (!empty($request->aadhaar_back)) {
            $file = $request->file('aadhaar_back');
            $delivery_boy->aadhaar_back = upload_file($request,'aadhaar_back');
        }
        if (!empty($request->pan)) {
            $file = $request->file('pan');
            $delivery_boy->pan = upload_file($request,'pan');
        }
        $delivery_boy->bank_name = $request->bank_name;
        $delivery_boy->bank_account_no = $request->bank_account_no;
        $delivery_boy->ifsc_code = $request->ifsc_code;
        $delivery_boy->save();
        return redirect()->route('delivery-boy.index')->with('success', 'Delivery Boy updated successfully');
    }

    public function updateDeliveryBoyStatus(Request $request){
        $update = DeliveryBoy::findOrFail($request->id);
        $update->status = $request->status;
        if($update->save()){
            return 1;
        }
        return 0;
    }

    public function destroy(DeliveryBoy $deliveryboy){
        $deliveryboy->delete();
        return back()->with('error', 'Delivery Boy deleted successfully');
    }
}

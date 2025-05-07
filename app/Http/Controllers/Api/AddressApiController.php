<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class AddressApiController extends Controller
{
    public function addAddress(Request $request){
        request()->validate([
            'name'    => 'required',
            'phone'   => 'required|digits:10',
            'address' => 'required',
            'state'   => 'required',
            'city'    => 'required',
            'pincode' => 'required',
            'area'   => 'required'
        ]);
        $address = new Address;
        $address->user_id = auth()->user()->id;
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->pincode = $request->pincode;
        $address->landmark = $request->landmark;
        $address->area = $request->area;
        $address->save();

        if(auth()->user()->name=='User'){
            $user=User::find(auth()->user()->id);
            $user->name= $request->name;
            $user->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Address added successfully',
        ], 200);
    }

    public function getAddress(){
        $user_id = auth()->id();
        $get_address = Address::where('user_id', $user_id)->get();

        return response()->json([
            'success' => true,
            'message' => 'User Address',
            'data'    => $get_address
        ], 200);
    }

    public function editAddress(Request $request){
        $edit = Address::find($request->id);

        return response()->json([
            'success' => true,
            'message' => 'Edit User Address',
            'data'    => $edit
        ], 200);
    }

    public function updateAddress(Request $request){
        request()->validate([
            'name'    => 'required',
            'phone'   => 'required|digits:10',
            'address' => 'required',
            'state'   => 'required',
            'city'    => 'required',
            'pincode' => 'required'
        ]);
        $address = Address::find($request->id);
        $address->user_id = auth()->user()->id;
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->pincode = $request->pincode;
        $address->landmark = $request->landmark;
        $address->area = $request->area;
        $address->save();

        return response()->json([
            'success' => true,
            'message' => 'Address update successfully'
        ], 200);
    }

    public function deleteAddress($id) {
        Address::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully'
        ], 200);
    }
}

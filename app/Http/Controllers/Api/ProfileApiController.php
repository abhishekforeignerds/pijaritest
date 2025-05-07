<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileApiController extends Controller
{
    public function profile(){
        $profile = auth()->user();
        $profile->profile_photo=uploaded_asset($profile->profile_picture);
        return response()->json([
            'success' => true,
            'message' => 'Profile Information',
            'data'    => $profile
        ], 200);
    }

    public function updateProfile(Request $request){
        request()->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,id,'.auth()->user()->id,
            'profile_picture' => 'nullable|mimes:jpg,png,jpeg'
        ]);
        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->profile_picture)) {
            $file = $request->file('profile_picture');
            $user->profile_picture = upload_file($request,'profile_picture');
        }
        $user->save();
        $user->profile_photo=uploaded_asset($user->profile_picture);
        return response()->json([
            'success' => true,
            'message' => 'Profile Update Successfully',
            'data'    => $user
        ], 200);
    }
}

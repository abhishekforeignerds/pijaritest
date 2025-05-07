<?php

namespace App\Http\Controllers\Api;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Craftsys\Msg91\Facade\Msg91;

class AuthApiController extends Controller
{
    public function sendOtp(Request $request){
        request()->validate([
            'phone' => 'required|digits:10'
        ]);



        $otp = rand(1111,9999);
        $user_otp = new Otp;
        $user_otp->phone = $request->phone;
        $user_otp->otp = $otp;
        $user_otp->save();


        Msg91::sms()->to('91'.$request->phone)->flow('64a6b9d1d6fc057c15503ab2')->variable('business_name', 'Daily Pooja Mala')->variable('otp', $otp)->send();
        return response()->json([
            'status' => true,
            'message' => 'Otp Sent Successfully',
            'data' => []
        ],200);
    }

    public function verifyOtp(Request $request){
        request()->validate([
            'name' => 'nullable',
            'email' => 'nullable',
            'password' => 'nullable',
            'phone' => 'required',
            'otp' => 'required'
        ]);
        $check_otp = Otp::where('phone', $request->phone)->latest()->first();
        if ($check_otp->otp == $request->otp) {
            Otp::where('phone', $request->phone)->first()->delete();
            $user = User::where('phone', $request->phone)->first();
            if ($user) {
                return response()->json([
                    'status' => true,
                    'token' => $user->createToken('auth_token')->plainTextToken,
                    'message'=>'User Login Successfully!',
                ],200);
            }
            else {
                $new_user = new User;
                $new_user->name = 'User';
                $new_user->phone = $request->phone;
                $new_user->save();
                return response()->json([
                    'status' => true,
                    'token' => $new_user->createToken('auth_token')->plainTextToken,
                    'message'=>'User Register Successfully!',
                ],200);
            }
        }
        else {
            return response()->json([
                "status" => false,
                "message" => "Incorrect OTP"
            ], 404);
        }
    }

    public function logout(Request $request){
        if (Auth::check()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'success' => true,
                'message' => 'User Logged Out Successfully',
            ], 200);
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'User is not authenticated',
            ], 401);
        }
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class IsVerifiedPujari
{
    public function handle($request, Closure $next)
    {
         if ($request->expectsJson() && Auth::guard('pujari')->check() && Auth::guard('pujari')->user()->verified==0) {

            $response = [
            'status' => 401,
            'message' => 'You are Unverified',
             ];

            return response()->json($response, 401);

          }else{

        if (Auth::guard('pujari')->check() && Auth::guard('pujari')->user()->verified==0) {
            return redirect()->route('pujari.profile')->with('error', 'You Are Unverified!');
          }
        }

        return $next($request);
    }
}

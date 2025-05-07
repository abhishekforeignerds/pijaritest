<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class IsUnbanned
{
    public function handle($request, Closure $next)
    {
         if ($request->expectsJson() && Auth::guard('vendor')->check() && Auth::guard('vendor')->user()->ban==0) {

            $response = [
            'status' => 401,
            'message' => 'You are banned',
             ];

            return response()->json($response, 401);

          }else{

        if (Auth::guard('vendor')->check() && Auth::guard('vendor')->user()->ban==0) {

            Auth::guard('vendor')->logout();
            return redirect()->route('vendor_login')->with('error', 'You Are Ban!');

          }
        }

        return $next($request);
    }
}

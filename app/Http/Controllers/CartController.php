<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Package;
use App\Models\Product;    
use App\Models\Service;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function addToCart(Request $request)
    {
        //–– determine user_id (logged‑in vs guest) exactly as before
        if (Auth::check()) {
            $user_id = Auth::id();
        } else {
            $guest = Session::get('guest_id');
            if ($guest) {
                $user_id = $guest;
            } else {
                $user_id = 'guest_' . time() . rand(1,100);
                Session::put('guest_id', $user_id);
            }
        }
    
        //–– clear old cart & insert new
        Cart::where('user_id', $user_id)->delete();
        Cart::updateOrCreate(
            ['user_id' => $user_id],
            [
                'product_id' => $request->product_id,
                'package_id' => $request->package_id,
                'inclusion'  => $request->inclusion ? json_encode($request->inclusion) : '[]',
            ]
        );
    
        //–– fetch for count & for building items
        $carts = Cart::where('user_id', $user_id)->get();
        $cart_total_item = $carts->count();
    
        //–– compute the new “items” + “totals”
        $subtotal = 0;
        $totalAdvance = 0;
    
        $items = $carts->map(function($cart) use (&$subtotal, &$totalAdvance) {
            $pkg = $cart->package;
            $incIds = json_decode($cart->inclusion, true) ?: [];
    
            // build inclusion‑array
            $inclusions = collect($incIds)->map(function($incId) use (&$totalAdvance) {
                $inc = \App\Models\Inclusion::find($incId);
                if (!$inc) return null;
                $totalAdvance += (int)$inc->advance;
                return [
                    'name'        => $inc->inclusion,
                    'name_hindi'  => $inc->inclusion_hindi,
                    'price'       => (int)$inc->price,
                    'advance'     => (int)$inc->advance,
                ];
            })->filter()->values()->all();
    
            // package advance + price
            $totalAdvance += (int)$pkg->advance;
            $rowTotal = (int)$pkg->discount_price + collect($inclusions)->sum('price');
            $subtotal += $rowTotal;
    
            return [
                'package_name'       => $pkg->package_name,
                'package_name_hindi' => $pkg->package_name_hindi,
                'discount_price'     => (int)$pkg->discount_price,
                'advance'            => (int)$pkg->advance,
                'inclusions'         => $inclusions,
            ];
        })->all();
    
        $remaining   = $subtotal - $totalAdvance;
        $grandTotal  = $subtotal;
    
        $totals = [
            'subtotal'    => $subtotal,
            'advance'     => $totalAdvance,
            'remaining'   => $remaining,
            'grand_total' => $grandTotal,
        ];
    
        //–– your existing package_list / order_summary logic untouched
        $product  = Product::find($request->product_id);
        $packages = Package::where('product_id', $product->id)->get();
    
        if ($product->product_type == 'one_day') {
            $package_list   = [];
            $order_summary  = view('frontend.e-package_order_summary',   ['product'=>$product,'packages'=>$packages])->render();
        } else {
            $package_list   = view('frontend.package_list',            ['product'=>$product,'packages'=>$packages])->render();
            $order_summary  = view('frontend.package_order_summary',    ['product'=>$product,'packages'=>$packages])->render();
        }
    
        //–– RETURN all five keys
        return response()->json([
            'package_list'     => $package_list,
            'order_summary'    => $order_summary,
            'cart_total_item'  => $cart_total_item,
            // newly added:
            'items'            => $items,
            'totals'           => $totals,
        ]);
    }
    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cart = Cart::find($request->id);
        $cart->delete();


        return [
            'cart_details' => view('frontend.cart_details')->render(),
            'cart_summary' => view('frontend.cart_summary')->render(),
            'count' => Cart::where('user_id', Auth::user()->id)->get()->count()
        ];
    }
}

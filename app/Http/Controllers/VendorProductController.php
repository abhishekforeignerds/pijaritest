<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\File;

class VendorProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('vendor_id',Auth::guard('vendor')->user()->id)->get();
        return view('vendor_dashboard.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('vendor_dashboard.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $input=$request->all();

        $product = new Product;
        $product->name = $request->name;
        $product->vendor_id = Auth::guard('vendor')->user()->id;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->tag = $request->tag;

        $product->photos = $request->photos;
        $product->description = $request->description;

        if($product->save()){
            foreach($request->mrp as $key=>$value){
                $product_stock=new ProductStock;
                $product_stock->product_id=$product->id;
                $product_stock->vendor_id = Auth::guard('vendor')->user()->id;
                $product_stock->price=(float) filter_var( $input['sell_price'][$key], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
                $product_stock->mrp=(float) filter_var( $value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
                $product_stock->quantity=$input['qty'][$key];
                $product_stock->color=$input['color'][$key];
                $product_stock->s_w=$input['s_w'][$key];
                $product_stock->category_id = $request->category_id;
                $product_stock->subcategory_id = $request->subcategory_id;
                $product_stock->status=1;

                if (!empty($input['thumbnail'][$key])) {
                    $file = $input['thumbnail'][$key];
                    $product_stock->thumbnail = upload_single_file($file);
                }
                $product_stock->save();
            }
        }

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('vendor_dashboard.product.view', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {

        // return $product->getMedia('photos');
        return view('vendor_dashboard.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
       // dd($request->all());
        $input=$request->all();

        $product = Product::find($request->product_id);;
        $product->name = $request->name;
        $product->vendor_id = Auth::guard('vendor')->user()->id;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->tag = $request->tag;
        $product->photos = $request->photos;
        $product->description = $request->description;
        $product->save();

        $product_stock_ids=ProductStock::where('product_id',$product->id)->get();
        foreach($product_stock_ids as $product_stock_id){
              if(!in_array($product_stock_id->id,$request->product_stock_id)){
                  $product_stock_id->delete();
              }
        }


        if(isset($request->product_stock_id)){
          if(count($request->product_stock_id) > 0 ){

             foreach($request->product_stock_id as $key=>$value){

                $product_stock=ProductStock::find($value);
                $product_stock->vendor_id = Auth::guard('vendor')->user()->id;
                $product_stock->price=(float) filter_var( $input['sell_price_old'][$key], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
                $product_stock->mrp=(float) filter_var( $input['mrp_old'][$key], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
                $product_stock->quantity=$input['qty_old'][$key];
                $product_stock->color=$input['color_old'][$key];
                $product_stock->s_w=$input['s_w_old'][$key];
                $product_stock->category_id = $request->category_id;
                $product_stock->subcategory_id = $request->subcategory_id;
                if (!empty($input['thumbnail_old'][$key])) {
                    $file = $input['thumbnail_old'][$key];
                    $product_stock->thumbnail = upload_single_file($file);
                }
                $product_stock->save();

            }
          }
        }

        if(isset($request->mrp)){
          if(count($request->mrp)>0){
            foreach($request->mrp as $key=>$value){
                $product_stock=new ProductStock;
                $product_stock->product_id=$product->id;
                $product_stock->vendor_id = Auth::guard('vendor')->user()->id;
                $product_stock->price=(float) filter_var( $input['sell_price'][$key], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
                $product_stock->mrp=(float) filter_var( $value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
                $product_stock->quantity=$input['qty'][$key];
                $product_stock->color=$input['color'][$key];
                $product_stock->s_w=$input['s_w'][$key];
                $product_stock->category_id = $request->category_id;
                $product_stock->subcategory_id = $request->subcategory_id;

                if (!empty($input['thumbnail'][$key])) {
                    $file = $input['thumbnail'][$key];
                    $product_stock->thumbnail = upload_single_file($file);
                }
                $product_stock->status=1;
                $product_stock->save();
            }
          }
        }


        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
    public function updateFeatured(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->featured = $request->status;
        if ($product->save()) {
            return 1;
        }
        return 0;
    }

    public function updateStatus(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->status = $request->status;
        if ($product->save()) {
            return 1;
        }
        return 0;
    }

    public function storeMedia(Request $request)
    {
        $file = $request->file('file');
        $upload_id=upload_file($request,'file');

        return response()->json([
            'name'          => $upload_id,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }


}

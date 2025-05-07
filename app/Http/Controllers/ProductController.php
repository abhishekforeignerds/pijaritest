<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Product;
use App\Models\Inclusion;
use App\Models\ServiceCity;
use Illuminate\Support\Str;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\TerthPujaCity;
use App\Models\ProductDatePrice;
use Spatie\MediaLibrary\MediaCollections\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.product.index');
    }

    public function get_product(Request $request) {

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

        ## Custom Field value
        $searchByPoojaType = $request->get('searchByPoojaType');
        $locationType = $request->get('locationType');
        $city = $request->get('city');
        $category = $request->get('category');

        $users = Product::where('id','>',0);
        $total = $users->count();

        $totalFilter = Product::where('id','>',0)->where('product_type','all');
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('name','like','%'.$searchValue.'%');
        }
        if (!empty($searchByPoojaType)) {
            $totalFilter = $totalFilter->where('product_type', $searchByPoojaType);
        }
        if (!empty($city)) {
            $totalFilter = $totalFilter->whereJsonContains('city', $city);
        }
        if (!empty($locationType)) {
            $totalFilter = $totalFilter->where('location_type', $locationType);
        }
        if (!empty($category)) {
            $totalFilter = $totalFilter->where('category_id', $category);
        }

        $totalFilter = $totalFilter->count();


        $arrData = Product::where('id','>',0)->where('product_type','all')->with(['category']);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName,$columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('name','like','%'.$searchValue.'%');
        }

        if (!empty($searchByPoojaType)) {
            $arrData = $arrData->where('product_type', $searchByPoojaType);
        }

        if (!empty($city)) {
            $arrData = $arrData->whereJsonContains('city',''.$city);
        }

        if (!empty($locationType)) {
            $arrData = $arrData->where('location_type',''.$locationType);
        }
        if (!empty($category)) {
            $arrData = $arrData->where('category_id', $category);
        }

        $arrData = $arrData->get()->map(function ($pujari) {
            // Decode the city_ids JSON
            $cityIds = json_decode($pujari->city, true);

            // Fetch city names for these IDs
            $cityNames = TerthPujaCity::whereIn('id', $cityIds)->pluck('city')->toArray();

            // Add city names to the pujari data
            $pujari->city_names = implode(', ', $cityNames);

            return $pujari;
        });;

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        );

        return response()->json($response);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product.create');
    }

    public function package_add($id){
        $product=Product::find($id);
        return view('backend.product.package_add',compact('product'));
    }

    public function product_package($id){
        $list=Package::where('product_id',$id)->get();
        return view('backend.product.view_package',compact('list','id'));
    }

    public function product_package_edit($id){
        $data=Package::find($id);
        $product=Product::find($data->product_id);
        return view('backend.product.package_edit',compact('data','product'));
    }


    public function package_update(Request $request){

        $input=$request->all();

        $package=new Package;
        $package->product_id=$request->product_id;
        $package->package_name=$request->package_name;
        $package->package_name_hindi=$request->package_name_hindi;
        $package->price=$request->price;
        $package->discount_price=$request->discount_price;
        $package->advance=$request->advance;
        $package->no_of_people=$request->no_of_people;
        $package->description=$request->description;
        $package->description_hindi=$request->description_hindi;
        $package->save();

        if(!empty($request->inclusion)){
            foreach($request->inclusion as $key=>$data){

                $inclusion=new Inclusion;
                $inclusion->inclusion=$data;
                $inclusion->inclusion_hindi=$input['inclusion_hindi'][$key];
                $inclusion->package_id=$package->id;
                $inclusion->price=$input['inclusion_price'][$key];
                $inclusion->advance=$input['inclusion_advance'][$key];
                $inclusion->save();

            }
        }

        return redirect()->route('admin_product.index');


    }

    public function admin_product_package_update(Request $request){

            $input = $request->all();

            $package=Package::find($request->package_id);
            $package->package_name=$request->package_name;
            $package->package_name_hindi=$request->package_name_hindi;
            $package->price=$request->price;
            $package->discount_price=$request->discount_price;
            $package->advance=$request->advance;
            $package->no_of_people=$request->no_of_people;
            $package->description=$request->description;
            $package->description_hindi=$request->description_hindi;
            $package->save();

            $inclusions=Inclusion::where('package_id',$request->package_id)->get();
            foreach($inclusions as $inclusion_data){
                if(!in_array($inclusion_data->id,$request->inclusion_id)){
                    $inclusion_data->delete();
                }
            }

            if(isset($request->inclusion_id)){
                if(count($request->inclusion_id) > 0 ){

                   foreach($request->inclusion_id as $key=>$value){
                        $inclusion=Inclusion::find($value);
                        $inclusion->inclusion=$input['inclusion_old'][$key];
                        $inclusion->inclusion_hindi=$input['inclusion_old_hindi'][$key];
                        $inclusion->price=$input['inclusion_price_old'][$key];
                        $inclusion->advance=$input['inclusion_advance_old'][$key];
                        $inclusion->save();
                   }
                }
            }

            if(!empty($request->inclusion)){
            foreach($request->inclusion as $key=>$data){

                $inclusion=new Inclusion;
                $inclusion->inclusion=$data;
                $inclusion->inclusion_hindi=$input['inclusion_hindi'][$key];
                $inclusion->package_id=$package->id;
                $inclusion->price=$input['inclusion_price'][$key];
                $inclusion->advance=$input['inclusion_advance'][$key];
                $inclusion->save();

            }
        }

            return redirect()->route('admin_product_package',$package->product_id);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->all());
        $input=$request->all();

        $product = new Product;
        $product->name = $request->name;
        $product->name_hindi = $request->name_hindi;
        $product->category_id = $request->category_id;
        $product->tag = $request->tag;
        $product->short_description = $request->short_description;
        $product->location_type = $request->location_type;
        $product->description = $request->description;
        $product->product_type = 'all';
        $product->date = $request->date;
        $product->meta_title = $request->meta_title;
        $product->meta_keywords = $request->meta_keywords;
        $product->meta_description = $request->meta_description;
        if(!empty($request->city)){
            $product->city = json_encode($request->city);
        }
        if(!empty($request->pincode)){
          $product->pincode = json_encode($request->pincode);
        }
        if(!empty($request->language)){
          $product->language = json_encode($request->language);
        }
        $product->slug=strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5));
        $product->faq = $request->faq;
        $product->promise = $request->promise;
        $product->key_insight = $request->key_insight;

        $product->short_description_hindi = $request->short_description_hindi;
        $product->key_insight_hindi = $request->key_insight_hindi;
        $product->promise_hindi = $request->promise_hindi;
        $product->faq_hindi = $request->faq_hindi;
        $product->description_hindi = $request->description_hindi;


        if(!empty($request->thumbnail)){
            $file = $input['thumbnail'];
            $product->thumbnail = upload_single_file($file);
        }
        $product->save();

        return redirect()->route('admin_product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return $product->getMedia('photos');
        $product=Product::find($id);
        return view('backend.product.edit', compact('product'));
    }
    public function view($id)
    {
        // return $product->getMedia('photos');
        $product=Product::find($id);
        return view('backend.product.view', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // dd($request->all());
        $input=$request->all();

        $product=Product::find($id);
        $product->name = $request->name;
        $product->name_hindi = $request->name_hindi;
        $product->category_id = $request->category_id;
        $product->tag = $request->tag;
        $product->short_description = $request->short_description;
        $product->location_type = $request->location_type;
        $product->product_type = 'all';
        $product->date = $request->date;
        $product->description = $request->description;
        $product->meta_title = $request->meta_title;
        $product->meta_keywords = $request->meta_keywords;
        $product->meta_description = $request->meta_description;
        if(!empty($request->city)){
            $product->city = json_encode($request->city);
        }
        if(!empty($request->pincode)){
          $product->pincode = json_encode($request->pincode);
        }
        if(!empty($request->language)){
          $product->language = json_encode($request->language);
        }
        $product->faq = $request->faq;
        $product->promise = $request->promise;
        $product->key_insight = $request->key_insight;


        $product->short_description_hindi = $request->short_description_hindi;
        $product->key_insight_hindi = $request->key_insight_hindi;
        $product->promise_hindi = $request->promise_hindi;
        $product->faq_hindi = $request->faq_hindi;
        $product->description_hindi = $request->description_hindi;

        if(!empty($request->thumbnail)){
            $file = $input['thumbnail'];
            $product->thumbnail = upload_single_file($file);
        }
        $product->save();
        return redirect()->route('admin_product.index');
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

    public function updateUpcoming(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->upcoming = $request->status;
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

    public function product_package_delete($id){

        $package=Package::find($id);
        $product_id=$package->product_id;
        $inclusion=Inclusion::where('package_id',$package->id)->delete();
        $package->delete();

        return redirect()->route('admin_product_package',$product_id);
    }
}

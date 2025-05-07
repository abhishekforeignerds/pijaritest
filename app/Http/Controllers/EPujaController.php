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

class EPujaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.e-puja.index');
    }

    public function e_puja_upcoming()
    {
        return view('backend.e-puja.upcoming');
    }

    public function e_puja_completed()
    {
        return view('backend.e-puja.completed');
    }

    public function get_product(Request $request)
    {
        $draw 			 = $request->get('draw');
        $start 			 = $request->get("start");
        $rowPerPage 	 = $request->get("length");
        $orderArray 	 = $request->get('order');
        $columnNameArray = $request->get('columns');
        $searchArray     = $request->get('search');
        $columnIndex     = $orderArray[0]['column'];
        $columnName 	 = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $searchValue 	 = $searchArray['value'];

        ## Custom Field value
        $searchByPoojaType = $request->get('searchByPoojaType');
        $locationType = $request->get('locationType');
        $city = $request->get('city');
        $category = $request->get('category');

        $users = Product::where('id','>',0);
        $total = $users->count();

        $totalFilter = Product::where('id','>',0)->where('date',date('Y-m-d'))->where('product_type','one_day');
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


        $arrData = Product::where('id','>',0)->where('date',date('Y-m-d'))->where('product_type','one_day')->with(['category']);
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

    public function get_upcoming(Request $request)
    {
        $draw 			 = $request->get('draw');
        $start 			 = $request->get("start");
        $rowPerPage 	 = $request->get("length");
        $orderArray 	 = $request->get('order');
        $columnNameArray = $request->get('columns');
        $searchArray     = $request->get('search');
        $columnIndex     = $orderArray[0]['column'];
        $columnName 	 = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $searchValue 	 = $searchArray['value'];

        ## Custom Field value
        $searchByPoojaType = $request->get('searchByPoojaType');
        $locationType = $request->get('locationType');
        $city = $request->get('city');
        $category = $request->get('category');

        $users = Product::where('id','>',0);
        $total = $users->count();

        $totalFilter = Product::where('id','>',0)->where('date', '>', date('Y-m-d'))->where('product_type','one_day');
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


        $arrData = Product::where('id','>',0)->where('date', '>', date('Y-m-d'))->where('product_type','one_day')->with(['category']);
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

    public function get_completed(Request $request)
    {
        $draw 			 = $request->get('draw');
        $start 			 = $request->get("start");
        $rowPerPage 	 = $request->get("length");
        $orderArray 	 = $request->get('order');
        $columnNameArray = $request->get('columns');
        $searchArray     = $request->get('search');
        $columnIndex     = $orderArray[0]['column'];
        $columnName 	 = $columnNameArray[$columnIndex]['data'];
        $columnSortOrder = $orderArray[0]['dir'];
        $searchValue 	 = $searchArray['value'];

        ## Custom Field value
        $searchByPoojaType = $request->get('searchByPoojaType');
        $locationType = $request->get('locationType');
        $city = $request->get('city');
        $category = $request->get('category');

        $users = Product::where('id','>',0);
        $total = $users->count();

        $totalFilter = Product::where('id','>',0)->where('date', '<', date('Y-m-d'))->where('product_type','one_day');
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


        $arrData = Product::where('id','>',0)->where('date', '<', date('Y-m-d'))->where('product_type','one_day')->with(['category']);
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
        return view('backend.e-puja.create');
    }
    public function package_add($id){
        $product=Product::find($id);
        return view('backend.e-puja.package_add',compact('product'));
    }

    public function product_package($id){
        $list=Package::where('product_id',$id)->get();
        return view('backend.e-puja.view_package',compact('list','id'));
    }

    public function product_package_edit($id){
        $data=Package::find($id);
        $product=Product::find($data->product_id);
        return view('backend.e-puja.package_edit',compact('data','product'));
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
        if(!empty($request->image)){
            $file = $input['image'];
            $package->image = upload_single_file($file);
        }
        $package->save();
        return redirect()->route('e_puja.index');
    }

    public function product_package_update(Request $request)
    {
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
        if(!empty($request->image)){
            $file = $input['image'];
            $package->image = upload_single_file($file);
        }
        $package->save();
        return redirect()->route('e_puja_package',$package->product_id);
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
        $product->prashad = $request->prashad;
        $product->prashad_text = $request->prashad_text;
        $product->prashad_text_hindi = $request->prashad_text_hindi;
        $product->short_description = $request->short_description;
        $product->location_type = $request->location_type;
        $product->description = $request->description;
        $product->product_type = 'one_day';
        $product->start_date = $request->start_date;
        $product->fake_devote = $request->fake_devote;
        $product->tithi = $request->tithi;
        $product->tithi_hindi = $request->tithi_hindi;
        $product->date = $request->date;
        $product->meta_title = $request->meta_title;
        $product->meta_keywords = $request->meta_keywords;
        $product->meta_description = $request->meta_description;
        $product->photos = $request->photos;
        $product->prashad_price = $request->prashad_price;
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
        // $product->promise = $request->promise;
        // $product->promise_hindi = $request->promise_hindi;
        // $product->key_insight = $request->key_insight;
        // $product->key_insight_hindi = $request->key_insight_hindi;
        $product->short_description_hindi = $request->short_description_hindi;
        $product->faq_hindi = $request->faq_hindi;
        $product->description_hindi = $request->description_hindi;


        if(!empty($request->thumbnail)){
            $file = $input['thumbnail'];
            $product->thumbnail = upload_single_file($file);
        }
        $product->save();

        return redirect($request->previous_url);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         // return $product->getMedia('photos');
         $product=Product::find($id);
         return view('backend.e-puja.edit', compact('product'));
    }
    public function view($id)
    {
        // return $product->getMedia('photos');
        $product=Product::find($id);
        return view('backend.e-puja.view_package', compact('product'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

          $input=$request->all();

          $product=Product::find($id);
          $product->name = $request->name;
          $product->name_hindi = $request->name_hindi;
          $product->category_id = $request->category_id;
          $product->tag = $request->tag;
          $product->prashad = $request->prashad;
          $product->prashad_text = $request->prashad_text;
          $product->prashad_text_hindi = $request->prashad_text_hindi;
          $product->short_description = $request->short_description;
          $product->location_type = $request->location_type;
          $product->product_type ='one_day';
          $product->fake_devote = $request->fake_devote;
          $product->tithi = $request->tithi;
          $product->tithi_hindi = $request->tithi_hindi;
          $product->start_date = $request->start_date;
          $product->date = $request->date;
          $product->description = $request->description;
          $product->meta_title = $request->meta_title;
          $product->meta_keywords = $request->meta_keywords;
          $product->meta_description = $request->meta_description;
          $product->photos = $request->photos;
          $product->prashad_price = $request->prashad_price;
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
          $product->short_description_hindi = $request->short_description_hindi;
        //   $product->promise = $request->promise;
        //   $product->key_insight = $request->key_insight;
        //   $product->key_insight_hindi = $request->key_insight_hindi;
        //   $product->promise_hindi = $request->promise_hindi;
          $product->faq_hindi = $request->faq_hindi;
          $product->description_hindi = $request->description_hindi;

          if(!empty($request->thumbnail)){
              $file = $input['thumbnail'];
              $product->thumbnail = upload_single_file($file);
          }
          $product->save();

          return redirect($request->previous_url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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

        return redirect()->route('e_puja_package',$product_id);
    }

    public function e_puja_inclusion(Request $request,$id){
        $product=Product::find($id);
        $inclusions = Inclusion::where('product_id', $id)->get();
        $inclusion=Inclusion::find($request->edit_id);
        return view('backend.e-puja.inclusion',compact('product', 'inclusions','inclusion'));
    }

    public function e_puja_inclusion_add(Request $request)
    {
        $input=$request->all();
        if($request->inclusion_id){
            $data = Inclusion::find($request->inclusion_id);
        }else{
            $data = new Inclusion;
        }
        $data->product_id = $request->product_id;
        $data->inclusion = $request->inclusion;
        $data->inclusion_hindi = $request->inclusion_hindi;
        $data->description_english = $request->description_english;
        $data->description_hindi = $request->description_hindi;
        $data->price = $request->price;
        $data->advance = $request->advance;
        if(!empty($request->image)){
            $file = $input['image'];
            $data->image = upload_single_file($file);
        }
        $data->save();
        return redirect()->route('e_puja.inclusion', request()->product_id);
    }
}

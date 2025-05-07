<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        return view('backend.brand.index');
    }

    public function get_brand(Request $request) {

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


        $users = Brand::where('id','>',0);
        $total = $users->count();

        $totalFilter = Brand::where('id','>',0);
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('name','like','%'.$searchValue.'%');
        }
        $totalFilter = $totalFilter->count();


        $arrData = Brand::where('id','>',0);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName,$columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('name','like','%'.$searchValue.'%');
        }

        $arrData = $arrData->get();

        foreach($arrData as $data){
            $data->product_count=count($data->product);
        }


        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        );

        return response()->json($response);
    }

    public function create()
    {
        return view('backend.brand.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!empty($request->id)){
            $brand =Brand::find($request->id);
        }else{
          $brand = new Brand;
        }
        $brand->name=$request->name;
        if (!empty($request->icon)) {
            $file = $request->file('icon');
            $brand->icon = upload_file($request,'icon');
        }
        $brand->short_description = $request->short_description;
        $brand->description = $request->description;
        $brand->meta_title = $request->meta_title;
        $brand->meta_keywords = $request->meta_keywords;
        $brand->meta_description = $request->meta_description;
        $brand->slug=strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5));
        $brand->save();
        return redirect()->route('brand.index');
    }


    public function show()
    {
        //
    }


    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('backend.brand.add',compact('brand'));
    }
    public function view($id)
    {
        $brand = Brand::find($id);
        return view('backend.brand.view',compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }

    public function updateFeatured(Request $request)
    {
        $brand = Brand::findOrFail($request->id);
        $brand->featured = $request->status;
        if($brand->save()){
            return 1;
        }
        return 0;
    }

    public function updateStatus(Request $request)
    {
        $brand = Brand::findOrFail($request->id);
        $brand->status = $request->status;
        if($brand->save()){
            return 1;
        }
        return 0;
    }
}

<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Models\BusinessCategory;

class BusinessCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.business_category.index');
    }

    public function get_business(Request $request) {

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


        $users = BusinessCategory::where('id','>',0);
        $total = $users->count();

        $totalFilter = BusinessCategory::where('id','>',0);
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('name','like','%'.$searchValue.'%');
        }
        $totalFilter = $totalFilter->count();


        $arrData = BusinessCategory::where('id','>',0);
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName,$columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('name','like','%'.$searchValue.'%');
        }

        $arrData = $arrData->get();
        foreach($arrData as $data){
            $data->vendor_count = count(Vendor::whereJsonContains('business_category',''.$data->id)->get());
        }

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
        return view('backend.business_category.add');
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
            $business_categories =BusinessCategory::find($request->id);
        }else{
          $business_categories = new BusinessCategory;
        }
        $business_categories->name=$request->name;
        $business_categories->product_min_comission=$request->product_min_comission;
        $business_categories->product_min_comission_type=$request->product_min_comission_type;
        $business_categories->service_min_comission_type=$request->service_min_comission_type;
        $business_categories->service_min_comission=$request->service_min_comission;
        $business_categories->keyword=$request->keyword;
        if (!empty($request->icon)) {
            $file = $request->file('icon');
            $business_categories->icon  = upload_single_file($file);
        }
        $business_categories->save();
        return redirect()->route('business-category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BusinessCategory  $businessCategory
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessCategory $businessCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BusinessCategory  $businessCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $businessCategory=BusinessCategory::find($id);
        return view('backend.business_category.add',compact('businessCategory'));
    }

    public function view($id)
    {
        $businessCategory=BusinessCategory::find($id);
        return view('backend.business_category.view',compact('businessCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BusinessCategory  $businessCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessCategory $businessCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BusinessCategory  $businessCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessCategory $businessCategory)
    {
        //
    }

    public function updateFeatured(Request $request)
    {
        $business_category = BusinessCategory::findOrFail($request->id);
        $business_category->featured = $request->status;
        if($business_category->save()){
            return 1;
        }
        return 0;
    }

    public function updateStatus(Request $request)
    {
        $business_category = BusinessCategory::findOrFail($request->id);
        $business_category->status = $request->status;
        if($business_category->save()){
            return 1;
        }
        return 0;
    }
}

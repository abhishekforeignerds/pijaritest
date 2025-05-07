<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;

class ServiceSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.service_subcategory.index');
    }

    public function get_service_subcategory(Request $request) {

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


        $users = ServiceSubCategory::where('id','>',0);
        $total = $users->count();

        $totalFilter = ServiceSubCategory::where('id','>',0);
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('name','like','%'.$searchValue.'%');
        }
        $totalFilter = $totalFilter->count();


        $arrData = ServiceSubCategory::where('id','>',0)->with('category');
        $arrData = $arrData->skip($start)->take($rowPerPage);
        $arrData = $arrData->orderBy($columnName,$columnSortOrder);

        if (!empty($searchValue)) {
            $arrData = $arrData->where('name','like','%'.$searchValue.'%');
        }

        $arrData = $arrData->get();

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
        return view('backend.service_subcategory.add');
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
            $subcategories =ServiceSubCategory::find($request->id);
        }else{
          $subcategories = new ServiceSubCategory;
        }
        $subcategories->name=$request->name;
        $subcategories->category_id=$request->category_id;
        if (!empty($request->icon)) {
            $file = $request->file('icon');
            $subcategories->icon = upload_file($request,'icon');
        }
        $subcategories->save();
        return redirect()->route('service_subcategory.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceSubCategory  $serviceSubCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceSubCategory $serviceSubCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceSubCategory  $serviceSubCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subCategory=ServiceSubCategory::find($id);
        return view('backend.service_subcategory.add',compact('subCategory'));
    }
    public function view($id)
    {
        $subCategory=ServiceSubCategory::find($id);
        return view('backend.service_subcategory.view',compact('subCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceSubCategory  $serviceSubCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceSubCategory $serviceSubCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceSubCategory  $serviceSubCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceSubCategory $serviceSubCategory)
    {
        //
    }

    public function updateFeatured(Request $request)
    {
        $subcategory = ServiceSubCategory::findOrFail($request->id);
        $subcategory->featured = $request->status;
        if($subcategory->save()){
            return 1;
        }
        return 0;
    }

    public function updateStatus(Request $request)
    {
        $subcategory = ServiceSubCategory::findOrFail($request->id);
        $subcategory->status = $request->status;
        if($subcategory->save()){
            return 1;
        }
        return 0;
    }


    public function get_service_sub_category_by_category(Request $request){
        $subcategories = ServiceSubCategory::where('category_id',$request->category_id)->get();
        return $subcategories;
    }
}

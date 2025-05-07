<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.subcategory.index');
    }

    public function get_subcategory(Request $request) {

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


        $users = SubCategory::where('id','>',0);
        $total = $users->count();

        $totalFilter = SubCategory::where('id','>',0);
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('name','like','%'.$searchValue.'%');
        }
        $totalFilter = $totalFilter->count();


        $arrData = SubCategory::where('id','>',0)->with('category');
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
        return view('backend.subcategory.add');
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
            $subcategories =SubCategory::find($request->id);
        }else{
          $subcategories = new SubCategory;
        }
        $subcategories->name=$request->name;
        $subcategories->category_id=$request->category_id;
        if (!empty($request->icon)) {
            $file = $request->file('icon');
            $subcategories->icon = upload_file($request,'icon');
        }
        $subcategories->short_description = $request->short_description;
        $subcategories->description = $request->description;
        $subcategories->meta_title = $request->meta_title;
        $subcategories->meta_keywords = $request->meta_keywords;
        $subcategories->meta_description = $request->meta_description;
        $subcategories->slug=strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5));
        $subcategories->save();
        return redirect()->route('subcategory.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subCategory=SubCategory::find($id);
        return view('backend.subcategory.add',compact('subCategory'));
    }

    public function view($id)
    {
        $subCategory=SubCategory::find($id);
        return view('backend.subcategory.view',compact('subCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {
        //
    }

    public function updateFeatured(Request $request)
    {
        $subcategory = SubCategory::findOrFail($request->id);
        $subcategory->featured = $request->status;
        if($subcategory->save()){
            return 1;
        }
        return 0;
    }

    public function updateStatus(Request $request)
    {
        $subcategory = SubCategory::findOrFail($request->id);
        $subcategory->status = $request->status;
        if($subcategory->save()){
            return 1;
        }
        return 0;
    }


    public function get_sub_category_by_category(Request $request){
        $subcategories = SubCategory::where('category_id',$request->category_id)->get();
        return $subcategories;
    }

}

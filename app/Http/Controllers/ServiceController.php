<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.service.index');
    }

    public function get_service(Request $request) {

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


        $users = Service::where('id','>',0);
        $total = $users->count();

        $totalFilter = Service::where('id','>',0);
        if (!empty($searchValue)) {
            $totalFilter = $totalFilter->where('name','like','%'.$searchValue.'%');
        }
        $totalFilter = $totalFilter->count();


        $arrData = Service::where('id','>',0)->with('vendor');
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

        return view('backend.service.create');
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
        $service = new Service;
        $service->name = $request->name;
        $service->vendor_id = $request->vendor_id;
        $service->category_id = $request->category_id;
        $service->subcategory_id = $request->subcategory_id;
        $service->mrp = $request->mrp;
        $service->price = $request->price;
        $service->tag = $request->tag;
        if (!empty($request->thumbnail)) {
            $file = $request->file('thumbnail');
            $service->thumbnail = upload_single_file($file);
        }
        $service->photos = $request->photos;
        $service->description = $request->description;
        $service->save();

        return redirect()->route('admin_service.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $service=Service::find($id);
        // return $service->getMedia('photos');
        return view('backend.service.edit', compact('service'));
    }

    public function view($id)
    {
       $service=Service::find($id);
        // return $service->getMedia('photos');
        return view('backend.service.view', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //dd($request->all());
        $service=Service::find($id);
        $service->name = $request->name;
        $service->vendor_id = $request->vendor_id;
        $service->category_id = $request->category_id;
        $service->subcategory_id = $request->subcategory_id;
        $service->mrp = $request->mrp;
        $service->price = $request->price;
        $service->tag = $request->tag;
        if (!empty($request->thumbnail)) {
            $file = $request->file('thumbnail');
            $service->thumbnail = upload_single_file($file);
        }
        $service->photos = $request->photos;
        $service->description = $request->description;
        $service->save();

        return redirect()->route('admin_service.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(service $service)
    {
        //
    }
    public function updateFeatured(Request $request)
    {
        $service = Service::findOrFail($request->id);
        $service->featured = $request->status;
        if ($service->save()) {
            return 1;
        }
        return 0;
    }

    public function updateStatus(Request $request)
    {
        $service = Service::findOrFail($request->id);
        $service->status = $request->status;
        if ($service->save()) {
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

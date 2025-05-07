<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::where('vendor_id',Auth::guard('vendor')->user()->id)->get();
        return view('vendor_dashboard.service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('vendor_dashboard.service.create');
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
        $service = new Service;
        $service->name = $request->name;
        $service->vendor_id = Auth::guard('vendor')->user()->id;
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

        return redirect()->route('service.index');
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
        return view('vendor_dashboard.service.view', compact('service'));
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
        return view('vendor_dashboard.service.edit', compact('service'));
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
        $service=Service::find($id);
        $service->name = $request->name;
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

        return redirect()->route('service.index');
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

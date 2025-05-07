<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\TempleDetails;

class TempleDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $temple_list =TempleDetails::get();
        return view('backend.temple-details.index', compact('temple_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $product_data = Product::where('product_type', 'one_day')->where('id',$id)->get();
        $temple_list =TempleDetails::where('product_id',$id)->get();
        return view('backend.temple-details.create', compact('product_data', 'temple_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id'  => 'required|integer|unique:temple_details,product_id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'required|image|max:2048',
        ]);
        $data = new TempleDetails;
        $data->product_id = $request->product_id;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->title_hindi = $request->title_hindi;
        $data->description_hindi = $request->description_hindi;
        if (!empty($request->image)) {
            $file = $request->file('image');
            $data->image = upload_file($request,'image');
        }
        $data->save();
        return redirect()->back()->with('success', 'Data inserted successfully.');
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
        $data = TempleDetails::find($id);
        $product_data = Product::where('product_type', 'one_day')->where('id',$data->product_id)->get();
        $temple_list =TempleDetails::where('product_id',$id)->get();
        return view('backend.temple-details.create',compact('data', 'product_data','temple_list'));
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
        $request->validate([
            'product_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);
        $data = TempleDetails::find($id);
    if (!$data) {
        return back()->withErrors(['error' => 'Record not found']);
    }
    $data->product_id = $request->product_id;
    $data->title = $request->title;
    $data->description = $request->description;
    $data->title_hindi = $request->title_hindi;
    $data->description_hindi = $request->description_hindi;
    if ($request->hasFile('image')) {
        $data->image = upload_file($request, 'image');
    }

    $data->save();
        return redirect()->back()->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = TempleDetails::find($id);
        $data->delete();

        return redirect()->route('temple-details.index')->with('success', 'Temple details deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PujaBenifit;
use Illuminate\Http\Request;

class PujaBenifitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $puja_benifit =PujaBenifit::get();
        return view('backend.puja-benifits.index', compact('puja_benifit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $puja_benifit =PujaBenifit::where('product_id',$id)->get();
        $product_data = Product::where('product_type', 'one_day')->where('id',$id)->get();
        return view('backend.puja-benifits.create', compact('product_data','puja_benifit'));
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
            'product_id'  => 'required|integer',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $data = new PujaBenifit;
        $data->product_id = $request->product_id;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->title_hindi = $request->title_hindi;
        $data->description_hindi = $request->description_hindi;
        $data->save();
        return redirect()->route('puja_benifit_create',$request->product_id);

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
        $data = PujaBenifit::find($id);
        $product_data = Product::where('product_type', 'one_day')->where('id',$data->product_id)->get();
        $puja_benifit =PujaBenifit::where('product_id',$id)->get();
        return view('backend.puja-benifits.create',compact('data', 'product_data','puja_benifit'));
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
        ]);
        $data = PujaBenifit::find($id);
        if (!$data) {
            return back()->withErrors(['error' => 'Record not found']);
        }
        $data->product_id = $request->product_id;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->title_hindi = $request->title_hindi;
        $data->description_hindi = $request->description_hindi;
        $data->save();
        return redirect()->route('puja_benifit_create',$request->product_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pujaBenefit = PujaBenifit::find($id);
        $pujaBenefit->delete();

        return redirect()->back()->with('success', 'Puja Benefit deleted successfully.');
    }
}

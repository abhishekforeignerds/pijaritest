<?php

namespace App\Http\Controllers;

use App\Models\OurPujari;
use Illuminate\Http\Request;

class OurPujariController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pujari_list = OurPujari::get();
        return view('backend.our_pujari.index', compact('pujari_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.our_pujari.create');
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
            'name'   => 'required|string|max:255',
            'city'   => 'required|string',
            'exp'    => 'required|string',
            'image'  => 'required|image|max:2048',
        ]);
        $data = new OurPujari;
        $data->name = $request->name;
        $data->name_hindi = $request->name_hindi;
        $data->city = $request->city;
        $data->city_hindi = $request->city_hindi;
        $data->exp = $request->exp;
        if (!empty($request->image)) {
            $file = $request->file('image');
            $data->image = upload_file($request,'image');
        }
        $data->save();
        return redirect()->route('our_pujari.index');
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
        $data = OurPujari::find($id);
        return view('backend.our_pujari.create',compact('data'));
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
            'image'  => 'nullable|image|max:2048',
        ]);
        $data = OurPujari::find($id);
    if (!$data) {
        return back()->withErrors(['error' => 'Record not found']);
    }
        $data->name = $request->name;
        $data->name_hindi = $request->name_hindi;
        $data->city = $request->city;
        $data->city_hindi = $request->city_hindi;
        $data->exp = $request->exp;
    if ($request->hasFile('image')) {
        $data->image = upload_file($request, 'image');
    }

    $data->save();
        return redirect()->route('our_pujari.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = OurPujari::find($id);
        $data->delete();
        return redirect()->route('our_pujari.index')->with('success', 'Pujari Data deleted successfully.');
    }
}

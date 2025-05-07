<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gallery=Gallery::where('delete_status',0)->get();
        return view('backend.gallery.index', compact('gallery'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.gallery.add_gallery');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gallery = new Gallery;
        $gallery->title = $request->title;
        if($request->image != null){
            $file_photo = time().'.'.request()->image->getClientOriginalExtension();
            $request->image->move(public_path('gallery'), $file_photo);
            $src= "public/gallery/".$file_photo;
			//compress($src, $src, 500);
            $gallery->image = $file_photo;
        }
        $gallery->save();
        return redirect()-> route('gallery.index')->with('success','Gallery Inserted Succesfull');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        return view('backend.gallery.edit_gallery', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
         //return $gallery;
         $gallery->title = $request->title;
         if($request->image != null){
             $file_photo = time().'.'.request()->image->getClientOriginalExtension();
             $request->image->move(public_path('gallery'), $file_photo);
             $src= "public/gallery/".$file_photo;
             //compress($src, $src, 500);
             $gallery->image = $file_photo;
         }
         $gallery->save();
         return redirect()-> route('gallery.index')->with('success','Gallery Updated Succesfull');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete_status =1;
        $gallery->save();
        return redirect()-> route('gallery.index')->with('error','Gallery Delete Succesfull');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(){
        $banners = Banner::all();
        return view('backend.banner.index',compact('banners'),['page_title' => 'App Banner']);
    }

    public function store(Request $request){
        request()->validate([
            'image' => 'required|mimes:png,jpg,jpeg,webp'
        ]);
        $all_banner= Banner::all();
        $all_banner->delete();
        $banner = new Banner;
        if (!empty($request->image)) {
            $file = $request->file('image');
            $banner->image = upload_file($request,'image');
        }
        $banner->save();
        return redirect()->route('banner.index')->with('success','Banner added successfully');
    }

    public function updateBannerStatus(Request $request){
        $banner = Banner::findOrFail($request->id);
        $banner->status = $request->status;
        if ($banner->save()) {
            return 1;
        }
        return 0;
    }

    public function edit($id){
        $banners = Banner::all();
        $edit = Banner::find($id);
        return view('backend.banner.index',compact('banners','edit'),['page_title' => 'Edit Banner']);
    }

    public function update(Request $request, $id){
        request()->validate([
            'image' => 'required|mimes:png,jpg,jpeg,png'
        ]);
        $banner = Banner::find($id);
        if (!empty($request->image)) {
            $file = $request->file('image');
            $banner->image = upload_file($request,'image');
        }
        $banner->save();
        return redirect()->route('banner.index')->with('success','Banner updated successfully');
    }

    public function destroy(Banner $banner){
        $banner->delete();
        return back()->with('error','Banner deleted successfully');
    }
}

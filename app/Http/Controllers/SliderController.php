<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index(){
        $sliders = Slider::all();
        return view('backend.slider.index',compact('sliders'),['page_title' => 'App Slider']);
    }

    public function store(Request $request){
        request()->validate([
            'image' => 'required|mimes:png,jpg,jpeg,webp'
        ]);
        $slider = new Slider;
        if (!empty($request->image)) {
            $file = $request->file('image');
            $slider->image = upload_file($request,'image', false);
        }
        $slider->save();
        return redirect()->route('slider.index')->with('success','Slider added successfully');
    }

    public function updateSliderStatus(Request $request){
        $slider = Slider::findOrFail($request->id);
        $slider->status = $request->status;
        if ($slider->save()) {
            return 1;
        }
        return 0;
    }

    public function edit($id){
        $sliders = Slider::all();
        $edit = Slider::find($id);
        return view('backend.slider.index',compact('sliders','edit'),['page_title' => 'Edit Slider']);
    }

    public function update(Request $request, $id){
        request()->validate([
            'image' => 'required|mimes:png,jpg,jpeg,webp'
        ]);
        $slider = Slider::find($id);
        if (!empty($request->image)) {
            $file = $request->file('image');
            $slider->image = upload_file($request,'image');
        }
        $slider->save();
        return redirect()->route('slider.index')->with('success','Slider update successfully');
    }

    public function destroy(Slider $slider){
        $slider->delete();
        return back()->with('error','Slider deleted successfully');
    }
}

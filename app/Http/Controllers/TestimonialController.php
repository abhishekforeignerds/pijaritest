<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(){
        $testimonials = Testimonial::all();
        return view('backend.testimonial.index',compact('testimonials'),['page_title' => 'Add Testimonials']);
    }

    public function store(Request $request){
        $testimonial = new Testimonial;
        $testimonial->type = $request->type;
        $testimonial->link = $request->link;
        $testimonial->name = $request->name;
        $testimonial->page = $request->page;
        $testimonial->designation = $request->designation;
        $testimonial->description = $request->description;
        if (!empty($request->image)) {
            $file = $request->file('image');
            $testimonial->image = upload_file($request,'image');
        }
        $testimonial->save();
        return redirect()->route('testimonial.index')->with('success','Testimonial added successfully');
    }

    public function edit($id){
        $testimonials = Testimonial::all();
        $edit = Testimonial::find($id);
        return view('backend.testimonial.index',compact('testimonials','edit'),['page_title' => 'Edit Testimonial']);
    }

    public function update(Request $request, $id){
        $testimonial = Testimonial::find($id);
        $testimonial->type = $request->type;
        $testimonial->link = $request->link;
        $testimonial->name = $request->name;
        $testimonial->page = $request->page;
        $testimonial->designation = $request->designation;
        $testimonial->description = $request->description;
        if (!empty($request->image)) {
            $file = $request->file('image');
            $testimonial->image = upload_file($request,'image');
        }
        $testimonial->save();
        return redirect()->route('testimonial.index')->with('success','Testimonial updated successfully');
    }

    public function updateBlogStatus(Request $request){
        $testimonial = Testimonial::findOrFail($request->id);
        $testimonial->status = $request->status;
        if ($testimonial->save()) {
            return 1;
        }
        return 0;
    }

    public function destroy(Testimonial $testimonial){
        $testimonial->delete();
        return back()->with('error','Testimonial deleted successfully');
    }
}

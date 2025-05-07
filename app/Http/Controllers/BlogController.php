<?php

namespace App\Http\Controllers;

use Str;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(){
        $blogs = Blog::all();
        return view('backend.blog.index',compact('blogs'),['page_title' => 'Add Blogs']);
    }

    public function store(Request $request){
        request()->validate([
            'title' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'image' => 'mimes:png,jpg,jpeg,webp'
        ]);
        $blog = new Blog;
        $blog->title = $request->title;
        $blog->title_hindi = $request->title_hindi;
        $blog->short_description = $request->short_description;
        $blog->short_description_hindi = $request->short_description_hindi;
        $blog->description = $request->description;
        $blog->description_hindi = $request->description_hindi;
        if (!empty($request->image)) {
            $file = $request->file('image');
            $blog->image = upload_file($request,'image');
        }
        $blog['slug']=\Str::slug($request->title).'-'.rand();
        $blog->save();
        return redirect()->route('blog.index')->with('success','Blog added successfully');
    }

    public function edit($id){
        $blogs = Blog::all();
        $edit = Blog::find($id);
        return view('backend.blog.index',compact('blogs','edit'),['page_title' => 'Edit Blog']);
    }

    public function update(Request $request, $id){
        $blog = Blog::find($id);
        $blog->title = $request->title;
        $blog->title_hindi = $request->title_hindi;
        $blog->short_description = $request->short_description;
        $blog->short_description_hindi = $request->short_description_hindi;
        $blog->description = $request->description;
        $blog->description_hindi = $request->description_hindi;
        if (!empty($request->image)) {
            $file = $request->file('image');
            $blog->image = upload_file($request,'image');
        }
        $blog->save();
        return redirect()->route('blog.index')->with('success','Blog updated successfully');
    }

    public function updateBlogStatus(Request $request){
        $blog = Blog::findOrFail($request->id);
        $blog->status = $request->status;
        if ($blog->save()) {
            return 1;
        }
        return 0;
    }

    public function destroy(Blog $blog){
        $blog->delete();
        return back()->with('error','Blog deleted successfully');
    }
}

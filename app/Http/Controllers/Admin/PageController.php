<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::orderBy('slug')->paginate(15);
        return view('backend.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('backend.pages.form', ['page' => new Page()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
          'slug'        => 'required|unique:pages,slug',
          'title'       => 'required|string',
          'description' => 'required|string',
          'content'     => 'nullable|string',
        ]);
        // print_r($data);die;
        Page::create($data);
        return redirect()->route('pages.index')
                         ->with('success','Page created.');
    }

    public function edit(Page $page)
    {
        return view('backend.pages.form', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
          'slug'        => 'required|unique:pages,slug,'.$page->id,
          'title'       => 'required|string',
          'description' => 'nullable|string',
          'content'     => 'nullable|string',
        ]);
        $page->update($data);
        return redirect()->route('pages.index')
                         ->with('success','Page updated.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return back()->with('success','Page deleted.');
    }
    
}

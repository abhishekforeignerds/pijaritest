<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function index(){
        $policy = Policy::first();
        return view('backend.policy.index', compact('policy'));
    }

    public function store(Request $request){
        $policy = $request->all();
        Policy::create($policy);
        return back()->with('success', 'Policies updated successfully');
    }

    public function edit(Policy $policy){
        return view('backend.policy.index', compact('policy'));
    }

    public function update(Request $request, $id){
        $policy = Policy::find($id);
        $input = $request->all();
        $policy->update($input);
        return back()->with('success', 'Policies updated successfully');
    }
}

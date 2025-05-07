<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:staff-list|staff-create|staff-edit|staff-delete,admin', ['only' => ['index','store']]);
         $this->middleware('permission:staff-create,admin', ['only' => ['create','store']]);
         $this->middleware('permission:staff-edit,admin', ['only' => ['edit','update']]);
         $this->middleware('permission:staff-delete,admin', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $list = Admin::orderBy('id','DESC')->paginate(5);
        return view('backend.staff.index',compact('list'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('backend.staff.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        if (!empty($request->profile_img)) {
            $file = $request->file('profile_img');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/staff/'), $image);
            $input['profile_img'] = $image;
        }
        $user = Admin::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('staff.index')->with('success','Staff created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Admin::find($id);
        return view('backend.staff.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Admin::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return view('backend.staff.edit',compact('user','roles','userRole'));
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }
        if (!empty($request->profile_img)) {
            $file = $request->file('profile_img');
            $image = time() . "-" . rand(1, 100) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/staff/'), $image);
            $input->profile_img = $image;
        }
        $user = Admin::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('staff.index')->with('success','Staff updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::find($id)->delete();
        return redirect()->route('staff.index')->with('success','Admin deleted successfully');
    }

}

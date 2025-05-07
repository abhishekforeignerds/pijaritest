<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:roles-list|roles-create|roles-edit|roles-delete,admin', ['only' => ['index','store']]);
         $this->middleware('permission:roles-create,admin', ['only' => ['create','store']]);
         $this->middleware('permission:roles-edit,admin', ['only' => ['edit','update']]);
         $this->middleware('permission:roles-delete,admin', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $list = Role::orderBy('id', 'desc')->paginate(10);
        return view('backend.role.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissionParent = Permission::groupBy('parent_name')->get();
        return view('backend.role.create',compact('permissionParent'));
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
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = new Role;
        $role->name=$request->input('name');
        $role->guard_name='admin';
        $role->save();

        $permissions = Permission::where('guard_name','admin')->whereIn('id',$request->input('permission'))->pluck('id','id')->all();
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with('success','Role created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")->where("role_has_permissions.role_id",$id)->get();
        $permissionParent = Permission::groupBy('parent_name')->get();
        return view('backend.role.show',compact('role','rolePermissions','permissionParent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')->all();
        $permissionParent = Permission::groupBy('parent_name')->get();
        return view('backend.role.edit',compact('role','permission','rolePermissions','permissionParent'));
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
            'name' => [
                'required',
                 Rule::unique('roles', 'name')->ignore($id),
            ],
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name=$request->input('name');
        $role->guard_name='admin';
        $role->save();

        $permissions = Permission::where('guard_name','admin')->whereIn('id',$request->input('permission'))->pluck('id','id')->all();
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with('success','Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')->with('success','Role deleted successfully');
    }
}

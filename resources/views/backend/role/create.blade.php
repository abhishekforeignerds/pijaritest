@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Role Create</h6>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('roles.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-sm-4">

                            </div>
                            <div class="col-sm-4">
                                <div class="form-group floating-label mb-2 mt-1">
                                    <label for="text-placeholder">Role Name *</label>
                                    <input type="text" class="form-control" placeholder="Role Name" name="name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">

                            </div>
                            @foreach ($permissionParent as $parent)
                                <div class="col-4">
                                    <div class="card card-outline card-primary rounded-3">
                                        <div class="card-header">
                                            <div class="icheck-primary d-inline">
                                                <label for="all_{{ $parent->parent_name }}">

                                                    {{ str_replace('_', ' ', ucwords(str_replace('-', ' ', $parent->parent_name))) }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="card-body" style="height: 200px; overflow-x: hidden;">
                                            @php $permissions = Spatie\Permission\Models\Permission::where('parent_name', $parent->parent_name)->get(); @endphp
                                            @foreach ($permissions as $value)
                                                <div class="icheck-danger">
                                                    <input type="checkbox" name="permission[]"
                                                        id="roles_{{ $value->name }}" value="{{ $value->id }}">
                                                    <label
                                                        for="roles_{{ $value->name }}">{{ str_replace('_', ' ', ucwords(str_replace('-', ' ', $value->name))) }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btns btn-primary CardBtn">Save</button>
                    </div>
                </form>
            </div>
@endsection

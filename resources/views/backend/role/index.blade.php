@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Role List</h6>
                        </div>
                        <div class="ms-auto"> @if(auth()->guard("admin")->user()->can("roles-create"))<a href="{{ route('roles.create') }}"
                            class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New
                            Role</a>@endif</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    @if(auth()->guard('admin')->user()->canany(['roles-edit','roles-delete']))    <th>Action</th> @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $key => $data)
                                    <tr>
                                        <th scope="row">{{ $key + 1 + ($list->currentPage() - 1) * $list->perPage() }}</th>
                                        <td>{{ explode('_', $data->name)[0] }}</td>
                                        @if(auth()->guard('admin')->user()->canany(['roles-edit','roles-delete']))
                                        <td>
                                            <div class="d-flex order-actions">
                                                @if(auth()->guard("admin")->user()->can("roles-edit"))   <a href="{{ route('roles.edit',$data->id) }}" class="me-2"><i class="bx bxs-edit"></i></a> @endif
                                                {{-- <a href="{{ route('roles.show',$data->id) }}" class=""><i class="bx bxs-show"></i></a></div> --}}
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection

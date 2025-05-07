@extends('backend.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0">Package List</h6>
                    </div>
                    <div class="ms-auto">@if(auth()->guard("admin")->user()->can("product-create"))<a href="{{ route('admin_package_add',$id) }}"
                            class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square">@endif</i>Add New
                            Package</a></div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="datatable">
                        <thead>
                            <tr>
                                <th>Package Name</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Discount Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tbody>
                                @foreach ($list as $data)
                                <tr>
                                    <td>{{$data->package_name}}</td>
                                    <td>{{$data->productData->name}}</td>
                                    <td>{{$data->price}}</td>
                                    <td>{{$data->discount_price}}</td>
                                    <td>
                                        <div class="d-flex order-actions">

                                            <a href="{{route('product_package_edit',$data->id)}}" class="" title="Edit"><i class="bx bxs-edit"></i></a>

                                            <a href="{{route('product_package_delete',$data->id)}}" class="ms-3" title="Delete"><i class="bx bxs-trash"></i></a>

                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>

</script>
@endsection

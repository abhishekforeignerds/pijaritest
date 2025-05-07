@extends('vendor_dashboard.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0">Product List</h6>
                    </div>
                    <div class="ms-auto"><a href="{{route('product.create')}}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Product</a></div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                {{-- <th>Featured</th>
                                <th>Status</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{$product->name}}</td>
                                <td>{{$product->category->name}}</td>
                                {{-- <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" onchange="update_featured(this)"
                                            value="{{ $product->id }}" type="checkbox"
                                            id="flexSwitchCheckChecked"
                                            @if ($product->featured == 1) {{ 'checked' }} @endif>
                                        <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" onchange="update_status(this)"
                                            value="{{ $product->id }}" type="checkbox"
                                            id="flexSwitchCheckChecked"
                                            @if ($product->status == 1) {{ 'checked' }} @endif>
                                        <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                    </div>
                                </td> --}}
                                <td>
                                    <div class="d-flex order-actions">
                                    <a href="{{route('product.edit',$product->id)}}" class=""><i class="bx bxs-edit"></i></a>
                                    <a href="{{route('product.show',$product->id)}}" class=""><i class="bx bxs-show"></i></a>
                                    {{-- <a href="javascript:;" class="ms-3"><i class="bx bxs-trash"></i></a> --}}
                                   </div>
                               </td>
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
    <script>
        function update_featured(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('product.update_featured') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {

                } else {

                }
            });
        }

        function update_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('product.update_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {

                } else {

                }
            });
        }

        function preview() {
            $('#frame').show();
             frame.src=URL.createObjectURL(event.target.files[0]);
            }
    </script>
@endsection

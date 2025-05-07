@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content row">
            @if(auth()->guard("admin")->user()->can("top_achivers-create"))
            <div class="col-md-4">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">{{ !empty($achiver->id) ? 'Edit' : 'Add' }} Achiver</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="pincode" name="pincode" method="post" action="{{ route('top_achiver.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if (!empty($achiver->id))
                                <input type="hidden" name="id" value="{{ $achiver->id }}" />
                            @endif
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Name<span>*</span></label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="@if (!empty($achiver->name)) {{ $achiver->name }} @endif" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="designation" class="form-label">Designation<span>*</span></label>
                                <input type="text" class="form-control" name="designation" id="designation" placeholder="Designation" value="@if (!empty($achiver->designation)) {{ $achiver->designation }} @endif" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Address<span>*</span></label>
                                <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="@if (!empty($achiver->address)) {{ $achiver->address }} @endif" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="photo" class="form-label">Photo</label>
                                <input type="file" class="form-control" id="photo" placeholder="Photo" name="photo"  onchange="preview()">
                                <img id="frame"
                                src="@if(!empty($achiver->full_image_url)){{$achiver->full_image_url}}@endif"
                                style="{{ !empty($achiver->photo) ? 'display:block' : 'display:none' }}" width="100px"
                                height="100px" />
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit"
                                        class="btn btn-primary px-4">{{ !empty($achiver->id) ? 'Update' : 'Submit' }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-md-8">
                <div class="card radius-10">
                    <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Top Achiver List</h6>
                                </div>
                            </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Photo </th>
                                        <th>Address</th>
                                        <th>Designation</th>
                                        @if(auth()->guard('admin')->user()->canany(['top_achivers-edit','top_achivers-delete']))  <th>Action</th> @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($achivers as $achiver_data)
                                    <tr>
                                        <td>{{ $achiver_data->name }}</td>
                                        <td><img src="{{$achiver_data->full_image_url}}" class="product-img-2"></td>
                                        <td>{{ $achiver_data->address}}</td>
                                        <td>{{ $achiver_data->designation}}</td>
                                        @if(auth()->guard('admin')->user()->canany(['top_achivers-edit','top_achivers-delete']))
                                        <td>
                                            <div class="d-flex order-actions">
                                                @if(auth()->guard("admin")->user()->can("top_achivers-edit"))
                                                <a href="{{ route('top_achiver.edit', $achiver_data->id) }}"
                                                    class=""><i class="bx bxs-edit"></i></a> @endif
                                                @if(auth()->guard("admin")->user()->can("top_achivers-delete"))
                                                <a href="{{route('top_achiver.delete', $achiver_data->id)}}" class="ms-3"><i class="bx bxs-trash"></i></a>
                                                @endif
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $achivers->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script>
        function preview() {
            $('#frame').show();
            frame.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection

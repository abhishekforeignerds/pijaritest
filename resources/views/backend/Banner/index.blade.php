@extends('backend.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="page-content row">
        <div class="col-6">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Banner List</h6>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" id="datatable">
                            <thead class="table-light">
                                <tr>
                                    <th>Image</th>
                                    <th>Status</th>
                                    @if(auth()->guard('admin')->user()->canany(['category-edit','category-view']))<th>Action</th> @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banners as $data)
                                <tr>
                                    <td class="text-center">
                                        <img src="{{$data->full_image_url}}" height="50px" width="70px">
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" onchange="update_status(this)"
                                                value="{{ $data->id }}" type="checkbox"
                                                id="flexSwitchCheckChecked"
                                                @if ($data->status == 1 ) {{ 'checked' }} @endif>
                                            <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                        </div>
                                    </td>
                                    @if(auth()->guard('admin')->user()->canany(['pincode-edit','product-delete']))
                                    <td>
                                        <div class="d-flex order-actions">
                                            @if(auth()->guard("admin")->user()->can("pincode-edit"))
                                            <a href="{{ route('banner.edit', $data->id) }}"
                                                class=""><i class="bx bxs-edit"></i>
                                            </a>
                                            @endif
                                            {{-- @if(auth()->guard("admin")->user()->can("pincode-delete"))
                                            <a href="{{route('slider.delete', $data->id)}}" class="ms-3"><i class="bx bxs-trash"></i></a>
                                            @endif --}}
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">

                        <div>
                            @isset($edit)
                            <h6 class="mb-0">Edit Banner</h6>
                            @else
                            <h6 class="mb-0">Add Banner</h6>
                            @endisset
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @isset($edit)
                        <form action="{{route('banner.update',$edit->id)}}" method="post" enctype="multipart/form-data" id="update_form">
                        @method('put')
                    @else
                        <form action="{{route('banner.store')}}" method="post" enctype="multipart/form-data" id="add_form">
                    @endisset
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                                <div class="input-group auth-pass-inputgroup">
                                    <input id="image" type="file" class="form-control" name="image" placeholder="Select Image...">
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <img class="mt-2" id="img" @isset($edit) src="{{$edit->full_image_url}}"
                                @else src="{{asset('backend/images/no-image.jpg')}}" @endisset onerror="this.onerror=null;this.src='{{asset('backend/images/no-image.jpg')}}'" height="80px" width="80px">
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    @isset($edit)
                                    <button type="submit" class="btn btn-primary px-4">Update</button>
                                    @else
                                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        function update_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('banner.update_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {

                } else {

                }
            });
        }
    </script>
    <script>
        image.onchange = evt => {
                    const [file] = image.files
                    if (file) {
                        img.src = URL.createObjectURL(file)
                    }
                }
    </script>
@endsection

@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                @if (auth()->guard('admin')->user()->can('service_city-create'))
                    <div class="col-4">
                        <div class="card radius-10">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-lg-12">
                                        <h6 class="card_title">{{ !empty($pincode->id) ? 'Edit' : 'Add' }} Service City</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="pincode" name="pincode" method="post"
                                    action="{{ route('service_city.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    @if (!empty($pincode->id))
                                        <input type="hidden" name="id" value="{{ $pincode->id }}" />
                                    @endif
                                    <div class="col-md-12 mb-3">
                                        <label for="bsValidation1" class="form-label">City<span>*</span></label>
                                        <input type="text" class="form-control" name="city" id="bsValidation1"
                                            placeholder="City"
                                            value="@if (!empty($pincode->city)) {{ $pincode->city }} @endif" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="city_name_hindi" class="form-label">City Hindi<span>*</span></label>
                                        <input type="text" class="form-control" name="city_name_hindi" id="city_name_hindi"
                                            placeholder="City Hindi"
                                            value="@if (!empty($pincode->city_name_hindi)) {{ $pincode->city_name_hindi }} @endif" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="bsValidation1" class="form-label">State<span>*</span></label>
                                        <input type="text" class="form-control" name="state" id="bsValidation1"
                                            placeholder="State"
                                            value="@if (!empty($pincode->state)) {{ $pincode->state }} @endif" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="state_name_hindi" class="form-label">State Hindi<span>*</span></label>
                                        <input type="text" class="form-control" name="state_name_hindi" id="state_name_hindi"
                                            placeholder="State Hindi"
                                            value="@if (!empty($pincode->state_name_hindi)) {{ $pincode->state_name_hindi }} @endif" required>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label for="image" class="form-label">Image <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input id="image" type="file" class="form-control" name="image"
                                                placeholder="Select Image...">
                                            @error('image')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <img class="mt-2" id="img"
                                            @isset($pincode) src="{{ $pincode->full_image_url }}"
                                 @else src="{{ asset('backend/images/no-image.jpg') }}" @endisset
                                            onerror="this.onerror=null;this.src='{{ asset('backend/images/no-image.jpg') }}'"
                                            height="80px" width="80px">
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="d-md-flex d-grid align-items-center gap-3">
                                            <button type="submit"
                                                class="btn btn-primary px-4">{{ !empty($pincode->id) ? 'Update' : 'Submit' }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-8">
                    <div class="card radius-10">
                        <div class="card-header">
                            <form id="search_form" method="GET" action="{{ route('admin.service_city') }}">
                                <div class="row align-items-center">
                                    <div class="col-lg-4">
                                        <h6 class="card_title">Service City List</h6>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="top_search">
                                            <input class="form-control" type="text" name="q"
                                                value="{{ request('q') }}" placeholder="Search By City">
                                            <button type="submit" class="btn btn-custom radius-30 mt-2 mt-lg-0"><i
                                                    class="bx bxs-zoom-in me-0"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered" style="width:100%">
                                    <thead>
                                        <tr>

                                            <th>City</th>
                                            <th>State</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            @if (auth()->guard('admin')->user()->canany(['service_city-edit', 'service_city-delete']))
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pincodes as $pincode)
                                            <tr>

                                                <td>{{ $pincode->city }}</td>
                                                <td>{{ $pincode->state }}</td>
                                                <td> <img src="{{ $pincode->full_image_url }}" height="50px"
                                                        width="70px"
                                                        onerror="this.onerror=null;this.src='{{ asset('backend/images/no-image.jpg') }}'">
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" onchange="update_status(this)"
                                                            value="{{ $pincode->id }}" type="checkbox"
                                                            id="flexSwitchCheckChecked"
                                                            @if ($pincode->status == 'active') {{ 'checked' }} @endif>
                                                        <label class="form-check-label"
                                                            for="flexSwitchCheckChecked"></label>
                                                    </div>
                                                </td>
                                                @if (auth()->guard('admin')->user()->canany(['service_city-edit', 'service_city-delete']))
                                                    <td>
                                                        <div class="d-flex order-actions">
                                                            @if (auth()->guard('admin')->user()->can('service_city-edit'))
                                                                <a href="{{ route('service_city.edit', $pincode->id) }}"
                                                                    class="me-2" title="Edit"><i
                                                                        class="bx bxs-edit text-info"></i></a>
                                                            @endif
                                                            @if (auth()->guard('admin')->user()->can('service_city-delete'))
                                                                <a href="javascript:void(0);" class="me-2"
                                                                    onclick="confirmDelete('{{ route('service_city.delete', $pincode->id) }}')"
                                                                    title="Delete"><i
                                                                        class="bx bxs-trash text-danger"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $pincodes->links() }}
                            </div>
                        </div>
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
                var status = 'active';
            } else {
                var status = 'inactive';
            }
            $.post('{{ route('service_city.update_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {

                } else {

                }
            });
        }

        function filter() {
            $('#search_form').submit();
        }

        image.onchange = evt => {
            const [file] = image.files
            if (file) {
                img.src = URL.createObjectURL(file)
            }
        }
    </script>
@endsection

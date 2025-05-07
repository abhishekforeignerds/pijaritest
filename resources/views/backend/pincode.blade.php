@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content row">
            @if (auth()->guard('admin')->user()->can('service_city-create'))
                <div class="col-4">
                    <div class="card radius-10">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-lg-12">
                                    <h6 class="card_title">{{ !empty($pincode->id) ? 'Edit' : 'Add' }} Pincode City</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- @if ($errors->any())
                            {{ implode('', $errors->all('<div>:message</div>')) }}
                        @endif --}}
                            <form id="pincode" method="post" action="{{ route('pincode.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="state" value="{{ $pincode->id ?? '' }}">
                                <input type="hidden" name="city" value="{{ $pincode->id ?? '' }}">
                                <div class="col-md-12 mb-3">
                                    <label for="bsValidation1" class="form-label">Select State<span>*</span></label>
                                    <select id="state" name="state" class="form-select" required onchange="getCity()">
                                        <option value="">Select State</option>
                                        @foreach ($uniqueStates as $state)
                                            <option value="{{ $state->state }}"
                                                {{ $selectedState == $state->state ? 'selected' : '' }}>
                                                {{ $state->state }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="bsValidation2" class="form-label">Select City<span>*</span></label>
                                    {{-- <select id="city" name="city" class="form-select" required>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}" {{ $selectedCity == $city->id ? 'selected' : '' }}>
                                            {{ $city->city }}
                                        </option>
                                    @endforeach
                                </select> --}}
                                    <select id="city" name="city" class="form-control">
                                        <option value="">Select City</option>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="bsValidation1" class="form-label">Pincode<span>*</span></label>
                                    <input type="text" class="form-control" name="pincode" id="bsValidation1"
                                        placeholder="Pincode"
                                        value="@if (!empty($pincode->pincode)) {{ $pincode->pincode }} @endif" required>
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
                        <form id="search_form" method="GET" action="{{ route('admin.pincode') }}">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <h6 class="mb-0">Pincode List</h6>
                                </div>
                                <div class="col-lg-8">
                                    <div class="top_search">
                                        <input class="form-control" type="text" name="q"
                                            value="{{ request('q') }}" placeholder="Search By Pincode">
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

                                        <th>Pincode</th>
                                        <th>Status</th>
                                        @if (auth()->guard('admin')->user()->canany(['service_city-edit', 'service_city-delete']))
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pincodes as $pincode)
                                        <tr>
                                            <td>{{ $pincode->pincode }}</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" onchange="update_status(this)"
                                                        value="{{ $pincode->id }}" type="checkbox"
                                                        id="flexSwitchCheckChecked"
                                                        @if ($pincode->status == 'active') {{ 'checked' }} @endif>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                                </div>
                                            </td>
                                            @if (auth()->guard('admin')->user()->canany(['service_city-edit', 'service_city-delete']))
                                                <td>
                                                    <div class="d-flex order-actions">
                                                        @if (auth()->guard('admin')->user()->can('service_city-edit'))
                                                            <a href="{{ route('pincode.edit', $pincode->id) }}"
                                                                class="me-2" title="Edit"><i
                                                                    class="bx bxs-edit text-info"></i></a>
                                                        @endif
                                                        @if (auth()->guard('admin')->user()->can('service_city-delete'))
                                                            <a href="javascript:void(0);" class="me-2"
                                                                onclick="confirmDelete('{{ route('pincode.delete', $pincode->id) }}')"
                                                                title="Delete"><i class="bx bxs-trash text-danger"></i>
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
@endsection
@section('script')
    <script>
        function update_status(el) {
            if (el.checked) {
                var status = 'active';
            } else {
                var status = 'inactive';
            }
            $.post('{{ route('pincode.update_status') }}', {
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
    </script>

    <script>
        @if ($selectedState)
            getCity();
        @endif

        function getCity() {
            var state_id = $('#state').val();
            $.ajax({
                url: "{{ route('get-cities') }}", // Laravel route
                type: "POST",
                data: {
                    state_id: state_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#city').empty();
                    var selectedCity = '{{ $selectedCity }}';
                    $.each(response, function(key, city) {
                        if (selectedCity == city.id) {
                            $('#city').append(
                                `<option value="${city.city}" selected>${city.city}</option>`
                            );
                        } else {
                            $('#city').append(
                                `<option value="${city.city}">${city.city}</option>`
                            );
                        }
                    });
                },
                error: function(xhr) {
                    console.log("Error:", xhr);
                }
            });
        }
    </script>
@endsection

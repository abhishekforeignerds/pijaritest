@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Service List</h6>
                        </div>
                        <div class="ms-auto">@if(auth()->guard("admin")->user()->can("service-create"))<a href="{{ route('admin_service.create') }}"
                                class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New
                                Service</a>@endif</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" id="datatable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Vendor</th>
                                    <th>Featured</th>
                                    <th>Status</th>
                                    @if(auth()->guard('admin')->user()->canany(['service-edit','service-view']))   <th>Action</th> @endif
                                </tr>
                            </thead>
                            <tbody>
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
            $.post('{{ route('admin_service.update_featured') }}', {
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
            $.post('{{ route('admin_service.update_status') }}', {
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
            frame.src = URL.createObjectURL(event.target.files[0]);
        }

        $(document).ready(function() {
            var dataTable = $('#datatable').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                'serverMethod': 'get',
                "sPaginationType": "full_numbers",
                "iDisplayLength": 10,
                //'searching': false, // Remove default Search Control
                'ajax': {
                    'url': '{{ route('admin_service_get_data') }}',
                    'data': function(data) {
                        // Read values
                        var gender = $('#searchByGender').val();
                        var name = $('#searchByName').val();

                        // Append to data
                        data.searchByGender = gender;
                        data.searchByName = name;
                    }
                },
                'columns': [{
                        data: 'name'
                    },
                    {
                        data: 'vendor.name'
                    },

                    {
                        data: 'featured',
                        render: function(data, type, row) {
                            var is_checked = '';
                            if (data == 1) {
                                is_checked = 'checked';
                            }
                            return '<div class="form-check form-switch"> <input class="form-check-input" onchange="update_featured(this)" value="' +
                                row.id + '" type="checkbox"  id="flexSwitchCheckChecked" ' +
                                is_checked +
                                ' ><label class="form-check-label" for="flexSwitchCheckChecked"></label></div>';
                        }
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            var is_checked = '';
                            if (data == 1) {
                                is_checked = 'checked';
                            }
                            return '<div class="form-check form-switch"> <input class="form-check-input" onchange="update_status(this)" value="' +
                                row.id + '" type="checkbox"  id="flexSwitchCheckChecked" ' +
                                is_checked +
                                ' ><label class="form-check-label" for="flexSwitchCheckChecked"></label></div>';
                        }
                    },
                    @if(auth()->guard('admin')->user()->canany(['service-edit','service-view']))   {
                        mRender: function(data, type, row) {
                            return '<div class="d-flex order-actions">@if(auth()->guard("admin")->user()->can("service-edit"))<a href="{{ route('admin_service_edit', '') }}/' +
                                row.id + '" class="me-2"><i class="bx bxs-edit"></i></a>@endif @if(auth()->guard("admin")->user()->can("service-view"))<a href="{{ route('admin_service_view', '') }}/' +
                                row.id + '" class=""><i class="bx bxs-show"></i></a>@endif</div>'
                        }
                    }
                    @endif
                ]
            });

            $('#searchByName').keyup(function() {
                dataTable.draw();
            });

            $('#searchByGender').change(function() {
                dataTable.draw();
            });
        });
    </script>
@endsection

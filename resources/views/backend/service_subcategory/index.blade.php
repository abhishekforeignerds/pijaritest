@extends('backend.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content row">
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Service Sub Category List</h6>
                            </div>
                            <div class="ms-auto">@if(auth()->guard("admin")->user()->can("service_sub_category-create"))<a href="{{ route('service_subcategory.create') }}"
                                class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New
                               Service Category</a>@endif</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" id="datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sub Catgory Name</th>
                                        <th>Catgory Name</th>
                                        <th>Icon</th>
                                        <th>Featured</th>
                                        <th>Status</th>
                                        @if(auth()->guard('admin')->user()->canany(['service_sub_category-edit','service_sub_category-view']))  <th>Action</th> @endif
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
    </div>
    <!--end page wrapper -->
@endsection
@section('script')
    <script>
        function update_featured(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('service_subcategory.update_featured') }}', {
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
            $.post('{{ route('service_subcategory.update_status') }}', {
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
                    'url': '{{ route('service_subcategory_get_data') }}',
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
                        data: 'category.name'
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
                    {
                        data: 'full_image_url',
                        render: function(data) {
                            return '<img src="'+data+'" class="product-img-2" /> ';
                        }
                    },
                    @if(auth()->guard('admin')->user()->canany(['service_sub_category-edit','service_sub_category-view'])) {
                        mRender: function(data, type, row) {
                            return '<div class="d-flex order-actions">@if(auth()->guard("admin")->user()->can("service_sub_category-edit"))<a href="{{ route('service_subcategory_edit', '') }}/' +
                                row.id + '" class="me-2"><i class="bx bxs-edit"></i></a>@endif @if(auth()->guard("admin")->user()->can("service_sub_category-view"))<a href="{{ route('service_subcategory_view', '') }}/' +
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

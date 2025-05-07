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
                                <h6 class="mb-0">Delivery Boy List</h6>
                            </div>
                            <div class="ms-auto">
                                @if(auth()->guard("admin")->user()->can("category-create"))<a href="{{ route('delivery-boy.create') }}"
                                class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New
                                Delivery Boy</a>
                                @endif</div>
                           </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0" id="datatable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Action</th>
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
            $.post('{{ route('brand.update_featured') }}', {
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
            $.post('{{ route('delivery_boy.update_status') }}', {
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
                    'url': '{{ route('delivery_boy_get_data') }}',
                    'data': function(data) {
                        // Read values
                        var gender = $('#searchByGender').val();
                        var name = $('#searchByName').val();

                        // Append to data
                        data.searchByGender = gender;
                        data.searchByName = name;
                    }
                },
                'columns': [
                    {
                        data: 'name'
                    },

                    {
                        data: 'phone'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'address'
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
                    @if(auth()->guard('admin')->user()->canany(['category-edit','category-view'])) {
                        mRender: function(data, type, row) {
                            return '<div class="d-flex order-actions"> @if(auth()->guard("admin")->user()->can("category-edit"))<a href="{{ route('delivery_boy_edit', '') }}/' +
                                row.id + '" class="me-2" title="Edit"><i class="bx bxs-edit"></i></a>@endif</div>'
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

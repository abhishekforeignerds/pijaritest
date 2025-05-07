@extends('backend.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Vendor List</h6>
                        </div>
                        <div class="ms-auto"><a href="{{route('vendor_create')}}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Vendor</a></div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0"  id="datatable" >
                            <thead>
                                <tr>
                                    <th>Join Date</th>
                                    <th>Name</th>
                                    <th>Vendor Code</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Firm Name</th>
                                    <th>Ban/Unban</th>
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
    <!--end page wrapper -->
@endsection
@section('script')
    <script>

        function update_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('vendor.update_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                ban: status
            }, function(data) {
                if (data == 1) {

                } else {

                }
            });
        }

        $(document).ready(function() {
            var dataTable = $('#datatable').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                'serverMethod': 'get',
                "sPaginationType": "full_numbers",
                "iDisplayLength": 10,
                "ordering": true,
                //'searching': false, // Remove default Search Control
                'ajax': {
                    'url': '{{ route('get_vendor') }}',
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
                        data: 'created_at',
                        render: function(data, type, row) {
                            const d = Date.parse(data);
                            var nd = new Date(d);
                            const year = nd.getFullYear();
                            const month = (nd.getMonth() + 1).toString().padStart(2, '0'); // Adding 1 to the month and padding with zeros if needed
                            const day = nd.getDate().toString().padStart(2, '0'); // Padding with zeros if needed
                            return year + '-' + month + '-' + day;
                        }
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'vendor_code'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'firm_name'
                    },
                    {
                        data: 'ban',
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
                        data: 'status',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return  '<p style="color:green;">Paid</p>';
                            }
                            if (data == 0) {
                                return  '<p style="color:red;">Unpaid</p>';
                            }
                        }
                    },
                    {
                        mRender: function(data, type, row) {
                            return '<div class="d-flex order-actions"><a href="{{ route('vendor_edit', '') }}/' +
                                row.id + '" class="me-2"><i class="bx bxs-edit"></i></a><a href="{{ route('vendor_view', '') }}/' +
                                row.id + '" class=""><i class="bx bxs-show"></i></a></div>'
                        }
                    }
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

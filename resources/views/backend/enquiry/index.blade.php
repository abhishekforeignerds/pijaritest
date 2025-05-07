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
                                <h6 class="mb-0">Enquiries</h6>
                            </div>
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
                                        <th>Message</th>
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
    <!--end page wrapper -->
@endsection
@section('script')
    <script>
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
                    'url': '{{ route('enquiry_get_data') }}',
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
                        data: 'message'
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            var seen = '<p style="color:red;">unseen</p>';
                            if (row.status == 1) {
                                seen = '<p style="color:green;">seen</p>';
                            }
                            return seen;
                        }
                    },
                    @if(auth()->guard('admin')->user()->canany(['category-edit','category-view'])) {
                        mRender: function(data, type, row) {
                            return '<div class="d-flex order-actions"> @if(auth()->guard("admin")->user()->can("category-edit"))<a href="{{ route('enquiry_view', '') }}/' +
                                row.id + '" class="me-2"><i class="bx bxs-show"></i></a>@endif  @if(auth()->guard("admin")->user()->can("category-view"))<a href="{{ route('enquiry_delete', '') }}/' +
                                row.id + '" class=""><i class="bx bxs-trash"></i></a>@endif</div>'
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

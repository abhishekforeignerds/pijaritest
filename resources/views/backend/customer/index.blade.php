@extends('backend.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <h6 class="card_title">Customer List</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="small-table-responsive">
                        <table class="table align-middle mb-0" id="datatable">
                            <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Join Date</th>
                                    <th>Basic Details</th>
                                    <th>Contact Details</th>
                                    <th>Stats</th>
                                    @if (auth()->guard('admin')->user()->canany(['customer-edit']))
                                        <th>Action</th>
                                    @endif
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
            $.post('{{ route('customer.update_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
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
                    'url': '{{ route('get_customer') }}',
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
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'created_at',
                        render: function(data, type, row) {
                            const d = Date.parse(data);
                            var nd = new Date(d);
                            const year = nd.getFullYear();
                            const month = (nd.getMonth() + 1).toString().padStart(2,
                                '0'); // Adding 1 to the month and padding with zeros if needed
                            const day = nd.getDate().toString().padStart(2,
                                '0'); // Padding with zeros if needed
                            return year + '-' + month + '-' + day;
                        }
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'contact_details',
                        render: function(data, type, row) {
                            return `phone: ${row.phone} <br> email: ${row.email}`;
                        }
                    },
                    @if (auth()->guard('admin')->user()->canany(['customer-edit', 'customer-view']))
                        {
                            mRender: function(data, type, row) {
                                return '<div class="d-flex">@if (auth()->guard('admin')->user()->can('customer-view'))<a class="btn btn-sm btn-light" href="{{ route('customer_view', '') }}/' +
                                    row.id +
                                    '" class="" title="Puja">Puja Booked</a><a class="btn btn-sm btn-light ms-2" href="{{ route('customer_e_puja', '') }}/' +
                                    row.id +
                                    '" class="ms-1" title="E-puja">E-Puja Booked</a>@endif</div>'
                            }
                        },
                    @endif
                    @if (auth()->guard('admin')->user()->canany(['customer-edit']))
                        {
                            mRender: function(data, type, row) {
                                return '<div class="d-flex order-actions"><a href="{{ route('customer_edit', '') }}/' +
                                    row.id +
                                    '" class="ms-1" title="Edit"><i class="bx bxs-edit text-info"></i></a><a href="{{ route('customer_profile', '') }}/' +
                                    row.id +
                                    '" class="ms-1" title="Profile"><i class="bx bxs-user text-primary"></i></a></div>'
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

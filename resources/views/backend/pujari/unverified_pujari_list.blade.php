@extends('backend.layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <h6 class="card_title">Un-Verified Pujari List</h6>
                        </div>
                        <div class="col-lg-8">
                            <div class="top_search">
                                <select class="form-control" id="city" name="city"
                                    data-placeholder="Please Select City..." onchange="getPincode()">
                                    <option value="">Select City</option>
                                </select>
                                <select id="pincode" class="form-select select2" aria-label="Pincode" name="pincode[]"
                                    id="pincode" multiple>
                                    <option value="">Select Pincode</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="small-table-responsive">
                        <table class="table align-middle mb-0" id="datatable">
                            <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Date</th>
                                    <th>Puajri Detail</th>
                                    <th>Other</th>
                                    <th>Payment</th>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        function update_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('pujari.update_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                ban: status
            }, function(data) {
                if (data == 1) {

                } else {

                }
            });
        }

        function update_verified(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('pujari.update_verified') }}', {
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
                    'url': '{{ route('get_pujari_unverified') }}',
                    'data': function(data) {
                        // Read values
                        var status = $('#status').val();
                        var city = $('#city').val();
                        var pincode = $('#pincode').val();


                        // Append to data
                        data.status = status;
                        data.city = city;
                        data.pincode = pincode;

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
                        mRender: function(data, type, row) {
                            return 'Name:' + row.name + '<br> Id:' + row.pujari_code +
                                '<br> Phone:' + row.phone + '<br> Pincode:' + row.pincode +
                                '<br> City:' + row.city_names
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let banChecked = row.ban == 1 ? 'checked' : '';
                            let verifiedChecked = row.verified == 1 ? 'checked' : '';
                            return `
            <div class="row">
                <div class="form-check form-switch">
                    <input class="form-check-input" onchange="updateStatus(this, 'ban')" value="${row.id}" type="checkbox" ${banChecked}>
                    <label class="form-check-label">Ban</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" onchange="updateStatus(this, 'verified')" value="${row.id}" type="checkbox" ${verifiedChecked}>
                    <label class="form-check-label">Verified</label>
                </div>
            </div>`;
                        }
                    },
                    {
                        data: 'payment',
                        render: function(data, type, row) {
                            return `Withdrawl: ${row.admin_to_pay} <br> Total Earning: ${row.balance}`;
                        }
                    },
                    {
                        mRender: function(data, type, row) {
                            return '<div class="d-flex order-actions"><a href="{{ route('pujari_edit', '') }}/' +
                                row.id +
                                '" class="me-2" title="Edit"><i class="bx bxs-edit text-info"></i></a><a href="{{ route('pujari_view', '') }}/' +
                                row.id +
                                '" class="me-2" title="Show Details"><i class="bx bxs-show text-warning"></i></a><a href="{{ route('pujari_delete', '') }}/' +
                                row.id +
                                '" class="" title="Delete"><i class="bx bxs-trash text-danger"></i></a></div>'
                        }
                    }
                ]
            });

            $('#status').change(function() {
                dataTable.draw();
            });

            $('#city').change(function() {
                dataTable.draw();
            });

            $('#pincode').change(function() {
                dataTable.draw();
            });


        });



        $('#city').select2({
            minimumInputLength: 3,
            allowClear: true,
            ajax: {
                url: '{{ route('admin_city.list') }}',
                dataType: 'json',
                data: function(params) {
                    return {
                        key: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true

            }
        });

        function getPincode() {
            var city_id = $('#city').val();
            $.ajax({
                url: "{{ route('get-pincode') }}", // Laravel route
                type: "POST",
                data: {
                    city_id: city_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#pincode').empty();
                    console.log(response);

                    $.each(response, function(key, city) {
                        $('#pincode').append(
                            `<option value="${city.pincode}">${city.pincode}</option>`
                        );
                    });
                },
                error: function(xhr) {
                    console.log("Error:", xhr);
                }
            });
        }

        $('#pincode').select2({
            placeholder: "Choose one thing",
            allowClear: true
        });
    </script>
@endsection
